<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric:|min:0',
            'product_stock' => 'required|numeric:|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
        ]);
        $product->update($validated);
        return response()->json([
            'message' => 'Product updated successfully',
        ], 200);
    }

    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_stock' => 'required',
        ]);
        $product->update($validated);
        return response()->json([
            'message' => 'Stock updated successfully',
        ], 201);
    }

    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
