<?php

namespace Src\RechargeDeposit\Channel\Domain;

use Src\RechargeDeposit\Channel\Domain\ValueObjects\ChannelId;
use Src\RechargeDeposit\Channel\Domain\ValueObjects\ChannelName;

class Channel
{
    private $id;
    private $name;

    public function __construct(ChannelId $id, ChannelName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): ChannelId
    {
        return $this->id;
    }

    public function name(): ChannelName
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
