<?php

namespace TDD;

use \BadMethodCallException;
class Receipt
{
    public function total(array $items = [], $coupon = null)
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

    public function tax($amount, $tax)
    {
        return ($amount * $tax);
    }

    public function postTaxTotal($items, $tax, $cupon)
    {
        $subTotal = $this->total($items, $cupon);
        return $subTotal + $this->tax($subTotal, $tax);
    }
}