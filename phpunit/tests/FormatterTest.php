<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .
'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Formatter;

class FormatterTest extends TestCase
{
    public function setUp()
    {
        $this->formatter = new Formatter();
    }

    public function tearDown()
    {
        unset($this->formatter);
    }

    /**
     * @dataProvider provideCurrencyAmmount
     */
    public function testCurrencyAmmount($input, $expected, $message)
    {
        $this->assertSame(
            $expected,
            $this->formatter->currencyAmmount($input),
            $message
        );
    }

    public function provideCurrencyAmmount()
    {
        return [
            [1, 1.00, '1 should be 1.00'],
            [1.1, 1.10, '1.1 should be 1.10'],
            [1.111, 1.11, '1.111 should be 1.11']
        ];
    }
}