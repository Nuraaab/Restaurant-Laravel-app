<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponPivot extends Model
{
    use HasFactory;
    protected $fillable = ['coupon_id', 'customer_id'];
   
}
