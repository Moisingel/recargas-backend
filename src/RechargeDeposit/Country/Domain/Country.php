<?php

namespace Src\RechargeDeposit\Country\Domain;

use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryId;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryName;

class Country
{
    private $id;
    private $name;

    public function __construct(CountryId $id, CountryName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): CountryId
    {
        return $this->id;
    }

    public function name(): CountryName
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
