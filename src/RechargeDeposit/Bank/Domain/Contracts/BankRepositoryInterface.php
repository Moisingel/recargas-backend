<?php

namespace Src\RechargeDeposit\Bank\Domain\Contracts;

use Src\RechargeDeposit\Bank\Domain\Bank;

interface BankRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): Bank;
}
