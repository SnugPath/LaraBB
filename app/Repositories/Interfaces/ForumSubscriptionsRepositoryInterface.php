<?php

namespace App\Repositories\Interfaces;

use App\Dto\ForumSubscriptionsDto;

interface ForumSubscriptionsRepositoryInterface
{
    public function find(int $user_id, int $Forum_id): ForumSubscriptionsDto;
    public function create(ForumSubscriptionsDto $Forum_subscriptions_dto): ForumSubscriptionsDto;
    public function edit(ForumSubscriptionsDto $Forum_subscriptions_dto): ForumSubscriptionsDto;
    public function delete(int $user_id, int $Forum_id): void;


}
