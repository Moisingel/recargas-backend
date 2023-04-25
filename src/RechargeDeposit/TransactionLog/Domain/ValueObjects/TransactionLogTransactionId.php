<?php

namespace Src\RechargeDeposit\TransactionLog\Domain\ValueObjects;

class TransactionLogTransactionId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException("TransactionLogTransactionId must be greater than 0");
        }
    }

    public function value()
    {
        return $this->value;
    }
}
