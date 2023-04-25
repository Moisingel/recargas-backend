<?php

namespace Src\RechargeDeposit\Currency\Domain\Contracts;

use Src\RechargeDeposit\Currency\Domain\Currency;
use Src\RechargeDeposit\Exchange\Domain\Exchange;

interface CurrencyRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): Currency;
    public function findRate(int $fromCurrencyId, int $toCurrencyId): Exchange;
}
