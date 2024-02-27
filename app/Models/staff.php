<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class staff
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'dni',
        'lastname',
        'startDate',
        'endDate',
        'updateDate',
        'creationDate',
        'image',
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
        'updateDate' => 'date',
        'creationDate' => 'date',
    ];
}
