<?php

namespace Src\RechargeDeposit\Bank\Infrastructure\Repositories;

use App\Models\Bank as BankModel;
use Src\RechargeDeposit\Bank\Domain\Bank;
use Src\RechargeDeposit\Bank\Domain\Contracts\BankRepositoryInterface;
use Src\RechargeDeposit\Bank\Domain\ValueObjects\BankId;
use Src\RechargeDeposit\Bank\Domain\ValueObjects\BankName;

class BankEloquentRepository implements BankRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new BankModel();
    }

    public function findAll(): array
    {
        $banks = $this->model->all();
        $banksArray = [];
        $banks->each(function ($bank) use (&$banksArray) {
            $banksArray[] = new Bank(
                new BankId($bank->id),
                new BankName($bank->name)
            );
        });
        return $banksArray;
    }

    public function findById(int $id): Bank
    {
        $bank = $this->model->find($id);
        if (!$bank) {
            throw new \InvalidArgumentException('Bank not found', 404);
        }
        return new Bank(
            new BankId($bank->id),
            new BankName($bank->name)
        );
    }
}
