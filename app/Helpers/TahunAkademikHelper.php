<?php

namespace App\Helpers;

use Carbon\Carbon;

class TahunAkademikHelper
{
    public static function generateYears()
    {
        $now = Carbon::parse(now())->format('Y');
        $years = [];

        for ($i=$now; $i >= 1993; $i--) {
            array_push($years, $i);
        }

        return $years;
    }
}
