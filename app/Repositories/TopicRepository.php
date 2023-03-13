<?php

namespace App\Repositories;

use App\Dto\TopicDto;
use App\Models\Topic;
use App\Repositories\Interfaces\ForumRepositoryInterface;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface
{

    protected ForumRepositoryInterface $forum_repository;


    public function __construct(
        Topic $topic,
        ForumRepositoryInterface $forum_repository
    )
    {
        parent::__construct($topic);
        $this->forum_repository = $forum_repository;
    }

    public function create(TopicDto $topic): TopicDto
    {
        $valid_forum = $this->forum_repository->forum_exists($topic->forum_id);
        if(!$valid_forum)
        {
            throw new ModelNotFoundException('Invalid forum id passed');
        }

        $created_topic = $this->model->create([
            "forum_id" => $topic->forum_id,
            "approved" => $topic->approved,
            "title" => $topic->title,
            "type" => $topic->type
        ]);

        $dto = new TopicDto();
        $dto->id = $created_topic->id;
        $dto->forum_id = $created_topic->forum_id;
        $dto->approved = $created_topic->approved;
        $dto->title = $created_topic->title;
        $dto->type = $created_topic->type;

        return $dto;

    }

    public function topic_exists(int $id): bool
    {
        $topic = $this->model->find($id);
        return !is_null($topic);
    }
}
