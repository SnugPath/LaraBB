<?php

namespace App\Validators\CustomFieldValidators\Validators;

use App\Validators\CustomFieldValidators\Interfaces\CustomFieldTypeValidatorInterface;

class CustomFieldNumberValidator implements CustomFieldTypeValidatorInterface
{
    public function isValid(string $content): bool
    {
        return filter_var($content, FILTER_VALIDATE_INT) !== false;
    }
}
