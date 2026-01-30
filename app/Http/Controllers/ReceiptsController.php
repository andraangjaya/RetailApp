<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Receipt;
use App\Services\ReceiptService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class ReceiptsController extends Controller
{
    public function store(ReceiptService $receiptService)
    {
        $validated = request()->validate([
            'orders' => 'required|array|min:1',
            'orders.*' => 'integer|exists:orders,id'
        ]);

        try {
            $receipt = $receiptService->create($validated['orders']);

            return response()->json([
                'message' => 'Receipt Successfully Created',
                'receipt' => $receipt->load('orders')
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 409);
        }
    }

    public function index()
    {
        $receipts = Receipt::with('orders')->get();
        return response()->json([$receipts]);
    }
}
