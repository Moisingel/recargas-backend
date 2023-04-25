<?php

namespace Src\RechargeDeposit\Bank\Application;

use Src\RechargeDeposit\Bank\Domain\Contracts\BankRepositoryInterface;

class BankUseCaseFindAll
{
    private BankRepositoryInterface $repository;

    public function __construct(BankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        $banks = $this->repository->findAll();
        //mappeo de banks a array
        return array_map(function ($bank) {
            return $bank->toArray();
        }, $banks);
    }
}
