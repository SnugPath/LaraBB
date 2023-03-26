<?php

namespace App\Validators\CustomFieldValidators\Validators;

use App\Validators\CustomFieldValidators\Interfaces\CustomFieldTypeValidatorInterface;

class CustomFieldTextValidator implements CustomFieldTypeValidatorInterface
{
    public function isValid(string $content): bool
    {
        // A text has really no validation
        return true;
    }
}
