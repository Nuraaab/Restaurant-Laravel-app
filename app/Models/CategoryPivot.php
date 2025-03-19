<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPivot extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'category_id'];
}
