<?php

namespace TDD;

class Formatter
{

    public function currencyAmmount($input)
    {
        return round($input, 2);
    }

}