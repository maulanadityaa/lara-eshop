<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $guarded = [];
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'email',
        'nohp',
        'address',
        'city',
        'province',
        'postal_code',
        'courier',
        'noresi',
        'total_price',
        'status',
        'message',
    ];
}
