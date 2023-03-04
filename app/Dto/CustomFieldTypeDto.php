<?php

namespace App\Dto;

use App\Models\CustomFieldType;
use Carbon\Carbon;

class CustomFieldTypeDto
{
    public int $id;
    public string $name;
    public ?string $description;
    public Carbon $created_at;
    public Carbon $updated_at;

    public static function fromModel(CustomFieldType $custom_field_type): CustomFieldTypeDto
    {
        $dto = new CustomFieldTypeDto();
        $dto->id = $custom_field_type->id;
        $dto->name = $custom_field_type->name;
        $dto->description = $custom_field_type->description;
        $dto->created_at = $custom_field_type->created_at;
        $dto->updated_at = $custom_field_type->updated_at;
        return $dto;
    }
}
