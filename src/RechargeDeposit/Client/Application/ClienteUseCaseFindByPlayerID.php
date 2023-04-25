<?php

namespace Src\RechargeDeposit\Client\Application;

use Src\RechargeDeposit\Client\Domain\Contracts\ClientRepositoryInterface;

class ClienteUseCaseFindByPlayerID
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function execute(int $playerID): array
    {
        $client = $this->clientRepository->findByPlayerID($playerID);
        return $client->toArray();
    }
}
