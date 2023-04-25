<?php

namespace Src\RechargeDeposit\TransactionLog\Domain\Contracts;

use Src\RechargeDeposit\TransactionLog\Domain\TransactionLog;

interface TransactionLogRepositoryInterface
{
    public function log(TransactionLog $transactionLog): void;
    public function findByTransactionId(int $transactionId): array;
}
