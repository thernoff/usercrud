<?php

namespace Application\Components;

class Validator
{
    public static function validateEmpty($arr, $arrSkippedFields = [])
    {
        foreach ($arr as $key => $item){
            if (empty($item) && $item!==0 && !in_array($key, $arrSkippedFields)){
                return false;
            }
        }

        return true;
    }
    
    public static function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}