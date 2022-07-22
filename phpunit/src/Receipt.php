<?php

namespace TDD;

use \BadMethodCallException;
class Receipt
{
    public $tax;
    private $formatter;

    public function __construct($formatter)
    {
        $this->formatter = $formatter;
    }

    public function subTotal(array $items = [], $coupon = null)
    {
        $sum = array_sum($items);
        if($coupon !== null){
            if($coupon > 1.00){
                throw new BadMethodCallException('Coupon value higher than 1.00');
            }

            $sum = $sum - ($sum * $coupon);
        }

        return $sum;
    }

    public function tax($amount)
    {
        return $this->formatter->currencyAmmount($amount * $this->tax);
    }

    public function postTaxSubTotal($items, $cupon)
    {
        $subTotal = $this->subTotal($items, $cupon);
        return $subTotal + $this->tax($subTotal);
    }
}