<?php
require __DIR__ . '/vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8');

$objecTest[1] = new \stdClass();
$objecTest[1]->id = 1;
$objecTest[1]->naziv = "zanimiv?";
$objecTest[1]->kategorija = "neki";
$objecTest[1]->rok = "7.10.2015";
$objecTest[1]->prihodek = "900 €";
$objecTest[1]->mesecDDV = "junij";
$objecTest[1]->ponavlja = true;
$objecTest[1]->opombe = "false";

$objecTest[0] = new \stdClass();
$objecTest[0]->id = 0;
$objecTest[0]->naziv = "zanimiv?";
$objecTest[0]->kategorija = "neki";
$objecTest[0]->rok = "7.12.2015";
$objecTest[0]->prihodek = "900 €";
$objecTest[0]->mesecDDV = "junij";
$objecTest[0]->ponavlja = false;
$objecTest[0]->opombe = "false";

$prilivTest[0] = new \stdClass();
$prilivTest[0]->id = 0;
$prilivTest[0]->prihodek_id = 0;
$prilivTest[0]->iban = array("SI56 0000 0000 0000 000");
$prilivTest[0]->znesek = "900 €";

$prilivTest[1] = new \stdClass();
$prilivTest[1]->id = 1;
$prilivTest[1]->prihodek_id = 1;
$prilivTest[1]->iban = array("SI56 0000 0000 0000 000");
$prilivTest[1]->znesek = "900 €";

$prilivTest[2] = new \stdClass();
$prilivTest[2]->id = 2;
$prilivTest[2]->prihodek_id = 1;
$prilivTest[2]->iban = array("SI56 0000 0000 0000 000");
$prilivTest[2]->znesek = "900 €";

try {
	$test = new Api\Revenue($objecTest);
	$test->date = '10.3.2016';
	$stanje = $test->check();

	var_dump($stanje);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "<br/>";
    echo "The exception code is: " . $e->getCode();
}


try {
	$test1 = new Api\Inflow($prilivTest);
	$check = $test1->find('1');
	$all = $test1->check();
	var_dump($all);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "<br/>";
    echo "The exception code is: " . $e->getCode();	
}







?>