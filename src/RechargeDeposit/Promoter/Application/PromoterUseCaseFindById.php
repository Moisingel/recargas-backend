<?php

namespace Src\RechargeDeposit\Promoter\Application;

use Src\RechargeDeposit\Promoter\Domain\Contracts\PromoterRepositoryInterface;

class PromoterUseCaseFindById
{
    private PromoterRepositoryInterface $promoterRepository;

    public function __construct(PromoterRepositoryInterface $promoterRepository)
    {
        $this->promoterRepository = $promoterRepository;
    }

    public function execute(int $id)
    {
        return $this->promoterRepository->findById($id)->toArray();
    }

}
