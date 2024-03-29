<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $guarded = [];
    protected $table = 'orders';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'user_id',
        'fname',
        'lname',
        'email',
        'nohp',
        'address',
        'city',
        'province',
        'postal_code',
        'ongkir',
        'courier',
        'noresi',
        'total_price',
        'status',
        'message',
    ];

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
