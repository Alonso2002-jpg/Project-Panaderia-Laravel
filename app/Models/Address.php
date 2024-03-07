<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'lastName',
        'dni',
        'street',
        'number',
        'city',
        'province',
        'country',
        'postCode',
        'additionalInfo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
