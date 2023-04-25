<?php

namespace Src\RechargeDeposit\Bank\Domain;

use Src\RechargeDeposit\Bank\Domain\ValueObjects\BankId;
use Src\RechargeDeposit\Bank\Domain\ValueObjects\BankName;

class Bank
{
    private $id;
    private $name;

    public function __construct(
        BankId $id,
        BankName $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): BankId
    {
        return $this->id;
    }

    public function name(): BankName
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value()
        ];
    }

}
