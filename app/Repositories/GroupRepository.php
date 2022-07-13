<?php

namespace App\Repositories;

use App\Dto\GroupDto;
use App\Models\Group;
use App\Repositories\Interfaces\GroupRepositoryInterface;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{
    protected $model;
    private $default_color = '000000';
    private $default_image = '';

    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    public function create(GroupDto $group): GroupDto
    {
        $created_group = $this->model->create([
            'name' => $group->name,
            'desc' => $group->desc,
            'display' => $group->display,
            'img' => isset($group->img) ? $group->img : $this->default_image,
            'color' => isset($group->color)? $group->color : $this->default_color
        ]);

        $response_dto = new GroupDto();
        $response_dto->id = $created_group->id;
        $response_dto->name = $created_group->name;
        $response_dto->desc = $created_group->desc;
        $response_dto->display = $created_group->display;
        $response_dto->img = $created_group->img;
        $response_dto->color = $created_group->color;


        return $response_dto;
    }

    public function group_exists($id): bool
    {
        $group = $this->model->find($id);
        return !is_null($group);
    }
}