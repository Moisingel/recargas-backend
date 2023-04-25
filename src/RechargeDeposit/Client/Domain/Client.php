<?php

namespace Src\RechargeDeposit\Client\Domain;

use Src\RechargeDeposit\Client\Domain\ValueObjects\ClientId;
use Src\RechargeDeposit\Client\Domain\ValueObjects\ClientName;
use Src\RechargeDeposit\Wallet\Domain\Wallet;

class Client
{
    private $id;
    private $name;
    private $wallet;

    public function __construct(
        ClientId $id,
        ClientName $name,
        Wallet $wallet = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->wallet = $wallet ?? null;
    }

    public function id(): ClientId
    {
        return $this->id;
    }

    public function name(): ClientName
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value(),
            'wallet' => $this->wallet?->toArray()
        ];
    }
}
