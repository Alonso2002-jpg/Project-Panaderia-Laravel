<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $table = 'providers';

    protected $fillable = [
        'name',
        'NIF',
        'telephone',
        'correo',
        'isDeleted'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
