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
        if (isset($forum->parent))
        {
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

        return ForumDto::fromModel($created_forum);
    }
    public function find_by_parent_id(int $parent_id, int $per_page = 10): array
    {
        $forums = $this->model->where('parent', $parent_id)->paginate($per_page);
        $forums_dto = [];
        foreach($forums as $forum)
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
            $forums_dto[] = $dto;
        }
        return $forums_dto;
    }

    public function edit(ForumDto $forum): ForumDto
    {
        $valid_forum = $this->forum_exists($forum->id);
        if(!$valid_forum)
        {
            throw new ModelNotFoundException('Invalid forum id passed');
        }

        $updated_forum = $this->model->where('id', $forum->id)->update([
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

        return ForumDto::fromModel($updated_forum);

    }

    public function forum_exists(int $id): bool
    {
        $forum = $this->model->find($id);
        return !is_null($forum);
    }
}
