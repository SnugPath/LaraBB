<?php

namespace App\Dto;

use App\Models\CustomFieldDataLog;

class CustomFieldDataLogDto
{
    public int $custom_field_id;
    public ?string $content;
    public int $updated_by;

    public static function fromModel(CustomFieldDataLog $custom_field_data_log): CustomFieldDataLogDto
    {
        $dto = new CustomFieldDataLogDto();
        $dto->content = $custom_field_data_log->content ?? null;
        $dto->custom_field_id = $custom_field_data_log->custom_field_id;
        $dto->updated_by = $custom_field_data_log->updated_by;
        return $dto;
    }
}
