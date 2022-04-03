<?php

namespace App\Dto;

use Carbon\Carbon;

class ForumDto
{
    public int $id;
    public ?int $parent;
    public string $name;
    public ?string $desc;
    public ?string $password;
    public ?string $img;
    public int $topics_per_page;
    public int $type;
    public int $status;
    public int $last_post;
    public int $last_author;
    public bool $display_on_index;
    public bool $display_indexed;
    public bool $display_icons;
    public Carbon $created_at;
    public Carbon $updated_at;
}