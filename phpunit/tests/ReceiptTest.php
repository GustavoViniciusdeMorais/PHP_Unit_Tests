<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .
'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase
{
    public function testTotal()
    {
        $receipt = new Receipt();
        $this->assertEquals(
            3,
            $receipt->total([1,1,1]),
            'When summing should be equal to 3'
        );
    }
}