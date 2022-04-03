<?php

namespace App\Repositories;

use App\Dto\GroupDto;
use App\Models\Group;
use App\Repositories\Interfaces\GroupRepositoryInterface;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{
    protected $model;

    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    public function create(GroupDto $group): Group
    {
        $created_group = new $this->model();
        $created_group->name = $group->name;
        $created_group->desc = $group->desc;
        $created_group->display = $group->display;
        $created_group->img = $group->img;
        $created_group->color = $group->color;

        $created_group->save();

        return $created_group;
    }

    public function group_exists($id): bool
    {
        $group = $this->model->find($id);
        return $group !== null;
    }
}