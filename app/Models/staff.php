<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    public static string $IMAGE_DEFAULT = 'https://via.placeholder.com/150';
    protected $table = 'staff';

    protected $fillable = [
        'id',
        'name',
        'dni',
        'email',
        'lastname',
        'startDate',
        'endDate',
        'image',
        'isDelete',
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
    ];
    protected $keyType = 'string';

    /**
     * Get the user that owns the staff
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"])
            ->orWhereRaw('LOWER(dni) LIKE ?', ["%" . strtolower($search) . "%"])
            ->orWhereRaw('LOWER(lastname) LIKE ?', ["%" . strtolower($search) . "%"]);
    }

}
