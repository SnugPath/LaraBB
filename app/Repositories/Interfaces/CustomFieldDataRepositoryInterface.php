<?php

namespace App\Repositories\Interfaces;
use App\Dto\CustomFieldDataDto;

interface CustomFieldDataRepositoryInterface extends BaseRepositoryInterface
{
    public function setCustomFieldValue(CustomFieldDataDto $custom_field_data): CustomFieldDataDto;
}
