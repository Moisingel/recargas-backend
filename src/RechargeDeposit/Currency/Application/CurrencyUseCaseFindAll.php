<?php

namespace Src\RechargeDeposit\Currency\Application;

use Src\RechargeDeposit\Currency\Domain\Contracts\CurrencyRepositoryInterface;

class CurrencyUseCaseFindAll
{
    private CurrencyRepositoryInterface $repository;
    public function __construct(
        CurrencyRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function execute()
    {
        $currencies = $this->repository->findAll();
        return array_map(function ($currency) {
            return $currency->toArray();
        }, $currencies);
    }
}
