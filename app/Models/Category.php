<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static string $IMAGE_DEFAULT = 'https://thefoodtech.com/wp-content/uploads/2023/10/PANADERIA-PRINCIPAL-1.jpg';

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'image',
        'isDeleted',
    ];

    /**
     * Get the name of the category by its ID.
     *
     * @param int $id
     * @return string|null
     */
    public static function getNameById($id)
    {
        $category = self::find($id);
        return $category ? $category->id : null;
    }

    /**
     * Get the ID of the category by its name.
     *
     * @param string $name
     * @return int|null
     */
    public static function getIdByName($name)
    {
        $category = self::where('name', $name)->first();
        return $category ? $category->id : null;
    }

    /**
     * Get all category names.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getNames()
    {
        return self::pluck('name');
    }

    /**
     * Update products with a specific category to uncategorized.
     *
     * @param int $id
     * @return void
     */
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

    /**
     * Scope a query to search products by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"]);

        if ($category && $category->id != 1) {
            $query->where('category_id', $category);
        }

        return $query;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
