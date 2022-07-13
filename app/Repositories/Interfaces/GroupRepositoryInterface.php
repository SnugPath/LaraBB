<?php

namespace App\Repositories\Interfaces;

use App\Dto\GroupDto;

interface GroupRepositoryInterface extends BaseRepositoryInterface
{
    public function group_exists($id): bool;
    public function create(GroupDto $group): GroupDto;
}