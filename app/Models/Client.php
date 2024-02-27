<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'fullName',
        'dni',
        'telephone',
        'isDeleted'
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
