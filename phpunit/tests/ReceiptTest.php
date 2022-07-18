<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .
'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase
{

    public function setUp()
    {
        $this->receipt = new Receipt();
    }

    public function tearDown()
    {
        unset($this->receipt);
    }

    public function testTotal()
    {
        $input = [1,1,1];
        $cupon = null;
        $output = $this->receipt->total($input, $cupon);

        $this->assertEquals(
            3,
            $output,
            'When summing should be equal to 3'
        );
    }

    public function testTotalAndCupom()
    {
        $input = [0,2,5,8];
        $cupon = 0.20;
        $output = $this->receipt->total($input, $cupon);

        $this->assertEquals(
            12,
            $output,
            'When summing should be equal to 12'
        );
    }

    public function testTax()
    {
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.00,
            $output,
            "The output should be 1.00"
        );
    }
}