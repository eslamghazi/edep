<?php

use App\Helpers\DateHelper;

if (!function_exists('formatDate')) {
    /**
     * Format date with localized AM/PM
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    function formatDate($date, $format = 'Y-m-d g:i A')
    {
        return DateHelper::formatWithLocale($date, $format);
    }
}
