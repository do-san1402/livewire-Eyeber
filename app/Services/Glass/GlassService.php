<?php

namespace App\Services\Glass;

class GlassService{
    
    public static function makeSerialNumber($glass, $setting_number, $stone =  0): string
    {  
        $num = $setting_number;
        $num_padded = sprintf("%06d", $num);
        $glass =  strtoupper($glass);
        if(!$stone){
            $serialNumber =  str_split($glass)[0] . date('ym') . $num_padded ;
        }else{
            $serialNumber =  str_split($glass)[0] . str_split($glass)[1] . date('ym') . $num_padded ;
        }
        return $serialNumber;
    }

}