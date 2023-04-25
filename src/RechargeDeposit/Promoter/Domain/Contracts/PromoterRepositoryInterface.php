<?php

namespace Src\RechargeDeposit\Promoter\Domain\Contracts;

use Src\RechargeDeposit\Promoter\Domain\Promoter;

interface PromoterRepositoryInterface
{
    public function findById(int $id): Promoter;
}
