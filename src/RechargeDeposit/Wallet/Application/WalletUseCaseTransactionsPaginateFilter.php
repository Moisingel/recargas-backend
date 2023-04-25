<?php

namespace Src\RechargeDeposit\Wallet\Application;

use Src\RechargeDeposit\Wallet\Domain\Contracts\WalletRepositoryInterface;

class WalletUseCaseTransactionsPaginateFilter
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function execute(int $walletId, int $page, int $perPage)
    {
        $transactions= $this->walletRepository->transactionsPaginateFilter($walletId, $page, $perPage);
        return
            array_map(function ($transaction) {
                return $transaction->toArray();
            }, $transactions)
        ;
    }
}
