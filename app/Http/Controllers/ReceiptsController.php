<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Receipt;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReceiptsController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'orders' => 'required|array|min:1',
            'orders.*' => 'integer|exists:orders,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $orderIds = $validator->validated()['orders'];

        $usedOrder = Order::whereIn('id', $orderIds)
            ->whereNotNull('receipt_id')
            ->pluck('id');

        if ($usedOrder->isNotEmpty()) {
            return response()->json([
                'error' => 'order already have receipt',
                'used_order_id' => $usedOrder
            ], 409);
        }

        DB::transaction(function () use ($orderIds) {
            $orders = Order::whereIn('id', $orderIds)
                ->whereNull('receipt_id')
                ->get();

            $grandTotal = $orders->sum('total');

            $receipt = Receipt::create([
                'receipt_number' => Receipt::generateNumber(),
                'grand_total' => $grandTotal
            ]);

            Order::whereIn('id', $orders->pluck('id'))
                ->update(['receipt_id' => $receipt->id]);
        });

        return response()->json([
            'message' => 'Receipt created successfully'
        ], 201);
    }

    public function index()
    {
        $receipts = Receipt::with('orders')->get();
        return response()->json([$receipts]);
    }
}
