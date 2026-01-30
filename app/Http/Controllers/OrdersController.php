<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function store(Request $request, OrderService $orderService)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $order = $orderService->create($validated);

        return response()->json([
            'message' => 'Order created',
            'order' => $order
        ], 201);
    }

    public function index()
    {
        return Order::all();
    }
}
