<?php

namespace App\Validators\CustomFieldValidators;

use App\Enums\CustomFieldTypeEnum;
use App\Exceptions\CustomField\InvalidCustomFieldTypeException;
use App\Helpers\Utils\StringUtils;
use App\Repositories\Interfaces\CustomFieldRepositoryInterface;
use App\Validators\CustomFieldValidators\Interfaces\CustomFieldValidatorInterface;
use App\Validators\CustomFieldValidators\Validators\CustomFieldNumberValidator;
use App\Validators\CustomFieldValidators\Validators\CustomFieldTextValidator;

class CustomFieldValidator implements CustomFieldValidatorInterface
{
    private CustomFieldRepositoryInterface $custom_field_repository;

    public function __construct(
        CustomFieldRepositoryInterface $custom_field_repository
    )
    {
        $this->custom_field_repository = $custom_field_repository;
    }

    /**
     * @param int $custom_field_id
     * @param string $content
     * @return bool
     * @throws InvalidCustomFieldTypeException
     */
    public function isValid(int $custom_field_id, string $content): bool
    {
        $custom_field = $this->custom_field_repository->find($custom_field_id);
        if(is_null($custom_field))
        {
            return false;
        }

        if ($custom_field->required && StringUtils::isNullOrWhiteSpace($content))
        {
            return false;
        }

        if (!$custom_field->required && StringUtils::isNullOrWhiteSpace($content))
        {
            return true;
        }

        $validator = match ($custom_field->type) {
            CustomFieldTypeEnum::Text->value => new CustomFieldTextValidator(),
            CustomFieldTypeEnum::Number->value => new CustomFieldNumberValidator(),
            default => throw new InvalidCustomFieldTypeException("Invalid custom field type"),
        };

        return $validator->isValid($content);
    }
}
