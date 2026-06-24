<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer_Service extends Model
{
    protected $table = 'contact_service';

    protected $fillable = [
        'nama',
        'nomor',
    ];
    // ini mau di buat slug agar bisa di kaitkatn
}
