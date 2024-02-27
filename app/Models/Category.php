<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'isDeleted',
    ];

    public static function getNameById($id)
    {
        $category = self::find($id);
        return $category ? $category->id : null;
    }

    public static function getIdByName($name)
    {
        $category = self::where('name', $name)->first();
        return $category ? $category->id : null;
    }

    public function updateProductWithOutCategory($id)
    {
        $products = Product::where('category_id', $id)->get();

        if ($products->count() > 0) {
            foreach ($products as $product) {
                $product->category_id = 1;
                $product->save();
            }
        }
    }

    public static function getNames(){
        return self::pluck('name');
    }

    public function scopeSearch($query, $search){
        return $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"]);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

}
