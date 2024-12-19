<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    //
    use SoftDeletes;
    protected $table = 'inventories';

    protected $fillable = [
        'stock_name',
        'stock_code',
        'category',
        'quantity',
        'amount_per_qty',
        'unit',
        'supplier',
        'delivery_date',
        'expiration_date',
        'stock_status',
    ];

}
