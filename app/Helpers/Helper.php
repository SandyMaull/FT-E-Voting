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

    public static function UniqueVoters($data, $column = null)
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

    public static function ExplodeStringSpacing($data, $numbering = null)
    {
        $exploded = explode("\r\n", $data);
        if($numbering) {
            $loop = 1;
            foreach ($exploded as $eachdata) {
                $finaldata[$loop] = $loop . '.' . $eachdata;
                $loop += 1;
            }
        }
        $finaldata = json_encode($finaldata, JSON_UNESCAPED_UNICODE);
        return $finaldata;
    }

    public static function ImplodeStringSpacing($data, $numbering = null, $separate = null)
    {
        $dataparse = json_decode($data, true);
        if ($dataparse != null) {
            $count = count((array) $dataparse);
            $finaldata = [];
            if ($numbering) {
                $loop = 1;
                for ($i=0; $i < $count; $i++) { 
                    $finaldata[$i] = substr(substr($dataparse[$loop], strpos($dataparse[$loop], ".")), 1);
                    $loop += 1;
                }
            }
            if ($separate) {
                $dataparse = implode(", \r\n",(array) $finaldata);
            }
            else {
                $dataparse = implode("\r\n",(array) $finaldata);
            }
            return $dataparse;
        }
        else {
            return $data;
        }
    }
}

?>