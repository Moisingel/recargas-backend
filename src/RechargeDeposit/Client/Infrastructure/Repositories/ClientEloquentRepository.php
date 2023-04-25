<?php

namespace Src\RechargeDeposit\Client\Infrastructure\Repositories;

use App\Models\Client as ClientModel;
use Src\RechargeDeposit\Client\Domain\Client;
use Src\RechargeDeposit\Client\Domain\Contracts\ClientRepositoryInterface;
use Src\RechargeDeposit\Client\Domain\ValueObjects\ClientId;
use Src\RechargeDeposit\Client\Domain\ValueObjects\ClientName;
use Src\RechargeDeposit\Country\Domain\Country;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryId;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryName;
use Src\RechargeDeposit\Currency\Domain\Currency;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyId;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyName;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletAmount;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletId;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletLastRecharge;
use Src\RechargeDeposit\Wallet\Domain\Wallet;

class ClientEloquentRepository implements ClientRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new ClientModel();
    }

    public function findPaginate(int $perPage = 10, int $page=1, string $search = null)
    {
        $clients = $this->model->where('name', 'like', "%{$search}%")
            ->orWhere('player_id', 'like', "%{$search}%")
            ->paginate($perPage, ['*'], 'page', $page);
        return array_map(function ($client) {
            return $this->formatClient($client);
        }, $clients);

    }

    public function findByPlayerID(int $playerID)
    {
        $client = $this->model->where('player_id', $playerID)->first();
        if (!$client) {
            throw new \Exception("Client not found", 404);
        }
        return $this->formatClient($client);
    }

    private function formatClient($client)
    {
        $clientAux = new Client(
            new ClientId($client->id),
            new ClientName($client->name)
        );
        return new Client(
            new ClientId($client->id),
            new ClientName($client->name),
            new Wallet(
                new WalletId($client->wallet->id),
                $clientAux,
                new Currency(
                    new CurrencyId($client->wallet->currency->id),
                    new CurrencyName($client->wallet->currency->name),
                    new Country(
                        new CountryId($client->wallet->currency->country->id),
                        new CountryName($client->wallet->currency->country->name)
                    )
                ),
                new WalletAmount($client->wallet->amount),
                new WalletLastRecharge($client->wallet->last_recharge)
            )
        );
    }
}
