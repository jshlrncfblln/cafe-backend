<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventoryResources;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $inventoryQuery = Inventory::query();

        // Check if there is a request to sort by status (restock)
        if ($request->has('sort_by') && $request->sort_by == 'stock_status') {
            // Sort by status first, then by stock_code
            $inventoryQuery->orderByRaw("FIELD(stock_status, 'Available', 'Low Stock', 'Last Stock', 'No Stock')");
        } else {
            // Default sorting by stock_code
            $inventoryQuery->orderBy('stock_code');
        }

        $inventory = $inventoryQuery->get();

        // Assign status dynamically if not already set (use getStatus method)
        $inventory->each(function ($item) {
            $item->status = $this->getStatus($item->quantity);
        });

        return response()->json($inventory);
    }


    public function show($id)
    {
        return Inventory::find($id);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'stock_name' => 'required|string',
            'stock_code' => 'required|string',
            'category' => 'required|string',
            'amount_per_qty' => 'required|integer',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'supplier' => 'required|string',
            'delivery_date' => 'required|date',
            'expiration_date' => 'required|date',
        ]);

        // Create a new inventory record
        $inventory = Inventory::create($validatedData);

        // Set the stock status based on the quantity
        $inventory->stock_status = $this->getStatus($inventory->quantity);

        // Save the inventory record with the status
        $inventory->save();

        // Return the newly created inventory record
        return new InventoryResources($inventory);
    }


    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }

        $validatedData = $request->validate([
            'stock_name' => 'required|string',
            'stock_code' => 'required|string',
            'category' => 'required|string',
            'amount_per_qty' => 'required|integer',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'supplier' => 'required|string',
            'delivery_date' => 'required|date',
            'expiration_date' => 'required|date',
        ]);

        $inventory->update($validatedData);

        return response()->json($inventory, 200);
    }

    public function restock(Request $request, $id)
    {
        // Find the existing inventory record
        $inventory = Inventory::find($id);

        // If inventory doesn't exist, return an error response
        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }

        // Validate the request data for the restock
        $validatedData = $request->validate([
            'amount_per_qty' => 'required|integer',
            'quantity' => 'required|integer', // This is the new quantity (not added to the old stock)
            'unit' => 'required|string',
            'delivery_date' => 'required|date',
            'expiration_date' => 'required|date',
        ]);

        // Update the status of the existing inventory to "Last Stock"
        $inventory->stock_status = 'Last Stock';
        $inventory->save();

        // Create a new inventory record for the restocked item
        $restockedInventory = Inventory::create([
            'stock_name' => $inventory->stock_name,
            'stock_code' => $inventory->stock_code,
            'category' => $inventory->category,
            'amount_per_qty' => $validatedData['amount_per_qty'],
            'quantity' => $validatedData['quantity'], // This is the new quantity for the restock
            'unit' => $validatedData['unit'],
            'supplier' => $inventory->supplier,
            'delivery_date' => $validatedData['delivery_date'],
            'expiration_date' => $validatedData['expiration_date'],
        ]);

        // Set the stock status for the newly created inventory based on the new quantity
        $restockedInventory->stock_status = 'Available';

        // Save the new restocked inventory record
        $restockedInventory->save();

        // Return the newly created restocked inventory record
        return new InventoryResources($restockedInventory);
    }


    public function getStatus($quantity)
    {
        if ($quantity > 10) {
            return 'Available';
        } elseif ($quantity <= 10 && $quantity > 0) {
            return 'Low Stock';
        } elseif ($quantity == 0) {
            return 'No Stock';
        } else {
            return 'Last Stock';
        }
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }

        $inventory->delete();

        return response()->json(['message' => 'Inventory deleted'], 200);
    }
}
