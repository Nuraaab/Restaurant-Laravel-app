<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckFlashItem
{
    public static function isFlashItem(int $itemId)
    {
        $item = Product::findOrFail($itemId);
    
        // Set the correct timezone (e.g., Africa/Addis_Ababa for GMT+3)
        $localTimezone = 'Africa/Addis_Ababa';
    
        // Convert stored database values (which are likely in UTC) to the local timezone
        $currentDate = Carbon::now($localTimezone); // Get current date in local timezone
        $startDate = Carbon::parse($item->discount_start_date)->timezone($localTimezone); // Start date in local timezone
        $endDate = Carbon::parse($item->discount_end_date)->timezone($localTimezone); // End date in local timezone
    
        // Debugging
        // dd([
        //     'start_date' => $startDate,
        //     'end_date' => $endDate,
        //     'current_date' => $currentDate,
        //     'condition' => ($startDate <= $currentDate && $endDate >= $currentDate),
        // ]);
    
        // // Check if current time falls within the flash sale period
        if ($startDate <= $currentDate && $endDate >= $currentDate) {
            return 1; // Flash sale active
        }
    
        return 0; // Not in flash sale
    }
    
    
}