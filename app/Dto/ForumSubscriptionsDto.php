<?php

namespace App\Dto;

use App\Models\ForumSubscriptions;

class ForumSubscriptionsDto
{
    public int $user_id;
    public int $forum_id;
    public int $status;

    public static function fromModel(ForumSubscriptions $forum_subscriptions): ForumSubscriptionsDto
    {
        $dto = new ForumSubscriptionsDto();
        $dto->user_id = $forum_subscriptions->user_id;
        $dto->forum_id = $forum_subscriptions->forum_id;
        $dto->status = $forum_subscriptions->status;
        return $dto;
    }
}
