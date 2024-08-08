<?php

declare(strict_types=1);

namespace App\Services;

class StringPipesService
{
    private function __construct()
    {
    }

    public static function amountToFormatedString($amount)
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '')
            . '$' . number_format(abs($amount), 2);
    }

    public static function dateToFormatedString($date)
    {
        $dateArray = explode('-', $date);
        $timeStamp = mktime(0, 0, 0, (int)$dateArray[1], (int)$dateArray[2], (int)$dateArray[0]);

        return date('F j, Y', $timeStamp);
    }
}
