<?php

namespace Jazer\Multimedia\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * \Jazer\Multimedia\Http\Controllers\Utility\NumberToBoolean::convert('number');
 */

class NumberToBoolean extends Controller
{
    public static function convert($number) {
        if($number == 0) {
            return [
                "number"    => $number,
                "boolean"   => false
            ];
        }
        else if($number == 1) {
            return [
                "number"    => $number,
                "boolean"   => true
            ];
        }
        else {
            return [
                "number"    => $number,
                "boolean"   => false
            ];
        }
    }
}
