<?php

namespace Src\RechargeDeposit\Channel\Domain\Contracts;

use Src\RechargeDeposit\Channel\Domain\Channel;

interface ChannelRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): Channel;
}
