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
        'nif',
        'telephone',
        'isDeleted'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFiltrarProvider($query, $search)
    {
        return $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"])
            ->orWhereRaw('LOWER(nif) LIKE ?', ["%" . strtolower($search) . "%"]);
    }
}
