<?php

namespace App\Dto;

use Carbon\Carbon;

class PostDto
{
    public int $id;
    public int $topic_id;
    public int $author;
    public bool $approved;
    public bool $reported;
    public string $content;
    public string $edit_reason;
    public int $edit_count;
    public int $edit_user;
    public Carbon $created_at;
    public Carbon $updated_at;
}
