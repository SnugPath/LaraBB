<?php

namespace App\Repositories;

use App\Dto\ForumDto;
use App\Models\Forum;
use App\Repositories\Interfaces\ForumRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForumRepository extends BaseRepository implements ForumRepositoryInterface
{
    protected $model;

    public function __construct(Forum $forum)
    {
        parent::__construct($forum);
    }

    public function create(ForumDto $forum): ForumDto
    {
        if (isset($forum->parent)) {
            $valid_forum = $this->forum_exists($forum->parent);
            if(!$valid_forum)
            {
                throw new ModelNotFoundException('Invalid forum id passed');
            }
        }

        $created_forum = $this->model->create([
            "parent" => $forum->parent,
            "name" => $forum->name,
            "desc" => $forum->desc,
            "password" => $forum->password,
            "img" => $forum->img,
            "topics_per_page" => $forum->topics_per_page,
            "type" => $forum->type,
            "status" => $forum->status,
            "last_post" => $forum->last_post,
            "last_author" => $forum->last_author,
            "display_on_index" => $forum->display_on_index,
            "display_indexed" => $forum->display_indexed,
            "display_icons" => $forum->display_icons
        ]);

        $dto = new ForumDto();

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

    public function forum_exists(int $id): bool
    {
        $forum = $this->model->find($id);
        return !is_null($forum);
    }
}
