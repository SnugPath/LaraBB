<?php

namespace App\Repositories;

use App\Dto\CustomFieldDataLogDto;
use App\Models\CustomFieldDataLog;
use App\Repositories\Interfaces\CustomFieldDataLogRepositoryInterface;

class CustomFieldDataLogRepository extends BaseRepository implements CustomFieldDataLogRepositoryInterface
{
    protected $model;

    public function __construct(CustomFieldDataLog $model)
    {
        parent::__construct($model);
    }

    public function createLog(CustomFieldDataLogDto $dto): CustomFieldDataLogDto
    {
        $created_model = $this->model->create([
            'content' => $dto->content,
            'updated_by' => $dto->updated_by,
            'custom_field_id' => $dto->custom_field_id
        ]);

        return CustomFieldDataLogDto::fromModel($created_model);
    }
}
