<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'model_type',
        'model_id',
        'collection_name',
        'type',
        'file_path',
        'gallery',
        'mime_type'
    ];

    protected $casts = [
        'model_type' => 'string',
        'model_id' => 'integer',
        'collection_name' => 'string',
        'type' => 'string',
        'gallery' => 'array'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function onlinePaymentLogo(): BelongsTo
    {
        return $this->belongsTo(OnlinePayment::class);
    }

    public function offlinePaymentLogo(): BelongsTo
    {
        return $this->belongsTo(OfflinePayment::class);
    }
}
