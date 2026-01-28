<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Receipt;
use Exception;
use Illuminate\Support\Facades\DB;

class ReceiptService
{
    public function create(array $orderIds): Receipt
    {
        return DB::transaction(function () use ($orderIds) {
            $usedOrders = Order::whereIn('id', $orderIds)
                ->whereNotNull('receipt_id')
                ->pluck('id');

            if ($usedOrders->isNotEmpty()) {
                throw new Exception('Some orders have been created for this receipt :' . $usedOrders->implode(', '));
            }

            $orders = Order::whereIn('id', $orderIds)
                -> whereNull('receipt_id')
                -> get();

            $grandTotal = $orders->sum('total');

            $receipt = Receipt::create([
                'receipt_number' => Receipt::generateNumber(),
                'grand_total' => $grandTotal,
            ]);

            Order::whereIn('id', $orders->pluck('id'))
                ->update(['receipt_id' => $receipt->id]);

            return $receipt;
        });
    }
}
