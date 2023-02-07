<?php

namespace App\Repositories;

use App\Dto\CustomFieldDataDto;
use App\Exceptions\CustomField\InvalidCustomFieldException;
use App\Models\CustomFieldData;
use App\Repositories\Interfaces\CustomFieldDataRepositoryInterface;
use App\Repositories\Interfaces\CustomFieldRepositoryInterface;

class CustomFieldDataRepository extends BaseRepository implements CustomFieldDataRepositoryInterface
{
    protected $model;
    private CustomFieldRepositoryInterface $custom_field_repository;

    public function __construct(
        CustomFieldData $custom_field_data,
        CustomFieldRepositoryInterface $custom_field_repository)
    {
        parent::__construct($custom_field_data);
        $this->custom_field_repository = $custom_field_repository;
    }


    /**
     * @throws InvalidCustomFieldException
     */
    public function create(CustomFieldDataDto $custom_field_data)
    {
        $valid_custom_field = $this->custom_field_repository->customFieldExists($custom_field_data->custom_field_id);
        if(!$valid_custom_field)
        {
            throw new InvalidCustomFieldException("Custom field " . $custom_field_data->custom_field_id . " does not exist");
        }
    }
}
