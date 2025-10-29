<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format date with localized AM/PM
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    public static function formatWithLocale($date, $format = 'Y-m-d g:i A')
    {
        $formattedDate = Carbon::parse($date)->format($format);

        // Replace AM/PM based on locale
        if (app()->getLocale() === 'ar') {
            return str_replace(['AM', 'PM'], ['ص', 'م'], $formattedDate);
        }

        return $formattedDate;
    }
}
