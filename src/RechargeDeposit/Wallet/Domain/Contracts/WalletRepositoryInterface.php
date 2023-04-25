<?php

namespace Src\RechargeDeposit\Wallet\Domain\Contracts;

use Src\RechargeDeposit\Wallet\Domain\Wallet;
use Src\RechargeDeposit\WalletTransaction\Domain\WalletTransaction;

interface WalletRepositoryInterface
{
    public function recharge(Wallet $wallet, WalletTransaction $walletTransaction): WalletTransaction;
    public function updateRecharge(Wallet $wallet, WalletTransaction $walletTransaction): WalletTransaction;
    public function findById(int $id): Wallet;
    public function findTransactionById(int $walletId, int $transactionId): WalletTransaction;
    public function transactionsPaginateFilter(int $walletId, int $page, int $perPage):array;
}
