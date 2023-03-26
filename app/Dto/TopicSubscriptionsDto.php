<?php

namespace App\Dto;

use App\Models\TopicSubscriptions;

class TopicSubscriptionsDto
{
    public int $user_id;
    public int $topic_id;
    public int $status;

    public static function fromModel(TopicSubscriptions $topic_subscriptions): TopicSubscriptionsDto
    {
        $dto = new TopicSubscriptionsDto();
        $dto->user_id = $topic_subscriptions->user_id;
        $dto->topic_id = $topic_subscriptions->topic_id;
        $dto->status = $topic_subscriptions->status;
        return $dto;
    }
}
