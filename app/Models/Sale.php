<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'product_price',
        'total'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $product = Product::find($sale->product_id);

            if (! $product) {
                throw new \Exception('Product not found');
            }

            $sale->product_price = $product->product_price;

            if($sale->quantity <= 0){
                throw new \Exception('Quantity must be greater than 0');
            }

            $sale->total = $sale->quantity * $product->product_price;
        });
    }
}
