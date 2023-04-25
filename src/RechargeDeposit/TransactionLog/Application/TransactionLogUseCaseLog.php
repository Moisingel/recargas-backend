<?php

namespace Src\RechargeDeposit\TransactionLog\Application;

use Src\RechargeDeposit\TransactionLog\Domain\Contracts\TransactionLogRepositoryInterface;
use Src\RechargeDeposit\TransactionLog\Domain\TransactionLog;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogAction;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogNewData;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogObservation;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogOldData;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogTransactionId;
use Src\RechargeDeposit\WalletTransaction\Domain\WalletTransaction;

class TransactionLogUseCaseLog
{
    private TransactionLogRepositoryInterface $transactionLogRepository;

    public function __construct(TransactionLogRepositoryInterface $transactionLogRepository)
    {
        $this->transactionLogRepository = $transactionLogRepository;
    }

    public function execute(WalletTransaction $old, WalletTransaction $new,string $obs): void
    {
        $log = new TransactionLog(
            new TransactionLogTransactionId($new->id()->value()),
            new TransactionLogAction('UPDATE'),
            new TransactionLogOldData(json_encode($old->toArray())),
            new TransactionLogNewData(json_encode($new->toArray())),
            new TransactionLogObservation($obs),
            $new->promoter()
        );
        $this->transactionLogRepository->log($log);
    }
}
