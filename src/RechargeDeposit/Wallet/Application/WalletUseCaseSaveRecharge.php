<?php

namespace Src\RechargeDeposit\Wallet\Application;

use Src\RechargeDeposit\Bank\Domain\Contracts\BankRepositoryInterface;
use Src\RechargeDeposit\Channel\Domain\Contracts\ChannelRepositoryInterface;
use Src\RechargeDeposit\Currency\Domain\Contracts\CurrencyRepositoryInterface;
use Src\RechargeDeposit\Promoter\Domain\Contracts\PromoterRepositoryInterface;
use Src\RechargeDeposit\TransactionLog\Application\TransactionLogUseCaseLog;
use Src\RechargeDeposit\TransactionLog\Domain\Contracts\TransactionLogRepositoryInterface;
use Src\RechargeDeposit\Wallet\Domain\Contracts\WalletRepositoryInterface;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionAmount;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionAmountConverted;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionDate;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionExchangeRate;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionId;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionType;
use Src\RechargeDeposit\WalletTransaction\Domain\WalletTransaction;

class WalletUseCaseSaveRecharge
{
    private BankRepositoryInterface $bankRepository;
    private ChannelRepositoryInterface $channelRepository;
    private CurrencyRepositoryInterface $currencyRepository;
    private WalletRepositoryInterface $walletRepository;
    private PromoterRepositoryInterface $promoterRepository;
    private TransactionLogRepositoryInterface $transactionLogRepository;

    public function __construct(
        BankRepositoryInterface $bankRepository,
        ChannelRepositoryInterface $channelRepository,
        CurrencyRepositoryInterface $currencyRepository,
        WalletRepositoryInterface $walletRepository,
        PromoterRepositoryInterface $promoterRepository,
        TransactionLogRepositoryInterface $transactionLogRepository
    ) {
        $this->bankRepository = $bankRepository;
        $this->channelRepository = $channelRepository;
        $this->currencyRepository = $currencyRepository;
        $this->walletRepository = $walletRepository;
        $this->promoterRepository = $promoterRepository;
        $this->transactionLogRepository = $transactionLogRepository;
    }

    public function execute($request)
    {
        $bank = $this->bankRepository->findById($request->bank_id ?? 0);
        $channel = $this->channelRepository->findById($request->channel_id ?? 0);
        $currency = $this->currencyRepository->findById($request->currency_id ?? 0);
        $wallet = $this->walletRepository->findById($request->wallet_id ?? 0);
        $promoter = $this->promoterRepository->findById($request->promoter_id ?? 0);
        $amountConverted = 0;
        $exchangeRate = 1;
        if ($currency->id()->value() === $wallet->currency()->id()->value()) {
            $amountConverted = $request->amount;
        }
        if ($currency->id()->value() !== $wallet->currency()->id()->value()) {
            $exchange = $this->currencyRepository->findRate($currency->id()->value(), $wallet->currency()->id()->value());
            $amountConverted = $request->amount * $exchange->exchangeRate()->value();
            $exchangeRate = $exchange->exchangeRate()->value();
        }

        if ($request->id == 0){
            $walletTransactionToCreate = new WalletTransaction(
                new WalletTransactionId(0),
                new WalletTransactionType('deposit'),
                new WalletTransactionAmount($request->amount ?? null),
                new WalletTransactionDate(date('Y-m-d H:i:s')),
                new WalletTransactionExchangeRate($exchangeRate),
                new WalletTransactionAmountConverted($amountConverted),
                $currency,
                $promoter,
                $bank,
                $channel
            );
            $recharge = $this->walletRepository->recharge($wallet, $walletTransactionToCreate);
            return $recharge->toArray();
        }
        if ($request->id > 0) {
            $walletTransactionToUpdate = new WalletTransaction(
                new WalletTransactionId($request->id),
                new WalletTransactionType('deposit'),
                new WalletTransactionAmount($request->amount),
                new WalletTransactionDate(date('Y-m-d H:i:s')),
                new WalletTransactionExchangeRate($exchangeRate),
                new WalletTransactionAmountConverted($amountConverted),
                $currency,
                $promoter,
                $bank,
                $channel
            );
            $old = $this->getTransaction($wallet->id()->value(), $request->id);
            $recharge = $this->walletRepository->updateRecharge($wallet, $walletTransactionToUpdate);
            $useCaseLog = new TransactionLogUseCaseLog(
                $this->transactionLogRepository
            );
            $observation = $request->observation ?? null;
            if ($observation == null) {
                throw new \Exception('observation is required', 404);
            }
            $useCaseLog->execute($old, $recharge,$observation);
            return $recharge->toArray();
        }
        throw new \Exception('wallet transaction id not found', 404);
    }

    private function getTransaction(int $walletId, int $transactionId): WalletTransaction
    {
        $transaction = $this->walletRepository->findTransactionById($walletId, $transactionId);
        if (!$transaction) {
            throw new \Exception('wallet transaction id not found', 404);
        }
        return $transaction;
    }
}
