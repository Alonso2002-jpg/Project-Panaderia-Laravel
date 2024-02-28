<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'totalItems',
        'totalPrice',
        'tax',
        'total',
        'open'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderLines(){
        return $this->hasMany(OrderLine::class);
    }

}
