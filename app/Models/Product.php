<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'slug', 'status', 'featured', 'discount_type',
        'discount_amount', 'discount_start_date', 'discount_end_date', 'price', 'flash', 'tag'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_pivots');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function gallery()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'gallery')
            ->where('type', 'image');
    }

    public function thumbnail()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'thumbnail')
            ->where('type', 'image');
    }
}
