<?php

namespace App\Helpers\Utils;

class StringUtils
{
    public static function isNullOrWhiteSpace(?string $str)
    {
        return $str === null || trim($str) === '';
    }
}
