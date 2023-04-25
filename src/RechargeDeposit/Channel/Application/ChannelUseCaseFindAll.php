<?php

namespace Src\RechargeDeposit\Channel\Application;

use Src\RechargeDeposit\Channel\Domain\Contracts\ChannelRepositoryInterface;

class ChannelUseCaseFindAll
{
    private ChannelRepositoryInterface $repository;

    public function __construct(ChannelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $channels = $this->repository->findAll();
        return array_map(function ($channel) {
            return $channel->toArray();
        }, $channels);
    }
}
