<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'stock_name' => $this->stock_name,
            'stock_code' => $this->stock_code,
            'category' => $this->category,
            'amount_per_qty' => $this->amount_per_qty,
            'quantity' => $this->quantity,
            'max_quantity' => $this->max_quantity,
            'unit' => $this->unit,
            'supplier' => $this->supplier,
            'delivery_date' => $this->delivery_date,
            'expiration_date' => $this->expiration_date,
            'stock_status' => $this->getStockStatus(), // Add stock status based on thresholds
            'percentage' => $this->getStockPercentage(), // Calculate and return the stock percentage
        ];
    }

    /**
     * Get the stock status based on quantity percentage.
     *
     * @return string
     */
    private function getStockStatus()
    {
        $percentage = $this->getStockPercentage();

        if ($percentage <= 0) {
            return 'No Stock';
        } elseif ($percentage <= 5) { // Low stock threshold (5% or less)
            return 'Low Stock';
        } elseif ($percentage <= 10) { // Last stock threshold (5-10%)
            return 'Last Stock';
        } else {
            return 'Available';
        }
    }

    /**
     * Get the stock percentage.
     *
     * @return float
     */
    private function getStockPercentage()
    {
        if ($this->max_quantity == 0) {
            return 0;
        }

        return ($this->quantity / $this->max_quantity) * 100;
    }
}
