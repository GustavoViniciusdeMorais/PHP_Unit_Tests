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

    /**
     * @dataProvider provideTotal
     */
    public function testTotal($items, $expected)
    {
        $cupon = null;
        $output = $this->receipt->total($items, $cupon);

        $this->assertEquals(
            $expected,
            $output,
            "When summing should be equal to {$expected}"
        );
    }

    public function provideTotal()
    {
        return [
            'Test Case A' => [[1,2,5,8], 16],
            'Test Case B' => [[-1,2,5,8], 14],
            'Test Case C' => [[1,2,8], 11],
        ];
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

    /**
     * @dataProvider providerToExceptionTeste
     */
    public function testTotalException($input, $coupon)
    {
        $this->expectException('BadMethodCallException');
        $this->receipt->total($input, $coupon);
    }

    public function providerToExceptionTeste()
    {
        return [
            'higher coupon price' => [[0,2,5,8], 1.20]
        ];
    }

    public function testPostTaxTotal()
    {
        $items = [1,2,5,8];
        $tax = 0.20;
        $cupon = null;
        $receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax','total'])
            ->getMock();
        $receipt->expects($this->once())
            ->method('total')
            ->with($items, $cupon)
            ->will($this->returnValue(10.00));
        $receipt->expects($this->once())
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));
        $result = $receipt->postTaxTotal([1,2,5,8], 0.20, null);
        $this->assertEquals(11.00, $result);
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