<?php

namespace App\Http\Controllers;

use App\Dto\CustomFieldDto;
use App\Repositories\Interfaces\CustomFieldRepositoryInterface;
use App\Repositories\Interfaces\CustomFieldTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    private CustomFieldTypeRepositoryInterface $custom_field_type_repository;
    private CustomFieldRepositoryInterface $custom_field_repository;

    public function __construct(
        CustomFieldTypeRepositoryInterface $custom_field_type_repository,
        CustomFieldRepositoryInterface $custom_field_repository
    )
    {
        $this->custom_field_type_repository = $custom_field_type_repository;
        $this->custom_field_repository = $custom_field_repository;
    }

    /**
     * Creates a new custom field with the given details
     * @param Request $request
     * @return JsonResponse
     */
    public function createCustomField(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        if (!isset($data['name']) || strlen(trim($data['name'])) == 0)
        {
            return $this->return_json_response(400, ["error" => "A Custom Field name is required"]);
        }

        if (!isset($data['customFieldTypeId']) || !is_int($data['customFieldTypeId']))
        {
            return $this->return_json_response(400, ["error" => "Custom field type id is mandatory"]);
        }

        if (!isset($data['required']) || !is_bool($data['required']))
        {
            return $this->return_json_response(400, ["error" => "'Required' property must be a valid boolean"]);
        }

        if (!isset($data['active']) || !is_bool($data['active']))
        {
            return $this->return_json_response(400, ["error" => "'Active' property must be a valid boolean"]);
        }

        $valid_type = $this->custom_field_type_repository->isValidType($data['customFieldTypeId']);
        if(!$valid_type)
        {
            return $this->return_json_response(400, ["error" => "Invalid custom field type sent"]);
        }

        $dto = new CustomFieldDto();
        $dto->name = $data['name'];
        $dto->type = (int)$data['customFieldTypeId'];
        $dto->default = $data['default_value'] ?? null;
        $dto->required = $data['required'];
        $dto->active = $data['active'];

        $data = [];
        $code = 200;
        try
        {
            $created_custom_field = $this->custom_field_repository->create($dto);
            $data = [
                "customField" => $created_custom_field
            ];
        }
        catch (\Exception $ex)
        {
            $code = 500;
            $data = ["error" => "Error creating custom field"];
        }

        return $this->return_json_response($code, $data);
    }
}
