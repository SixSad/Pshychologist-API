<?php

namespace App\Helpers;

use Carbon\Carbon;
use Egal\Core\Session\Session;

class DateHelper
{
    public static function getDate($weekday, $tz = 0, $flag = false, $format = 'YYYY-MM-DD'): Carbon|string
    {
        if ($flag) {
            return Carbon::today($tz)->weekday($weekday) >= Carbon::today($tz)
                ? Carbon::today($tz)->weekday($weekday)->isoFormat($format)
                : Carbon::today($tz)->addDays(7)->weekday($weekday)->isoFormat($format);
        }
        return Carbon::today($tz)->weekday($weekday) >= Carbon::today($tz)
            ? Carbon::today($tz)->weekday($weekday)
            : Carbon::today($tz)->addDays(7)->weekday($weekday);
    }

    public static function convertTimezone($time, $newTz = 0, $currentTz = 0, $flag = false, $format = 'YYYY-MM-DD HH:00:00'): Carbon|string
    {
        if ($flag) {
            return Carbon::parse($time, $currentTz)->tz($newTz)->locale('ru')->isoFormat($format);
        }
        return Carbon::parse($time, $currentTz)->tz($newTz)->locale('ru');
    }

    public static function dateTimeConcat(string $date, string $time): string
    {
        return $date . ' ' . $time;
    }

}
