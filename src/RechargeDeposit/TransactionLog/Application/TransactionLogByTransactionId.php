<?php

namespace Src\RechargeDeposit\TransactionLog\Application;

use Src\RechargeDeposit\TransactionLog\Domain\Contracts\TransactionLogRepositoryInterface;
use Src\RechargeDeposit\WalletTransaction\Domain\WalletTransaction;

class TransactionLogByTransactionId
{
    private TransactionLogRepositoryInterface $transactionLogRepository;

    public function __construct(TransactionLogRepositoryInterface $transactionLogRepository)
    {
        $this->transactionLogRepository = $transactionLogRepository;
    }

    public function execute(int $transactionId): array
    {
        $logs = $this->transactionLogRepository->findByTransactionId($transactionId);
        return array_map(function ($log) {
            return $log->toArray();
        }, $logs);
    }
}
