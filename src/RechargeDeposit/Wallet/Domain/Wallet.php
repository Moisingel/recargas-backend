<?php

namespace Src\RechargeDeposit\Wallet\Domain;

use Src\RechargeDeposit\Client\Domain\Client;
use Src\RechargeDeposit\Currency\Domain\Currency;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletAmount;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletId;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletLastRecharge;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletTransactions;

class Wallet
{
    private $id;
    private $client;
    private $currency;
    private $amount;
    private $lastRecharge;
    private $transactions;

    public function __construct(
        WalletId $id,
        Client $client,
        Currency $currency,
        WalletAmount $amount,
        WalletLastRecharge $lastRecharge,
        WalletTransactions $transactions = null
    ) {
        $this->id = $id;
        $this->client = $client;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->lastRecharge = $lastRecharge;
        $this->transactions = $transactions ?? new WalletTransactions([]);
    }

    public function id(): WalletId
    {
        return $this->id;
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function amount(): WalletAmount
    {
        return $this->amount;
    }

    public function lastRecharge(): WalletLastRecharge
    {
        return $this->lastRecharge;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'client' => $this->client->toArray(),
            'currency' => $this->currency->toArray(),
            'amount' => $this->amount()->value(),
            'lastRecharge' => $this->lastRecharge()->value(),
            /*'transactions' => array_map(function ($transaction) {
                return $transaction->toArray();
            }, (array) $this->transactions ?? [])*/
        ];
    }

    public function transactions(): WalletTransactions
    {
        return $this->transactions;
    }
}
