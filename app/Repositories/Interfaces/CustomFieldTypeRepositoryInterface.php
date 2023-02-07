<?php

namespace App\Repositories\Interfaces;

interface CustomFieldTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function getCustomFieldTypes();
    public function isValidType(int $id): bool;
}
