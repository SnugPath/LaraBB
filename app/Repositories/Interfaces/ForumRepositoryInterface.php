<?php

namespace App\Repositories\Interfaces;

use App\Dto\ForumDto;

interface ForumRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ForumDto $forum): ForumDto;
    public function findByParentId(int $parent_id, int $per_page = 10): array;
    public function edit(ForumDto $forum): ForumDto;
    public function forumExists(int $id): bool;

}
