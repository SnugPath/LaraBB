<?php

namespace App\Repositories\Interfaces;

use App\Dto\TopicSubscriptionsDto;

interface TopicSubscriptionsRepositoryInterface
{
    public function find(int $user_id, int $topic_id): TopicSubscriptionsDto;
    public function create(TopicSubscriptionsDto $topic_subscriptions_dto): TopicSubscriptionsDto;
    public function edit(TopicSubscriptionsDto $topic_subscriptions_dto): TopicSubscriptionsDto;
    public function delete(int $user_id, int $topic_id): void;


}
