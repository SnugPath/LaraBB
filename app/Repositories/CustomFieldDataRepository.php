<?php

namespace App\Repositories;

use App\Dto\CustomFieldDataDto;
use App\Dto\CustomFieldDataLogDto;
use App\Exceptions\CustomField\InvalidCustomFieldContentException;
use App\Exceptions\CustomField\InvalidCustomFieldException;
use App\Models\CustomFieldData;
use App\Repositories\Interfaces\CustomFieldDataLogRepositoryInterface;
use App\Repositories\Interfaces\CustomFieldDataRepositoryInterface;
use App\Repositories\Interfaces\CustomFieldRepositoryInterface;
use App\Validators\CustomFieldValidators\Interfaces\CustomFieldValidatorInterface;

class CustomFieldDataRepository extends BaseRepository implements CustomFieldDataRepositoryInterface
{
    protected $model;
    private CustomFieldRepositoryInterface $custom_field_repository;
    private CustomFieldDataLogRepositoryInterface $custom_field_data_log_repository;
    private CustomFieldValidatorInterface $custom_field_validator;

    public function __construct(
        CustomFieldData $custom_field_data,
        CustomFieldRepositoryInterface $custom_field_repository,
        CustomFieldDataLogRepositoryInterface $custom_field_data_log_repository,
        CustomFieldValidatorInterface $custom_field_validator
    )
    {
        parent::__construct($custom_field_data);
        $this->custom_field_repository = $custom_field_repository;
        $this->custom_field_data_log_repository = $custom_field_data_log_repository;
        $this->custom_field_validator = $custom_field_validator;
    }


    /**
     * @throws InvalidCustomFieldException
     * @throws InvalidCustomFieldContentException
     */
    public function setCustomFieldValue(CustomFieldDataDto $custom_field_data): CustomFieldDataDto
    {
        $valid_custom_field = $this->custom_field_repository->customFieldExists($custom_field_data->custom_field_id);
        if(!$valid_custom_field)
        {
            throw new InvalidCustomFieldException("Custom field " . $custom_field_data->custom_field_id . " does not exist");
        }

        // Validate content
        if(!$this->custom_field_validator->isValid($custom_field_data->custom_field_id, $custom_field_data->content))
        {
            throw new InvalidCustomFieldContentException("Invalid custom field data content");
        }

        // Change data
        $custom_field_data_content = $this
            ->model
            ->where('user_id', '=', $custom_field_data->user_id)
            ->where('custom_field_id', '=', $custom_field_data->custom_field_id)
            ->first();
        if(is_null($custom_field_data_content))
        {
            $custom_field_data_content = $this->model->create([
                'custom_field_id' => $custom_field_data->custom_field_id,
                'content' => $custom_field_data->content ?? null,
                'user_id' => $custom_field_data->user_id
            ]);
        }
        else
        {
            $custom_field_data_content->content = $custom_field_data->content;
            $custom_field_data_content->save();
        }

        // Create log with the value
        $data_log = new CustomFieldDataLogDto();
        $data_log->content = $custom_field_data->content ?? null;
        $data_log->custom_field_id = $custom_field_data->custom_field_id;
        $data_log->updated_by = $custom_field_data->updated_by;

        $this->custom_field_data_log_repository->createLog($data_log);

        return CustomFieldDataDto::fromModel($custom_field_data_content);
    }
}
