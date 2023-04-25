<?php

namespace Src\RechargeDeposit\TransactionLog\Domain;

use Src\RechargeDeposit\Promoter\Domain\Promoter;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogAction;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogNewData;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogObservation;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogOldData;
use Src\RechargeDeposit\TransactionLog\Domain\ValueObjects\TransactionLogTransactionId;

class TransactionLog
{
    private $transactionLogAction;
    private $transactionLogOldData;
    private $transactionLogNewData;
    private $transactionLogObservation;
    private $promoter;

    public function __construct(
        TransactionLogTransactionId $transactionLogTransactionId,
        TransactionLogAction $transactionLogAction,
        TransactionLogOldData $transactionLogOldData,
        TransactionLogNewData $transactionLogNewData,
        TransactionLogObservation $transactionLogObservation,
        Promoter $promoter
    )
    {
        $this->transactionLogTransactionId = $transactionLogTransactionId;
        $this->transactionLogAction = $transactionLogAction;
        $this->transactionLogOldData = $transactionLogOldData;
        $this->transactionLogNewData = $transactionLogNewData;
        $this->transactionLogObservation = $transactionLogObservation;
        $this->promoter = $promoter;
    }

    public function transactionLogTransactionId(): TransactionLogTransactionId
    {
        return $this->transactionLogTransactionId;
    }

    public function transactionLogAction(): TransactionLogAction
    {
        return $this->transactionLogAction;
    }

    public function transactionLogOldData(): TransactionLogOldData
    {
        return $this->transactionLogOldData;
    }

    public function transactionLogNewData(): TransactionLogNewData
    {
        return $this->transactionLogNewData;
    }

    public function transactionLogObservation(): TransactionLogObservation
    {
        return $this->transactionLogObservation;
    }

    public function promoter(): Promoter
    {
        return $this->promoter;
    }

    public function toArray(){
        return [
            'wallet_transaction_id' => $this->transactionLogTransactionId()->value(),
            'action' => $this->transactionLogAction()->value(),
            'old_data' => $this->transactionLogOldData()->value(),
            'new_data' => $this->transactionLogNewData()->value(),
            'observation' => $this->transactionLogObservation()->value(),
            'promoter' => $this->promoter()->toArray(),
        ];
    }

    public function toArrayForLog(){
        return [
            'wallet_transaction_id' => $this->transactionLogTransactionId()->value(),
            'action' => $this->transactionLogAction()->value(),
            'old_data' => $this->transactionLogOldData()->value(),
            'new_data' => $this->transactionLogNewData()->value(),
            'observation' => $this->transactionLogObservation()->value(),
            'promoter_id' => $this->promoter->id()->value()
        ];
    }
}
