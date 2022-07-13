<?php

namespace App\Http\Controllers;

use App\Dto\GroupDto;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use Illuminate\Http\Request;
use Exception;


class GroupController extends Controller
{
    private GroupRepositoryInterface $group_repository;

    public function __construct(
        GroupRepositoryInterface $group_repository
    ) {
        $this->group_repository = $group_repository;
    }

    public function create_group(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->json()->all();
        $required_fields =
        [
            'name',
            'description'
        ];

        if(!$request->has($required_fields))
        {
            return $this->return_json_response(400, ["error" => "Missing required fields"]);
        }
        
        $dto = new GroupDto();
        $dto->name = $data['name'];
        $dto->desc = $data['description'];
        $dto->display = isset($data['display']) && $data['display'] == '1';

        if(isset($data['image']))
        {
            $dto->image = $data['image'];
        }

        if(isset($data['color']))
        {
            $dto->color = $data['color'];
        }

        try
        {
            $created_group = $this->group_repository->create($dto);
            return $this->return_json_response(200, ["group" => $created_group]);   
        }
        catch(Exception $ex)
        {
            return $this->return_json_response(500, ["error" => "Error creating group", "message" => $ex->getMessage()]);
        }
    }
}
