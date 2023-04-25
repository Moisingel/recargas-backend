<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\RechargeDeposit\Bank\Domain\Contracts\BankRepositoryInterface;
use Src\RechargeDeposit\Bank\Infrastructure\Repositories\BankEloquentRepository;
use Src\RechargeDeposit\Channel\Domain\Contracts\ChannelRepositoryInterface;
use Src\RechargeDeposit\Channel\Infrastructure\Repositories\ChannelEloquentRepository;
use Src\RechargeDeposit\Currency\Domain\Contracts\CurrencyRepositoryInterface;
use Src\RechargeDeposit\Currency\Infrastructure\Repositories\CurrencyEloquentRepository;
use Src\RechargeDeposit\Promoter\Domain\Contracts\PromoterRepositoryInterface;
use Src\RechargeDeposit\Promoter\Infrastructure\Repositories\PromoterEloquentRepository;
use Src\RechargeDeposit\TransactionLog\Domain\Contracts\TransactionLogRepositoryInterface;
use Src\RechargeDeposit\TransactionLog\Infrastructure\Repositories\TransactionLogEloquentRepository;
use Src\RechargeDeposit\Wallet\Application\WalletUseCaseSaveRecharge;
use Src\RechargeDeposit\Wallet\Application\WalletUseCaseTransactionsPaginateFilter;
use Src\RechargeDeposit\Wallet\Domain\Contracts\WalletRepositoryInterface;
use Src\RechargeDeposit\Wallet\Infrastructure\Repositories\WalletEloquentRepository;

class WalletController extends Controller
{
    use ApiResponse;
    private BankRepositoryInterface $bankRepository;
    private ChannelRepositoryInterface $channelRepository;
    private CurrencyRepositoryInterface $currencyRepository;
    private WalletRepositoryInterface $walletRepository;
    private PromoterRepositoryInterface $promoterRepository;
    private TransactionLogRepositoryInterface $transactionLogRepository;

    public function __construct()
    {
        $this->bankRepository = new BankEloquentRepository();
        $this->channelRepository = new ChannelEloquentRepository();
        $this->currencyRepository = new CurrencyEloquentRepository();
        $this->walletRepository = new WalletEloquentRepository();
        $this->promoterRepository = new PromoterEloquentRepository();
        $this->transactionLogRepository = new TransactionLogEloquentRepository();
    }

    public function recharge(Request $request){
        DB::beginTransaction();
        try {
            $WalletUseCaseRecharge = new WalletUseCaseSaveRecharge(
                $this->bankRepository,
                $this->channelRepository,
                $this->currencyRepository,
                $this->walletRepository,
                $this->promoterRepository,
                $this->transactionLogRepository
            );
            $wallet = $WalletUseCaseRecharge->execute($request);
            DB::commit();
            return $this->successResponseWithData($wallet);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage().'-'.$e->getFile().'-'.$e->getLine(),  500);
        }
    }

    public function updateRecharge(Request $request, $transactionId){
        DB::beginTransaction();
        try {
            $WalletUseCaseRecharge = new WalletUseCaseSaveRecharge(
                $this->bankRepository,
                $this->channelRepository,
                $this->currencyRepository,
                $this->walletRepository,
                $this->promoterRepository,
                $this->transactionLogRepository
            );
            $request->id = $transactionId;
            $wallet = $WalletUseCaseRecharge->execute($request);
            DB::commit();
            return $this->successResponseWithData($wallet);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage().'-'.$e->getFile().'-'.$e->getLine(),  500);
        }
    }

public function transactionsPaginateFilter(Request $request, $walletId){
        try {
            $WalletUseCaseTransactionsPaginateFilter = new WalletUseCaseTransactionsPaginateFilter(
                $this->walletRepository
            );
            $transactions = $WalletUseCaseTransactionsPaginateFilter->execute($walletId, $request->page, $request->perPage);
            return $this->successResponseWithData($transactions);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage().'-'.$e->getFile().'-'.$e->getLine(),  500);
        }
    }

}
