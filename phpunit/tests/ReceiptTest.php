<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .
'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Formatter;
use TDD\Receipt;

class ReceiptTest extends TestCase
{
    private $receipt;
    private $formatter;

    public function setUp()
    {
        $this->formatter = $this->getMockBuilder('TDD\Formatter')
                            ->setMethods(['currencyAmmount'])
                            ->getMock();
        $this->formatter->expects(($this->any()))
                ->method('currencyAmmount')
                ->with($this->anything())
                ->will($this->returnArgument(0));

        $this->receipt = new Receipt($this->formatter);
    }

    public function tearDown()
    {
        unset($this->receipt);
    }

    /**
     * @dataProvider provideSubTotal
     */
    public function testSubTotal($items, $expected)
    {
        $cupon = null;
        $output = $this->receipt->subTotal($items, $cupon);

        $this->assertEquals(
            $expected,
            $output,
            "When summing should be equal to {$expected}"
        );
    }

    public function provideSubTotal()
    {
        return [
            'Test Case A' => [[1,2,5,8], 16],
            'Test Case B' => [[-1,2,5,8], 14],
            'Test Case C' => [[1,2,8], 11],
        ];
    }

    public function testSubTotalAndCupom()
    {
        $input = [0,2,5,8];
        $cupon = 0.20;
        $output = $this->receipt->subTotal($input, $cupon);

        $this->assertEquals(
            12,
            $output,
            'When summing should be equal to 12'
        );
    }

    /**
     * @dataProvider providerToExceptionTeste
     */
    public function testSubTotalException($input, $coupon)
    {
        $this->expectException('BadMethodCallException');
        $this->receipt->subTotal($input, $coupon);
    }

    public function providerToExceptionTeste()
    {
        return [
            'higher coupon price' => [[0,2,5,8], 1.20]
        ];
    }

    public function testPostTaxSubTotal()
    {
        $items = [1,2,5,8];
        $cupon = null;
        $localReceipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax','subTotal'])
            ->setConstructorArgs([$this->formatter])
            ->getMock();
        $localReceipt->expects($this->once())
            ->method('subTotal')
            ->with($items, $cupon)
            ->will($this->returnValue(10.00));
        $localReceipt->expects($this->once())
            ->method('tax')
            ->with(10.00)
            ->will($this->returnValue(1.00));
        $result = $localReceipt->postTaxSubTotal([1,2,5,8], null);
        $this->assertEquals(11.00, $result);
    }

    public function testTax()
    {
        $inputAmount = 10.00;
        $this->receipt->tax = 0.10;
        $output = $this->receipt->tax($inputAmount);
        $this->assertEquals(
            1.00,
            $output,
            "The output should be 1.00"
        );
    }
}