<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class OnlinePayment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'information', 'status'];
    protected $casts = [
        'information' => 'array', // Ensure JSON is properly handled
        'status' => 'boolean', // Ensure status is treated as a boolean
    ];

    public function logo():MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('type', 'image')->where('collection_name', 'logo');
    }
}
