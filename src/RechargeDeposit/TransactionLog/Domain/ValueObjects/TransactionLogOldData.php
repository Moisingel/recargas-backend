<?php

namespace Src\RechargeDeposit\TransactionLog\Domain\ValueObjects;

class TransactionLogOldData
{
    private $value;

    public function __construct(string|null $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
