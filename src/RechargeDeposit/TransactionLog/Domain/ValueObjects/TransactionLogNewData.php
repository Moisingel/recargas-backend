<?php

namespace Src\RechargeDeposit\TransactionLog\Domain\ValueObjects;

class TransactionLogNewData
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
