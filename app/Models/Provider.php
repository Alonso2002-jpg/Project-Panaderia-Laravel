<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    public static string $IMAGE_DEFAULT = 'https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg';
    protected $table = 'providers';

    protected $fillable = [
        'name',
        'nif',
        'telephone',
        'image',
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

    public static function changeProductsProviderToNotProvider($id){
        Product::where('provider_id', '=', $id)->update(['provider_id' => 1]);
    }
}
