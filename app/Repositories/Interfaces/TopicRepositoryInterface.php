<?php

namespace App\Repositories\Interfaces;

use App\Dto\TopicDto;

interface TopicRepositoryInterface extends BaseRepositoryInterface
{
    public function create(TopicDto $topic): TopicDto;
    public function findByForumId(int $forum_id, int $per_page = 10): array;
    public function edit(TopicDto $topic): TopicDto;
    public function topicExists(int $id): bool;
}
