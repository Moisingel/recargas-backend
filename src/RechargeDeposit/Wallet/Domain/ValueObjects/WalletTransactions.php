<?php

namespace Src\RechargeDeposit\Wallet\Domain\ValueObjects;

use Src\RechargeDeposit\WalletTransaction\Domain\WalletTransaction;

class WalletTransactions
{
    private $transactions;

    public function __construct(array $transactions)
    {
        $this->transactions = $transactions;
        $this->Validate();
    }

    public function Validate()
    {
        //validate if the transactions are valid, WalletTransactions should be an array of WalletTransaction
        if (count($this->transactions) !== 0) {
            array_map(function ($transaction) {
                if (!($transaction instanceof WalletTransaction)) {
                    throw new \InvalidArgumentException('Invalid WalletTransactions', 400);
                }
            }, $this->transactions);
        }
    }

    public function value(): array
    {
        return $this->transactions;
    }
}
