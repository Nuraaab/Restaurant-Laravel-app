<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'total', 'sub_total', 'discount_amount', 'coupon_discount', 
        'first_name', 'last_name', 'country', 'city', 'address', 'email', 'phone_number', 
        'payment_method', 'payment_type', 'currency_code', 'payment_status', 'order_status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
