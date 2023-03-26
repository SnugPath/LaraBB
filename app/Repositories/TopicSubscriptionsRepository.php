<?php

namespace App\Repositories;

use App\Dto\TopicSubscriptionsDto;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use App\Repositories\Interfaces\TopicSubscriptionsRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TopicSubscriptionsRepository implements TopicSubscriptionsRepositoryInterface
{

    protected $model;
    protected $user_repository;
    protected $topic_repository;

    public function __construct(
        $model,
        UserRepositoryInterface $user_repository,
        TopicRepositoryInterface $topic_repository
    )
    {
        $this->model = $model;
        $this->user_repository = $user_repository;
        $this->topic_repository = $topic_repository;
    }

    public function find(int $user_id, int $topic_id): TopicSubscriptionsDto
    {
        $topic_subscriptions = $this->model->where('user_id', $user_id)->where('topic_id', $topic_id)->first();
        if ($topic_subscriptions == null)
        {
            throw new ModelNotFoundException("Topic subscription not found");
        }
        return $topic_subscriptions;
    }

    public function create(TopicSubscriptionsDto $topic_subscriptions): TopicSubscriptionsDto
    {
        $user_exist = $this->user_repository->find($topic_subscriptions->user_id);
        if ($user_exist == null)
        {
            throw new ModelNotFoundException("user not found");
        }

        $topic_exist = $this->topic_repository->find($topic_subscriptions->topic_id);
        if ($topic_exist == null)
        {
            throw new ModelNotFoundException("Topic subscription not found");
        }

        $topic_subscriptions_exist = $this->model->where('user_id', $topic_subscriptions->user_id)->where('topic_id', $topic_subscriptions->topic_id)->first();
        if (isset($topic_subscriptions_exist))
        {
            throw new ModelNotFoundException("Topic subscription already exists");
        }


        $created_topic_subscriptions = $this->model->create([
            'user_id' => $topic_subscriptions->user_id,
            'topic_id' => $topic_subscriptions->topic_id,
            'status' => $topic_subscriptions->status,
        ]);

        $dto = new TopicSubscriptionsDto();
        $dto->user_id = $created_topic_subscriptions->user_id;
        $dto->topic_id = $created_topic_subscriptions->topic_id;
        $dto->status = $created_topic_subscriptions->status;
        return $dto;

    }

    public function edit(TopicSubscriptionsDto $topic_subscriptions): TopicSubscriptionsDto
    {
        $updated_topic_subscriptions = $this->model->where('user_id', $topic_subscriptions->user_id)->where('topic_id', $topic_subscriptions->topic_id)->first();
        if ($updated_topic_subscriptions == null)
        {
            throw new ModelNotFoundException("Topic subscription does not exist");
        }
        $updated_topic_subscriptions->status = $topic_subscriptions->status;
        $updated_topic_subscriptions->save();

        $dto = new TopicSubscriptionsDto();
        $dto->user_id = $updated_topic_subscriptions->user_id;
        $dto->topic_id = $updated_topic_subscriptions->topic_id;
        $dto->status = $updated_topic_subscriptions->status;
        return $dto;

    }

    public function delete(int $user_id, int $topic_id): void
    {
        $topic_subscriptions = $this->model->where('user_id', $user_id)->where('topic_id', $topic_id)->first();
        if ($topic_subscriptions == null)
        {
            throw new ModelNotFoundException("Topic subscription does not exist");
        }
        $topic_subscriptions->delete();
    }

}
