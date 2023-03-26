<?php

namespace App\Validators\CustomFieldValidators\Interfaces;

interface CustomFieldTypeValidatorInterface
{
    public function isValid(string $content): bool;
}
