<?php
namespace App\Helpers;

use App\Voters;

class CustomHelper {
    public static function DateNormalize($date, $toDB=null) {
        $date = ($toDB) ? str_replace("/","-",$date) : str_replace("-","/",$date);
        $date = preg_split("~[\s/-]+~", $date);
        $date = ($toDB) ? $date = $date[2] . '-' . $date[1] . '-' . $date[0] : $date = $date[2] . '/' . $date[1] . '/' . $date[0];
        return $date;
    }

    public static function UniqueVoters($column = null, $data)
    {
        if ($column == 'nim' || $column == 'token' || $column == 'nmor_wa') {
            $voter = Voters::where($column, $data)->first();
            if ($voter) {
                return false;
            }
            return true;
        }
        return false;
    }
}

?>