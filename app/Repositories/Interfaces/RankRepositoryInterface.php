<?php

namespace App\Repositories\Interfaces;

use App\Dto\RankDto;

interface RankRepositoryInterface extends BaseRepositoryInterface
{
    public function create(RankDto $rank): RankDto;
}
