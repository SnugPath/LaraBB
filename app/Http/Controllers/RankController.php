<?php

namespace App\Http\Controllers;

use App\Dto\RankDto;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Repositories\Interfaces\RankRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;


class RankController extends Controller
{
    private RankRepositoryInterface $rank_repository;
    private GroupRepositoryInterface $group_repository;

    public function __construct(
        RankRepositoryInterface $rank_repository,
        GroupRepositoryInterface $group_repository
    ) {
        $this->rank_repository = $rank_repository;
        $this->group_repository = $group_repository;
    }

    public function create_rank(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        if (!isset($data['name']) || strlen(trim($data['name'])) == 0)
        {
            return $this->return_json_response(400, ["error" => "A rank name is required"]);
        }

        $group_exists = isset($data['group_id']) && $this->group_repository->group_exists($data['group_id']);

        if (!$group_exists)
        {
            return $this->return_json_response(400, ["error" => "Invalid group"]);
        }

        $dto = new RankDto();
        $dto->name = $data['name'];
        $dto->group_id = $data['group_id'];

        $code = 200;
        $data = [];
        try
        {
            $created_rank = $this->rank_repository->create($dto);
            $data = ["rank" => $created_rank];
        }
        catch(Exception $ex)
        {
            $code = 500;
            $data = ["error" => "Error creating rank"];
        }
        return $this->return_json_response($code, $data);
    }
}
