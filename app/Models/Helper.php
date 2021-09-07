<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    use HasFactory;

    /**
     * Format K dan M style
     * Membuat format 1K dan seterusnya
     */
    function thousandsCurrencyFormat($value) {
        if ($value > 999 && $value <= 999999) {
            $result = round($value / 1000, 2) . ' Ribu';
        } elseif ($value > 999999) {
            $result = round($value / 1000000, 2) . ' Juta';
        } elseif ($value > 999999999) {
            $result = round($value / 1000000000, 2) . ' Milyar';
        } else {
            $result = $value;
        }
        return "Rp $result";
    }

    /**
     * Format K dan M style
     * Membuat format 1K dan seterusnya
     */
    function thFormat($value) {
        if ($value > 999 && $value <= 999999) {
            $result = round($value / 1000, 2) . ' Ribu';
        } elseif ($value > 999999) {
            $result = round($value / 1000000, 2) . ' Juta';
        } elseif ($value > 999999999) {
            $result = round($value / 1000000000, 2) . ' Milyar';
        } else {
            $result = $value;
        }
        return "$result";
    }
}
