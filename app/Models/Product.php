<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public static string $IMAGE_DEFAULT = 'https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg';
    protected $table = 'products';

    protected $fillable = [
        'description',
        'name',
        'price',
        'stock',
        'image',
        'category_id',
        'provider_id',
        'isDeleted'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function scopeFiltrar($query, $search, $category, $provider)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"]);
        })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', '=', $category);
            })
            ->when($provider, function ($query) use ($provider){
                $query->where('provider_id', '=', $provider);
            });
    }

}

