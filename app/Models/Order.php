<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'receipt_id',
        'quantity',
        'product_price',
        'total'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            DB::transaction(function() use($order){
                if($order->quantity <= 0){
                    throw new \Exception('Quantity must be greater than 0');
                }

                $product = Product::where('id', $order->product_id)
                    ->lockForUpdate()
                    ->firstOrfail();

                if($product->product_stock < $order->quantity){
                    throw new \Exception('Insufficient Stock');
                }

                $order->product_price = $product->product_price;
                $order->total = $order->quantity * $product->product_price;

                $product->decrement('product_stock', $order->quantity);
            });
        });
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }
}
