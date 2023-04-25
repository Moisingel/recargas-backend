<?php

namespace Src\RechargeDeposit\TransactionLog\Domain\ValueObjects;

class TransactionLogAction
{
    const ACTIONS = ['CREATE', 'UPDATE', 'DELETE'];
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;

    }

    public function validate(): void
    {
        if (!in_array($this->value, self::ACTIONS)) {
            throw new \InvalidArgumentException('Invalid action', 400);
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
