<?php

namespace App\Repositories\Interfaces;

use App\Dto\RankDto;
use App\Models\Rank;

interface RankRepositoryInterface extends BaseRepositoryInterface
{
    public function create(RankDto $rank): Rank;
}