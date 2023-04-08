<?php

namespace App\Dto;

use App\Models\Forum;
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
    public ?int $last_post;
    public ?int $last_author;
    public bool $display_on_index;
    public bool $display_indexed;
    public bool $display_icons;
    public Carbon $created_at;
    public Carbon $updated_at;

    public static function fromModel(Forum $forum): ForumDto
    {
        $dto = new ForumDto();
        $dto->id = $forum->id;
        $dto->parent = $forum->parent;
        $dto->name = $forum->name;
        $dto->desc = $forum->desc;
        $dto->password = $forum->password;
        $dto->img = $forum->img;
        $dto->topics_per_page = $forum->topics_per_page;
        $dto->type = $forum->type;
        $dto->status = $forum->status;
        $dto->last_post = $forum->last_post;
        $dto->last_author = $forum->last_author;
        $dto->display_on_index = $forum->display_on_index;
        $dto->display_indexed = $forum->display_indexed;
        $dto->display_icons = $forum->display_icons;

        return $dto;
    }
}
