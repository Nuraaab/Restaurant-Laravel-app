<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'slug', 'status', 'featured', 'discount_type',
        'discount_amount', 'discount_start_date', 'discount_end_date', 'price', 'flash', 'tag'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_pivot');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
