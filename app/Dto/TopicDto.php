<?php

namespace App\Dto;

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
    public string $created_at;
    public string $updated_at;

}
