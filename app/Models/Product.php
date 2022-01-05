<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillabe = [
        'cate_id',
        'name',
        'slug',
        'description',
        'original_price',
        'sell_price',
        'image',
        'stock',
        'size',
        'status',
        'trending',
    ];
}
