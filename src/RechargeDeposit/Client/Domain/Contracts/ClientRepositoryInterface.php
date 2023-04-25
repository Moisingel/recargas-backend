<?php

namespace Src\RechargeDeposit\Client\Domain\Contracts;

interface ClientRepositoryInterface
{
    public function findPaginate(int $perPage = 10, int $page=1, string $search = null);
    public function findByPlayerID(int $playerID);
}
