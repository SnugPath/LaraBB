<?php

namespace App\Repositories;

use App\Models\Forum;
use App\Repositories\Interfaces\ForumRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForumRepository extends BaseRepository implements ForumRepositoryInterface
{
    protected $model;

    public function __construct(Forum $forum)
    {
        parent::__construct($forum);
    }

    public function forum_exists(int $id): bool
    {
        $forum = $this->model->find($id);
        return !is_null($forum);
    }
}
