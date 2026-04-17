<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'shipping_cost',
        'payment_method',
        'subtotal',
        'total',
        'status',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
