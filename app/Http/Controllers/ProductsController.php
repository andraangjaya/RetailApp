<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\ProductService;

class ProductsController extends Controller
{
    //
    public function store(Request $request, ProductService $productService)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'required|numeric|min:0',
        ]);

        $product = $productService->create($validated);

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

    public function update(Request $request, Product $product, ProductService $productService,)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
        ]);

        $product = $productService->update($validated, $product);

        return response()->json([
            'message' => 'Product updated successfully',
            'updated_product' => $product
        ], 201);
    }

    public function updateStock(Request $request, Product $product, ProductService $productService)
    {
        $validated = $request->validate([
            'product_stock' => 'required',
        ]);

        $product = $productService->update($validated, $product);

        return response()->json([
            'message' => 'Stock updated successfully',
            'updated_product_stock' => $product->id
        ], 201);
    }

    public function destroy(Product $product, ProductService $productService)
    {
        $productService->delete($product);
        return response()->json([
            'message' => 'Product deleted successfully',
            'deleted_product_id' => $product->id
        ], 200);
    }
}
