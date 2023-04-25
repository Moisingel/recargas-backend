<?php

namespace Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects;

class WalletTransactionType
{
    const TYPES = ['deposit', 'withdrawal'];

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate()
    {
        if (!in_array($this->value, self::TYPES)) {
            throw new \InvalidArgumentException('Invalid type');
        }
    }

    public function value()
    {
        return $this->value;
    }




}
