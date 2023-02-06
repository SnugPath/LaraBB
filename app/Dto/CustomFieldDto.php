<?php

namespace App\Dto;

use App\Models\CustomField;
use Carbon\Carbon;

class CustomFieldDto
{
    public int $id;
    public string $name;
    public int $type;
    public ?string $default;
    public bool $required;
    public bool $active;
    public Carbon $created_at;
    public Carbon $updated_at;

    static function fromModel(CustomField $custom_field): CustomFieldDto
    {
        $dto = new CustomFieldDto();
        $dto->id = $custom_field->id;
        $dto->name = $custom_field->name;
        $dto->type = $custom_field->type;
        $dto->default = $custom_field->default;
        $dto->required = $custom_field->required;
        $dto->active = $custom_field->active;
        $dto->created_at = $custom_field->created_at;
        $dto->updated_at = $custom_field->updated_at;
        return $dto;
    }
}