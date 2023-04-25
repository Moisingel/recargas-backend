<?php

namespace Src\RechargeDeposit\Currency\Domain;

use Src\RechargeDeposit\Country\Domain\Country;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyCountry;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyId;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyName;

class Currency
{
    private $id;
    private $name;
    private $country;

    public function __construct(
        CurrencyId $id,
        CurrencyName $name,
        Country $country)
    {
        $this->id = $id;
        $this->name = $name;
        $this->country = $country;
    }

    public function id(): CurrencyId
    {
        return $this->id;
    }

    public function name(): CurrencyName
    {
        return $this->name;
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value(),
            'country' => $this->country()->toArray()
        ];
    }
}
