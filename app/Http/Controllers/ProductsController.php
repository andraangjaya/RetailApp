<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{
    //
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric:',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProduct($id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
        ]);
        $product->update($validated);
        return response()->json([
            'message' => 'Product updated successfully',
        ], 200);
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
    }
}
