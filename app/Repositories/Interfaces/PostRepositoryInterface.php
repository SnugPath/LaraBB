<?php

namespace App\Repositories\Interfaces;

use App\Dto\PostDto;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function create(PostDto $post): PostDto;

    public function find_by_topic_id(int $topic_id): array;

}
