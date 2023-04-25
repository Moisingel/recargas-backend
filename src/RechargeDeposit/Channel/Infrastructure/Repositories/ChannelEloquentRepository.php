<?php

namespace Src\RechargeDeposit\Channel\Infrastructure\Repositories;

use App\Models\Channel as ChannelModel;
use Src\RechargeDeposit\Channel\Domain\Channel;
use Src\RechargeDeposit\Channel\Domain\Contracts\ChannelRepositoryInterface;
use Src\RechargeDeposit\Channel\Domain\ValueObjects\ChannelId;
use Src\RechargeDeposit\Channel\Domain\ValueObjects\ChannelName;

class ChannelEloquentRepository implements ChannelRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new ChannelModel();
    }

    public function findAll(): array
    {
        $channels = $this->model->all();
        $channelsArray = [];
        $channels->each(function ($channel) use (&$channelsArray) {
            $channelsArray[] = new Channel(
                new ChannelId($channel->id),
                new ChannelName($channel->name)
            );
        });
        return $channelsArray;
    }

    public function findById(int $id): Channel
    {
        $channel = $this->model->find($id);
        if (!$channel) {
            throw new \InvalidArgumentException('Channel not found', 404);
        }
        return new Channel(
            new ChannelId($channel->id),
            new ChannelName($channel->name)
        );
    }
}
