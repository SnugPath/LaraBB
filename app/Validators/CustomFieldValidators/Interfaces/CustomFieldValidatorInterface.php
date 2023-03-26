<?php

namespace App\Validators\CustomFieldValidators\Interfaces;

use App\Enums\CustomFieldTypeEnum;

interface CustomFieldValidatorInterface
{
    public function isValid(int $custom_field_id, string $content): bool;
}
