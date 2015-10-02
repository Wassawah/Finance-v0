<?php

/*
Prihodek: 
 - ima datum kdaj planiramo da bo nastal in datum dejanskega nastanka prihodka
 - zabeležit moramo mesec v katerem se obračuna DDV
 - zabeležimo vrednost prihodka tako, da se bo lahko izračunal DDV
 - lahko določimo da se ponavlja vsak mesec
 - prihodek ima naziv, opombe in kategorijo

Prihodek TABLE

skica
 id | naziv | kategorija | rok plačila | datum | prihodek | DDV | mesec DDVja | ponavlja | opombe

skica
 id | naziv | kategorija | rok plačila | datum | odhodek | DDV | mesec DDVja | ponavlja | opombe

Test run:
vendor\bin\phpunit --verbose tests/PrihodekTest
*/

namespace Api;

class Revenue
{
    const DDV = 22;         // 22% DDV

    public $objective;      //Get object from DB
    public $date;           //Date is set by user

    public function __construct($obj = null)
    {
        if($obj == null)
        {
            //if not set return error
            Functions::error(101, "Data is not set");
        }
        //Save object from DB to class
        $this->objective = $obj;
    }

    //repeat function for repeatable revenues
    public function repeatEvent($array, $date)
    {
        //set new array for return use
        $arrayAdd = array();
        //start with date from DB named ROK
        $begin = new \DateTime($array->rok);
        //ends with spec date
        $end = new \DateTime( $date );

        //repeat every month P1M
        $interval = new \DateInterval('P1M');
        //Get period from start, end, and repeat interval
        $daterange = new \DatePeriod($begin, $interval ,$end);

        //set new array date to revenue
        foreach($daterange as $date){
            $arrayAdd[] = $date->format("d.m.Y");
        }
        return $arrayAdd;
    }

    public function getData($date = null)
    {
        //set data with checkdata function or throw error
        $date = Functions::checkDate($date, $this);;
        //get data from class set at constructor  
        $data = $this->objective;

        foreach ($data as $key => $value) {
            if ($value->ponavlja === true) {
                $value->date = $this->repeatEvent($value, $date);
            }   else {
                $value->date = array($value->rok);
            }
        }
        return  $data;
    }

    //Revenue status for spec date
    public function check($date = null) 
    {
        //check if there is date set else throw error
        //or set right date;
        $date = Functions::checkDate($date, $this);

        //get data from 
        $data = $this->getData($date);

        //new obj to return
        $object = new \stdClass();
        //add date to obj
        $object->datum = $date; 
        //sum how many revenue is there and value of it
        $sum = $this->sumByKey($data, 'prihodek');

        //sum value
        $object->prihodek = $sum[0];
        //sum how many
        $object->stPrihodkov = $sum[1];

        //return state of revenue on specific date
        return $object;      
    }

    //Sum array by key;
    public function sumByKey($array, $Bykey) 
    {
        $sestej = 0;
        $i = 0;
        foreach ((array) $array as $key => $val) {
            if (is_array($val->date)) {
                foreach ($val->date as $key => $value) {
                    $sestej += $val->$Bykey;
                    $i++;
                }
            } else {
                $sestej += $val->$Bykey;
                $i++;
            }  
        }
        return array($sestej, $i);
    } 

    //Calculate DDV base on revenue value
    public function izracunajDDV($prihodek) 
    {
    	// settype float sets anything to float
    	settype($prihodek, "float");
    	return (self::DDV / 100) * $prihodek; //return DDV 
    }

    //Sum DDV and revenue
    public function prihodekZDDV($prihodek)
    {
        // settype float sets anything to float
    	settype($prihodek, "float");
    	return $prihodek + self::izracunajDDV($prihodek); //return DDV + revenue
    }
}
 
?>