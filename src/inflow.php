<?php

/*
Priliv:
 - je vezan na prihodek in zaznamuje kdaj se je zgodil (kdaj so prišla sredstva na račun podjetja) posamezn priliv
 - prihodek ima lahko več prilivov
 - ima datum nastanka
 - predvidi možnost uporabe večih bančnih računov
 - verjetnost dogodka ko gre za napoved (v obliki vpisanega %)

Priliv TABLE

skica
 id | prihodek_id (foreign_key) | datum | znesek | verjetnost | IBAN

Test run:
vendor\bin\phpunit --verbose tests/PrihodekTest
*/

namespace Api;

class Inflow
{
    public $objective;      //Get object from DB
    public $date;           //Date is set by user
    public $znesek;

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

    public function check() 
    {
    	$object = new \stdClass();

    	$object->inflow = $this->calcInflow();
    	$object->count = count($this->all());

    	return $object;
    }
    public function calcInflow() 
    {
    	return $this->sumValue($this->all());
    }
    public function all() 
    {
    	$all = $this->objective;
    	return $all;
    }
    //get all inflow where id is X
    public function find($id) 
    {
    	return $this->searchByForeignKey($this->objective, $id);
    }

    //search and find by foreign key (prihodek_id)
	public function searchByForeignKey($objects, $searchFor) 
	{
		$find = array_filter(
			$objects,
			function ($e) use ($searchFor) {
				return($e->prihodek_id == $searchFor);
			}
		);
		return $find;
	}
	//search and find by foreign key (prihodek_id)
	public function sumValue($objects) 
	{
		$find = array_filter(
			$objects,
			function ($e) {
				settype($e->znesek, "float");
				$this->znesek += $e->znesek;
			}
		);
		return $this->znesek;
	}
}

?>