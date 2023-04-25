<?php

namespace Src\RechargeDeposit\TransactionLog\Infrastructure\Repositories;

use App\Models\TransactionLog as TransactionLogModel;
use Src\RechargeDeposit\Promoter\Domain\Promoter;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterId;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterName;
use Src\RechargeDeposit\TransactionLog\Domain\Contracts\TransactionLogRepositoryInterface;
use Src\RechargeDeposit\TransactionLog\Domain\TransactionLog;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogAction;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogNewData;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogObservation;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogOldData;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogTransactionId;

class TransactionLogEloquentRepository implements TransactionLogRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new TransactionLogModel();
    }

    public function log(TransactionLog $transactionLog): void
    {
        $this->model->create($transactionLog->toArrayForLog());
    }

    public function findByTransactionId(int $transactionId): array
    {
        $transactionLogs = $this->model->where('wallet_transaction_id', $transactionId)->get();
        return array_map(function ($transactionLog) {
            return new TransactionLog(
                new TransactionLogTransactionId($transactionLog->wallet_transaction_id),
                new TransactionLogAction($transactionLog->action),
                new TransactionLogOldData($transactionLog->old_data),
                new TransactionLogNewData($transactionLog->new_data),
                new TransactionLogObservation($transactionLog->observation),
                new Promoter(
                    new PromoterId($transactionLog->promoter_id),
                    new PromoterName($transactionLog->promoter_name),
                )
            );
        }, $transactionLogs);
    }
}
