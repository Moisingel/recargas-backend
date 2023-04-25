<?php

namespace Src\RechargeDeposit\WalletTransaction\Domain;

use Src\RechargeDeposit\Bank\Domain\Bank;
use Src\RechargeDeposit\Channel\Domain\Channel;
use Src\RechargeDeposit\Currency\Domain\Currency;
use Src\RechargeDeposit\Promoter\Domain\Promoter;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionAmount;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionAmountConverted;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionDate;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionExchangeRate;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionId;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionType;

class WalletTransaction
{
    private $id;
    private $type;
    private $amount;
    private $date;
    private $exchangeRate;
    private $amountConverted;

    private $currency;
    private $channel;
    private $bank;
    private $promoter;


    public function __construct(
        WalletTransactionId $id,
        WalletTransactionType $type,
        WalletTransactionAmount $amount,
        WalletTransactionDate $date,
        WalletTransactionExchangeRate $exchangeRate,
        WalletTransactionAmountConverted $amountConverted,
        Currency $currency,
        Promoter $promoter,
        Bank $bank,
        Channel $channel
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->amount = $amount;
        $this->date = $date;
        $this->exchangeRate = $exchangeRate;
        $this->amountConverted = $amountConverted;
        $this->currency = $currency;
        $this->promoter = $promoter;
        $this->bank = $bank;
        $this->channel = $channel;
    }

    public function id(): WalletTransactionId
    {
        return $this->id;
    }

    public function type(): WalletTransactionType
    {
        return $this->type;
    }

    public function amount(): WalletTransactionAmount
    {
        return $this->amount;
    }

    public function date(): WalletTransactionDate
    {
        return $this->date;
    }

    public function exchangeRate(): WalletTransactionExchangeRate
    {
        return $this->exchangeRate;
    }

    public function amountConverted(): WalletTransactionAmountConverted
    {
        return $this->amountConverted;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function promoter(): Promoter
    {
        return $this->promoter;
    }

    public function bank(): Bank
    {
        return $this->bank;
    }

    public function channel(): Channel
    {
        return $this->channel;
    }

    public function toArraySave(): array
    {
        return [
            'id' => $this->id()->value(),
            'type' => $this->type()->value(),
            'amount' => $this->amount()->value(),
            'date' => $this->date()->value(),
            'exchange_rate' => $this->exchangeRate()->value(),
            'amount_converted' => $this->amountConverted()->value(),
            'currency_id' => $this->currency->id()->value(),
            'promoter_id' => $this->promoter->id()->value(),
            'bank_id' => $this->bank->id()->value(),
            'channel_id' => $this->channel->id()->value(),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'type' => $this->type()->value(),
            'amount' => $this->amount()->value(),
            'date' => $this->date()->value(),
            'exchange_rate' => $this->exchangeRate()->value(),
            'amount_converted' => $this->amountConverted()->value(),
            'currency' => $this->currency->toArray(),
            'promoter' => $this->promoter->toArray(),
            'bank' => $this->bank->toArray(),
            'channel' => $this->channel->toArray(),
        ];
    }

}
