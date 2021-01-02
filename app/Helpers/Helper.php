<?php
namespace App\Helpers;


class CustomHelper {
    public static function DateNormalize($date, $toDB=null) {
        $date = ($toDB) ? str_replace("/","-",$date) : str_replace("-","/",$date);
        $date = preg_split("~[\s/-]+~", $date);
        $date = ($toDB) ? $date = $date[2] . '-' . $date[1] . '-' . $date[0] : $date = $date[2] . '/' . $date[1] . '/' . $date[0];
        return $date;
    }
}

?>