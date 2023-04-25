<?php

namespace Src\RechargeDeposit\Wallet\Infrastructure\Repositories;

use App\Models\Wallet as WalletModel;
use Src\RechargeDeposit\Bank\Domain\Bank;
use Src\RechargeDeposit\Bank\Domain\ValueObjects\BankId;
use Src\RechargeDeposit\Bank\Domain\ValueObjects\BankName;
use Src\RechargeDeposit\Channel\Domain\Channel;
use Src\RechargeDeposit\Channel\Domain\ValueObjects\ChannelId;
use Src\RechargeDeposit\Channel\Domain\ValueObjects\ChannelName;
use Src\RechargeDeposit\Client\Domain\Client;
use Src\RechargeDeposit\Client\Domain\ValueObjects\ClientId;
use Src\RechargeDeposit\Client\Domain\ValueObjects\ClientName;
use Src\RechargeDeposit\Country\Domain\Country;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryId;
use Src\RechargeDeposit\Country\Domain\ValueObjects\CountryName;
use Src\RechargeDeposit\Currency\Domain\Currency;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyId;
use Src\RechargeDeposit\Currency\Domain\ValueObjects\CurrencyName;
use Src\RechargeDeposit\Promoter\Domain\Promoter;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterId;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterName;
use Src\RechargeDeposit\Wallet\Domain\Contracts\WalletRepositoryInterface;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletAmount;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletId;
use Src\RechargeDeposit\Wallet\Domain\ValueObjects\WalletLastRecharge;
use Src\RechargeDeposit\Wallet\Domain\Wallet;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionAmount;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionAmountConverted;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionDate;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionExchangeRate;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionId;
use Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects\WalletTransactionType;
use Src\RechargeDeposit\WalletTransaction\Domain\WalletTransaction;

class WalletEloquentRepository implements WalletRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new WalletModel();
    }

    public function recharge(Wallet $wallet, WalletTransaction $walletTransaction): WalletTransaction
    {
        $walletModel = $this->model->find($wallet->id()->value());
        if (!$walletModel) {
            throw new \InvalidArgumentException('Wallet not found', 404);
        }
        $walletTransactions = $walletModel->transactions()->create($walletTransaction->toArraySave());
        $walletModel->amount = $walletModel->amount + $walletTransaction->amountConverted()->value();
        $walletModel->last_recharge = $walletTransaction->date()->value();
        $walletModel->save();
        return $this->formatWalletTransaction($walletTransactions);
    }

    public function findById(int $id): Wallet
    {
        $walletModel = $this->model->find($id);
        if (!$walletModel) {
            throw new \InvalidArgumentException('Wallet not found', 404);
        }
        return new Wallet(
            new WalletId($walletModel->id),
            new Client(
                new ClientId($walletModel->client->id),
                new ClientName($walletModel->client->name),
                null
            ),
            new Currency(
                new CurrencyId($walletModel->currency->id),
                new CurrencyName($walletModel->currency->name),
                new Country(
                    new CountryId($walletModel->currency->country->id),
                    new CountryName($walletModel->currency->country->name)
                )
            ),
            new WalletAmount($walletModel->amount),
            new WalletLastRecharge($walletModel->last_recharge),
            null
        );
    }

    public function updateRecharge(Wallet $wallet, WalletTransaction $walletTransaction): WalletTransaction
    {
        $walletModel = $this->model->find($wallet->id()->value());
        if (!$walletModel) {
            throw new \InvalidArgumentException('Wallet not found', 404);
        }
        $transaction = $walletModel->transactions()->find($walletTransaction->id()->value());
        if (!$transaction) {
            throw new \InvalidArgumentException('Wallet transaction not found', 404);
        }
        $walletModel->amount = $walletModel->amount - $transaction->amount_converted;
        $transaction->update($walletTransaction->toArraySave());
        $walletModel->amount = $walletModel->amount + $walletTransaction->amountConverted()->value();
        $walletModel->save();
        return $this->formatWalletTransaction($transaction);
    }

    private function formatWalletTransaction($walletTransactions): WalletTransaction
    {
        return new WalletTransaction(
            new WalletTransactionId($walletTransactions->id),
            new WalletTransactionType($walletTransactions->type),
            new WalletTransactionAmount($walletTransactions->amount),
            new WalletTransactionDate($walletTransactions->date),
            new WalletTransactionExchangeRate($walletTransactions->exchange_rate),
            new WalletTransactionAmountConverted($walletTransactions->amount_converted),
            new Currency(
                new CurrencyId($walletTransactions->currency->id),
                new CurrencyName($walletTransactions->currency->name),
                new Country(
                    new CountryId($walletTransactions->currency->country->id),
                    new CountryName($walletTransactions->currency->country->name)
                )
            ),
            new Promoter(
                new PromoterId($walletTransactions->promoter->id),
                new PromoterName($walletTransactions->promoter->name)
            ),
            new Bank(
                new BankId($walletTransactions->bank->id),
                new BankName($walletTransactions->bank->name)
            ),
            new Channel(
                new ChannelId($walletTransactions->channel->id),
                new ChannelName($walletTransactions->channel->name)
            )
        );
    }

    public function findTransactionById(int $walletId, int $transactionId): WalletTransaction
    {
        $walletModel = $this->model->find($walletId);
        if (!$walletModel) {
            throw new \InvalidArgumentException('Wallet not found', 404);
        }
        $transaction = $walletModel->transactions()->find($transactionId);
        if (!$transaction) {
            throw new \InvalidArgumentException('Wallet transaction not found', 404);
        }
        return $this->formatWalletTransaction($transaction);
    }

    public function transactionsPaginateFilter(int $walletId, int $page, int $perPage): array
    {
        $walletModel = $this->model->find($walletId);
        if (!$walletModel) {
            throw new \InvalidArgumentException('Wallet not found', 404);
        }
        $transactions = $walletModel->transactions()->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
        $transactionsArray = [];
        $transactions->each(function ($transaction) use (&$transactionsArray) {
            $transactionsArray[] = $this->formatWalletTransaction($transaction);
        });
        return $transactionsArray;
    }
}
