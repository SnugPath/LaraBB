<?php

namespace App\Repositories\Interfaces;

interface ForumRepositoryInterface extends BaseRepositoryInterface
{
    public function forum_exists(int $id): bool;

}
