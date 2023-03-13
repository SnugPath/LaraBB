<?php

namespace App\Repositories\Interfaces;

use App\Dto\TopicDto;

interface TopicRepositoryInterface extends BaseRepositoryInterface
{
    public function create(TopicDto $topic): TopicDto;

    public function topic_exists(int $id): bool;
}
