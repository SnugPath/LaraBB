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
            "type" => $topic->type,
            "views" => $topic->views ?? 0,
            "status" => $topic->status ?? 1
        ]);

        $dto = new TopicDto();
        $dto->id = $created_topic->id;
        $dto->forum_id = $created_topic->forum_id;
        $dto->approved = $created_topic->approved;
        $dto->title = $created_topic->title;
        $dto->type = $created_topic->type;
        $dto->views = $created_topic->views;
        $dto->status = $created_topic->status;

        return $dto;

    }

    public function find_by_forum_id(int $forum_id, int $per_page = 10): array
    {
        $topics = $this->model->where('forum_id', $forum_id)->paginate($per_page);
        $topics_dto = [];
        foreach($topics as $topic)
        {
            $dto = new TopicDto();
            $dto->id = $topic->id;
            $dto->forum_id = $topic->forum_id;
            $dto->approved = $topic->approved;
            $dto->reported = $topic->reported;
            $dto->title = $topic->title;
            $dto->views = $topic->views;
            $dto->status = $topic->status;
            $dto->type = $topic->type;
            $dto->created_at = $topic->created_at;
            $dto->updated_at = $topic->updated_at;

            $topics_dto[] = $dto;
        }

        return $topics_dto;
    }

    public function edit(TopicDto $topic): TopicDto
    {
        $valid_forum = $this->forum_repository->forum_exists($topic->forum_id);
        if(!$valid_forum)
        {
            throw new ModelNotFoundException('Invalid forum id passed');
        }

        $updated_topic = $this->model->find($topic->id);
        $updated_topic->forum_id = $topic->forum_id;
        $updated_topic->approved = $topic->approved;
        $updated_topic->title = $topic->title;
        $updated_topic->type = $topic->type;
        $updated_topic->save();

        $dto = new TopicDto();
        $dto->id = $updated_topic->id;
        $dto->forum_id = $updated_topic->forum_id;
        $dto->approved = $updated_topic->approved;
        $dto->title = $updated_topic->title;
        $dto->type = $updated_topic->type;

        return $dto;
    }

    public function topic_exists(int $id): bool
    {
        $topic = $this->model->find($id);
        return !is_null($topic);
    }
}
