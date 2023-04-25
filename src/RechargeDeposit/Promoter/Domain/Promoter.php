<?php

namespace Src\RechargeDeposit\Promoter\Domain;

use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterId;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterName;

class Promoter
{
    private $id;
    private $name;

    public function __construct(
        PromoterId $id,
        PromoterName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): PromoterId
    {
        return $this->id;
    }

    public function name(): PromoterName
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
