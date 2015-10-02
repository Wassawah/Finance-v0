<?php

namespace Api;

class Functions
{
	//if error, throw and stop action
    public static function error($code, $msg) 
    {
        $error = new \stdClass();
        $error->code = $code;
        $error->msg = $msg;

        //throw back msg and error
    	throw new \Exception($error->msg, $error->code);
    }
    
    //check date function (set date)
    public static function checkDate($date, $class) 
    {
        //check if set and date null
        //return error
        if(!isset($class->date) && $date == null) {
            //return error code and msg if there is no date set;
            $error = Functions::error(100, "Date is not set");
        } else if ($date == null) {
            //set date from class
            $date = $class->date;
        }
        //check if format is right
        $date = date_create_from_format('d.m.Y', $date);
        //if format is not correct
        if($date == false) {
        	$error = Functions::error(100, "Date is not in right format  (d.m.Y)");
        }
        //get format back, no clock needed
        $date = date_format($date, 'd.m.Y');
        //return right date
        //date in function getData('date') is more imporatant than set date in class 
        return $date;
    }

}

?>