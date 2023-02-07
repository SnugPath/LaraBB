<?php

namespace App\Repositories;

use App\Dto\CustomFieldDto;
use App\Exceptions\CustomField\CustomFieldNameRequiredException;
use App\Exceptions\CustomField\InvalidCustomFieldException;
use App\Models\CustomField;
use App\Repositories\Interfaces\CustomFieldRepositoryInterface;
use App\Repositories\Interfaces\CustomFieldTypeRepositoryInterface;

class CustomFieldRepository extends BaseRepository implements CustomFieldRepositoryInterface
{
    protected $model;
    private CustomFieldTypeRepositoryInterface $custom_field_type_repository;

    public function __construct(
        CustomField $custom_field,
        CustomFieldTypeRepositoryInterface $custom_field_type_repository)
    {
        parent::__construct($custom_field);
        $this->custom_field_type_repository = $custom_field_type_repository;
    }

    public function customFieldExists($id): bool
    {
        $custom_field = $this->model->find($id);
        return !is_null($custom_field);
    }

    /**
     * @throws CustomFieldNameRequiredException
     * @throws InvalidCustomFieldException
     */
    public function create(CustomFieldDto $custom_field): CustomFieldDto
    {
        if(!isset($custom_field->type) || !$this->custom_field_type_repository->isValidType($custom_field->type))
        {
            throw new InvalidCustomFieldException("Invalid custom field type");
        }

        if(strlen(trim($custom_field->name ?? '')) == 0)
        {
            throw new CustomFieldNameRequiredException("Custom field name is required");
        }

        $created_custom_field = $this->model->create([
            'name' => $custom_field->name,
            'type' => $custom_field->type,
            'default' => $custom_field->default,
            'required' => $custom_field->required,
            'active' => $custom_field->active
        ]);

        return CustomFieldDto::fromModel($created_custom_field);
    }
}
