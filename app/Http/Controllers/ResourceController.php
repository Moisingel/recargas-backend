<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Src\RechargeDeposit\Bank\Application\BankUseCaseFindAll;
use Src\RechargeDeposit\Bank\Domain\Contracts\BankRepositoryInterface;
use Src\RechargeDeposit\Bank\Infrastructure\Repositories\BankEloquentRepository;
use Src\RechargeDeposit\Channel\Application\ChannelUseCaseFindAll;
use Src\RechargeDeposit\Channel\Domain\Contracts\ChannelRepositoryInterface;
use Src\RechargeDeposit\Channel\Infrastructure\Repositories\ChannelEloquentRepository;
use Src\RechargeDeposit\Client\Application\ClienteUseCaseFindByPlayerID;
use Src\RechargeDeposit\Client\Domain\Contracts\ClientRepositoryInterface;
use Src\RechargeDeposit\Client\Infrastructure\Repositories\ClientEloquentRepository;
use Src\RechargeDeposit\Currency\Application\CurrencyUseCaseFindAll;
use Src\RechargeDeposit\Currency\Domain\Contracts\CurrencyRepositoryInterface;
use Src\RechargeDeposit\Currency\Infrastructure\Repositories\CurrencyEloquentRepository;
use Src\RechargeDeposit\Promoter\Application\PromoterUseCaseFindById;
use Src\RechargeDeposit\Promoter\Domain\Contracts\PromoterRepositoryInterface;
use Src\RechargeDeposit\Promoter\Infrastructure\Repositories\PromoterEloquentRepository;

class ResourceController extends Controller
{
    use ApiResponse;
    private BankRepositoryInterface $bankRepository;
    private ChannelRepositoryInterface $channelRepository;
    private CurrencyRepositoryInterface $currencyRepository;
    private PromoterRepositoryInterface $promoterRepository;
    private ClientRepositoryInterface $clientRepository;

    public function __construct()
    {
        $this->bankRepository = new BankEloquentRepository();
        $this->channelRepository = new ChannelEloquentRepository();
        $this->currencyRepository = new CurrencyEloquentRepository();
        $this->promoterRepository = new PromoterEloquentRepository();
        $this->clientRepository = new ClientEloquentRepository();
    }

    public function allBanks()
    {
        try {
            $bankUseCaseAll = new BankUseCaseFindAll($this->bankRepository);
            $banks = $bankUseCaseAll->execute();
            return $this->successResponseWithData($banks);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function allChannels(){
        try {
            $channelUseCaseFindAll = new ChannelUseCaseFindAll($this->channelRepository);
            $channels = $channelUseCaseFindAll->execute();
            return $this->successResponseWithData($channels);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function allCurrencies(){
        try {
            $currencyUseCaseFindAll = new CurrencyUseCaseFindAll($this->currencyRepository);
            $currencies = $currencyUseCaseFindAll->execute();
            return $this->successResponseWithData($currencies);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function findPromoterById(int $id){
        try {
            $promoterUseCaseFindById = new PromoterUseCaseFindById($this->promoterRepository);
            $promoter = $promoterUseCaseFindById->execute($id);
            return $this->successResponseWithData($promoter);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function findClientByPlayerId($playerId){
        try {
            $clientUseCaseFindByPlayerID = new ClienteUseCaseFindByPlayerID($this->clientRepository);
            $client = $clientUseCaseFindByPlayerID->execute($playerId);
            return $this->successResponseWithData($client);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
