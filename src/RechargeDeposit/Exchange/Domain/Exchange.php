<?php

namespace Src\RechargeDeposit\Exchange\Domain;

use Src\RechargeDeposit\Exchange\Domain\ValueObjects\ExchangeId;
use Src\RechargeDeposit\Exchange\Domain\ValueObjects\ExchangeRate;

class Exchange
{
    private $id;
    private $exchangeRate;

    public function __construct(
        ExchangeId $id,
        ExchangeRate $exchangeRate
    ) {
        $this->id = $id;
        $this->exchangeRate = $exchangeRate;
    }

    public function id(): ExchangeId
    {
        return $this->id;
    }

    public function exchangeRate(): ExchangeRate
    {
        return $this->exchangeRate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'exchange_rate' => $this->exchangeRate()->value(),
        ];
    }

}
