<?php

namespace TDD;

class Receipt
{
    public function total(array $items = [], $cupon)
    {
        $sum = array_sum($items);
        if($cupon !== null){
            $sum = $sum - ($sum * $cupon);
        }

        return $sum;
    }

    public function tax($amount, $tax)
    {
        return ($amount * $tax);
    }
}