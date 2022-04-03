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
}