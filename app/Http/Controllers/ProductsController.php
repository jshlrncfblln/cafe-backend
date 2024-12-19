<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index()
    {
        return Products::all();
    }

    public function show($id)
    {
        return Products::find($id);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'product_price' => 'required|numeric',
        ]);

        // Save the product to the database
        Products::create($validated);

        return response()->json(['message' => 'Product created successfully!'], 201);
    }

}
