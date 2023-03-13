<?php

namespace App\Repositories\Interfaces;

interface TopicRepositoryInterface extends BaseRepositoryInterface
{
    public function topic_exists(int $id): bool;
}
