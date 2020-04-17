<?php


class fileUtil
{
    public static function convertFileSize($size){
        $size = $size / 1024;
        $unit = array("K","M","G");
        foreach ($unit as $item){

            if ($size> 1000){
                $size = $size / 1024;
            }else{
                break;
            }
        }
        return number_format($size,2,'.','') . " ". $item;
    }
}