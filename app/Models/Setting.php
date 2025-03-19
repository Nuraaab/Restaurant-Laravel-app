<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'receipt_footer', 'receipt_header', 'receipt_stamp', 'currency', 'logo', 
        'primary_color', 'secondary_color', 'sender_email', 'sender_name', 
        'map_link', 'tax', 'restaurant_name', 'delivery_charge'
    ];
}
