<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';

    protected $fillable = [
        'street',
        'number',
        'city',
        'province',
        'country',
        'postCode'
    ];

   public function client(){
       return $this->belongsTo(Client::class);
   }
}
