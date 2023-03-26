<?php

namespace App\Dto;

use App\Models\CustomFieldData;
use Carbon\Carbon;

class CustomFieldDataDto
{

    public int $custom_field_id;
    public int $user_id;
    public string $content;
    public int $updated_by;
    public Carbon $created_at;
    public Carbon $updated_at;

    public static function fromModel(CustomFieldData $data): CustomFieldDataDto
    {
        $dto = new CustomFieldDataDto();
        $dto->custom_field_id = $data->cf_id;
        $dto->user_id = $data->user_id;
        $dto->content = $data->content;
        $dto->created_at = $data->created_at;
        $dto->updated_at = $data->updated_at;

        return $dto;
    }
}
