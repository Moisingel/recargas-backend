<?php

namespace Src\RechargeDeposit\Promoter\Infrastructure\Repositories;

use App\Models\Promoter as PromoterModel;
use Src\RechargeDeposit\Promoter\Domain\Contracts\PromoterRepositoryInterface;
use Src\RechargeDeposit\Promoter\Domain\Promoter;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterId;
use Src\RechargeDeposit\Promoter\Domain\ValueObjects\PromoterName;

class PromoterEloquentRepository implements PromoterRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new PromoterModel();
    }


    public function findById(int $id): Promoter
    {
        $promoter = $this->model->find($id);
        if (!$promoter) {
            throw new \Exception("Promoter not found");
        }
        return new Promoter(
            new PromoterId($promoter->id),
            new PromoterName($promoter->name)
        );
    }
}
