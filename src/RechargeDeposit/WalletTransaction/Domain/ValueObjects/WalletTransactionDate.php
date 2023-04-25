<?php

namespace Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects;

class WalletTransactionDate
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
