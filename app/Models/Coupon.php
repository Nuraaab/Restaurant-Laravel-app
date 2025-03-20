<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_type', 'discount_amount', 'max_use', 'use_count',
        'start_date', 'end_date', 'min_order_amount', 'status'
    ];

    
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'coupon_pivot');
    }
}
