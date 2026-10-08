<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transports extends Model
{
    protected $table = 'transports';

    protected $fillable = ['name', 'price', 'status'];

    public $timestamps = true;

    protected $casts = [
        'price' => 'float',

    ];

    
}
