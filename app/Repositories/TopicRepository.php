<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TopicRepositoryInterface;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface
{

    public function topic_exists(int $id): bool
    {
        $topic = $this->model->find($id);
        return !is_null($topic);
    }
}
