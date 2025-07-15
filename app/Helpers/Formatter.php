<?php

namespace App\Helpers;

use Carbon\Carbon;

class Formatter
{
    /**
     * Constants for date formats
     */
    public const DATE_TIME_FORMAT = 'M d, Y H:i';
    public const DATE_FORMAT = 'M d, Y';

    /**
     * Method to format date time like Jul. 1, 2022 12:00
     *
     * @param  string  $dateTime  date to format
     * @return string formatted date
     *
     * @author Angel Mendoza
     */
    public static function dateTime($dateTime): string
    {
        Carbon::setLocale('es');
        $dateTime = Carbon::parse($dateTime);

        return $dateTime->translatedFormat(self::DATE_TIME_FORMAT);
    }

    /**
     * Method to format date like Jul. 1, 2022
     *
     * @param  string  $date  date to format
     * @return string formatted date
     *
     * @author Angel Mendoza
     */
    public static function date($date): string
    {
        Carbon::setLocale('es');
        $date = Carbon::parse($date);

        return $date->translatedFormat(self::DATE_FORMAT);
    }

}
