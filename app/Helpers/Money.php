<?php

namespace App\Helpers;

class Money
{
    public const IVA = 0.16;

    /**
     * Method to format money like $123.45
     *
     * @param  string  $money  quantity to format
     * @return string formatted quantity
     *
     * @author Angel Mendoza
     */
    public static function format($money): string
    {
        return '$'.number_format($money, 2, '.', ',');
    }

}
