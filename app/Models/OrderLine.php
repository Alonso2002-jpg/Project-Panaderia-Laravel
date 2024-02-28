<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'stock',
        'unitPrice',
        'linePrice'
    ];

    protected function order(){
        return $this->belongsTo(Order::class);
    }

    protected function product() {
        return $this->belongsTo(Product::class);
    }
}
