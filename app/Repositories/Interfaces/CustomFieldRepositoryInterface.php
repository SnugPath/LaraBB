<?php

namespace App\Repositories\Interfaces;

use App\Dto\CustomFieldDto;

interface CustomFieldRepositoryInterface extends BaseRepositoryInterface
{
    public function customFieldExists($id): bool;
    public function create(CustomFieldDto $custom_field): CustomFieldDto;
}