<?php

namespace App\Repositories;

use App\Dto\RankDto;
use App\Models\Rank;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Repositories\Interfaces\RankRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RankRepository extends BaseRepository implements RankRepositoryInterface
{
    protected $group_repository;

    public function __construct(
        Rank $rank,
        GroupRepositoryInterface $group_repository
    )
    {
        parent::__construct($rank);
        $this->group_repository = $group_repository;
    }

    /**
     * @throws ModelNotFoundException when an invalid group id is passed.
     */
    public function create(RankDto $rank): RankDto
    {
        $valid_group = $this->group_repository->group_exists($rank->group_id);
        if(!$valid_group)
        {
            throw new ModelNotFoundException('Invalid group id passed');
        }

        $created_rank = $this->model->create([
            'group_id' => $rank->group_id,
            'name' => $rank->name
        ]);

        $dto = new RankDto();
        $dto->id = $created_rank->id;
        $dto->name = $created_rank->name;
        $dto->group_id = $created_rank->group_id;

        return $dto;
    }

    public function rank_exists($rank_id): bool
    {
        $group = $this->model->find($rank_id);
        return $group !== null;
    }
}