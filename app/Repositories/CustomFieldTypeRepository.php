<?php

namespace App\Repositories;

use App\Dto\CustomFieldTypeDto;
use App\Models\CustomFieldType;
use App\Repositories\Interfaces\CustomFieldTypeRepositoryInterface;

class CustomFieldTypeRepository extends BaseRepository implements CustomFieldTypeRepositoryInterface
{
    protected $model;

    public function __construct(
        CustomFieldType $custom_field_type
    )
    {
        parent::__construct($custom_field_type);
    }

    /**
     * Get a list of all custom field types
     * @return array
     */
    public function getCustomFieldTypes()
    {
        $values = $this->model::all();
        $types = [];

        foreach ($values as $custom_field_type)
        {
            $types[] = CustomFieldTypeDto::fromModel($custom_field_type);
        }

        return $types;
    }

    /**
     * Checks if a id is a valid custom field type
     * @param int $id
     * @return bool
     */
    public function isValidType(int $id): bool
    {
        $custom_field_type = $this->model->find($id);
        return !is_null($custom_field_type);
    }
}
