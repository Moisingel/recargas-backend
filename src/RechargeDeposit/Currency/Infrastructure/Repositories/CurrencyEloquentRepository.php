<?php

namespace Src\RechargeDeposit\Currency\Infrastructure\Repositories;

use App\Models\Currency as CurrencyModel;
use Src\RechargeDeposit\Country\Domain\Country;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryId;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryName;
use Src\RechargeDeposit\Currency\Domain\Contracts\CurrencyRepositoryInterface;
use Src\RechargeDeposit\Currency\Domain\Currency;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyId;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyName;
use Src\RechargeDeposit\Exchange\Domain\Exchange;
use Src\RechargeDeposit\Exchange\Domain\ValueObjects\ExchangeId;
use Src\RechargeDeposit\Exchange\Domain\ValueObjects\ExchangeRate;

class CurrencyEloquentRepository implements CurrencyRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new CurrencyModel();
    }

    public function findAll(): array
    {
        $currencies = $this->model->all();
        return $currencies->map(function ($currency) {
            return new Currency(
                new CurrencyId($currency->id),
                new CurrencyName($currency->name),
                new Country(
                    new CountryId($currency->country->id),
                    new CountryName($currency->country->name)
                )
            );
        })->toArray();
    }

    public function findById(int $id): Currency
    {
        $currency = $this->model->find($id);
        if (!$currency) {
            throw new \InvalidArgumentException('Currency not found', 404);
        }
        return new Currency(
            new CurrencyId($currency->id),
            new CurrencyName($currency->name),
            new Country(
                new CountryId($currency->country->id),
                new CountryName($currency->country->name)
            )
        );
    }

    public function findRate(int $fromCurrencyId, int $toCurrencyId): Exchange
    {
        /*$exchange = $this->model->where('from_currency_id', $formCurrencyId)
            ->where('to_currency_id', $toCurrencyId)
            ->first();*/
        $currency = $this->model->find($fromCurrencyId);
        $exchange = $currency->exchanges->where('to_currency_id', $toCurrencyId)->first();
        if (!$exchange) {
            throw new \InvalidArgumentException('Exchange not found', 404);
        }
        return new Exchange(
            new ExchangeId($exchange->id),
            new ExchangeRate($exchange->rate)
        );

    }
}
