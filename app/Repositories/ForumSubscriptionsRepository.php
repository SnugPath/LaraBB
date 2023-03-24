<?php

namespace App\Repositories;

use App\Dto\ForumSubscriptionsDto;
use App\Repositories\Interfaces\ForumRepositoryInterface;
use App\Repositories\Interfaces\ForumSubscriptionsRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForumSubscriptionsRepository implements ForumSubscriptionsRepositoryInterface
{

    protected $model;
    protected $user_repository;
    protected $Forum_repository;

    public function __construct(
        $model,
        UserRepositoryInterface $user_repository,
        ForumRepositoryInterface $Forum_repository
    )
    {
        $this->model = $model;
        $this->user_repository = $user_repository;
        $this->Forum_repository = $Forum_repository;
    }

    public function find(int $user_id, int $forum_id): ForumSubscriptionsDto
    {
        $Forum_subscriptions = $this->model->where('user_id', $user_id)->where('forum_id', $forum_id)->first();
        if ($Forum_subscriptions == null)
        {
            throw new ModelNotFoundException("Forum subscription not found");
        }
        return $Forum_subscriptions;
    }

    public function create(ForumSubscriptionsDto $Forum_subscriptions): ForumSubscriptionsDto
    {
        $user_exist = $this->user_repository->find($Forum_subscriptions->user_id);
        if ($user_exist == null)
        {
            throw new ModelNotFoundException("Forum subscription not found");
        }

        $Forum_exist = $this->Forum_repository->find($Forum_subscriptions->forum_id);
        if ($Forum_exist == null)
        {
            throw new ModelNotFoundException("Forum not found");
        }

        $Forum_subscriptions_exist = $this->model->where('user_id', $Forum_subscriptions->user_id)->where('forum_id', $Forum_subscriptions->forum_id)->first();
        if (isset($Forum_subscriptions_exist))
        {
            throw new ModelNotFoundException("Forum subscription already exists");
        }


        $created_Forum_subscriptions = $this->model->create([
            'user_id' => $Forum_subscriptions->user_id,
            'forum_id' => $Forum_subscriptions->forum_id,
            'status' => $Forum_subscriptions->status,
        ]);

        $dto = new ForumSubscriptionsDto();
        $dto->user_id = $created_Forum_subscriptions->user_id;
        $dto->forum_id = $created_Forum_subscriptions->forum_id;
        $dto->status = $created_Forum_subscriptions->status;
        return $dto;

    }

    public function edit(ForumSubscriptionsDto $Forum_subscriptions): ForumSubscriptionsDto
    {
        $updated_Forum_subscriptions = $this->model->where('user_id', $Forum_subscriptions->user_id)->where('forum_id', $Forum_subscriptions->forum_id)->first();
        if ($updated_Forum_subscriptions == null)
        {
            throw new ModelNotFoundException("Forum subscription does not exist");
        }
        $updated_Forum_subscriptions->status = $Forum_subscriptions->status;
        $updated_Forum_subscriptions->save();

        $dto = new ForumSubscriptionsDto();
        $dto->user_id = $updated_Forum_subscriptions->user_id;
        $dto->forum_id = $updated_Forum_subscriptions->forum_id;
        $dto->status = $updated_Forum_subscriptions->status;
        return $dto;

    }

    public function delete(int $user_id, int $forum_id): void
    {
        $Forum_subscriptions = $this->model->where('user_id', $user_id)->where('forum_id', $forum_id)->first();
        if ($Forum_subscriptions == null)
        {
            throw new ModelNotFoundException("Forum subscription does not exist");
        }
        $Forum_subscriptions->delete();
    }

}
