<?php

namespace App\Repositories\Interfaces;

use App\Dto\PostDto;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function create(PostDto $post): PostDto;
    public function findByTopicId(int $topic_id): array;
    public function findByUserId(int $user_id, int $per_page = 10): array;
    public function edit(PostDto $post): PostDto;
    public function findByDraftId($draft_id);


}
