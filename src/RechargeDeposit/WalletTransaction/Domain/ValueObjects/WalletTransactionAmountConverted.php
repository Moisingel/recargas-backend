<?php

namespace Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects;

class WalletTransactionAmountConverted
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
