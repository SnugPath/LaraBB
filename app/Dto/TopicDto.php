<?php

namespace App\Dto;

use Carbon\Carbon;

class TopicDto
{
    public int $id;
    public int $forum_id;
    public bool $approved;
    public bool $reported;
    public string $title;
    public int $views;
    public int $status;
    public int $type;
    public Carbon $created_at;
    public Carbon $updated_at;

}
