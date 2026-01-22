<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'grand_total'
    ];

    public static function generateNumber()
    {
        return date('Y') . rand(1, 100);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
