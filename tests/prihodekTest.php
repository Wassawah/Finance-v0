<?php

require_once 'src/prihodek.php';

class PrihodekTest extends PHPUnit_Framework_TestCase
{
    public function testizracunajDDV()
    {
        // make an instance of the user
        $prihodek = new Prihodek();

        // use assertEquals to ensure the greeting is what you
        $expected = 0.22;
        $actual = $prihodek->izracunajDDV(1);
        $this->assertEquals($expected, $actual);
    }
    /**
     * @dataProvider additionProvider
     */
    public function testprihodekZDDV($a, $expected)
    {
    	$prihodek = new Prihodek();
    	$actual = $prihodek->prihodekZDDV($a);

        $this->assertEquals($expected, $actual);
    }

    public function additionProvider()
    {
        return array(
          'integer' => array(100, 122),
          'string' => array('burek', 0),
          'value in euros' => array('30 €', '36.6'),
          'decimal' => array(100.32, 122.3904)
        );
    }

}
