<?php

class Validator
{
    public function check_int($value)
    {
       if(
           filter_var($value, FILTER_VALIDATE_INT) != false &&
           is_numeric($value) &&
           $value == round($value, 0) )
       {
           return true;
       }
       else
       {
           return false;
       }
    }

    public function check_float($value)
    {
       if(
           is_numeric($value) &&
           filter_var($value, FILTER_VALIDATE_FLOAT)  != false
       )
       {
           return true;
       }
       else
       {
           return false;
       }
    }


    //email
}