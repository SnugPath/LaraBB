<?php

namespace App\Repositories\Interfaces;

use App\Dto\CustomFieldDataLogDto;

interface CustomFieldDataLogRepositoryInterface extends BaseRepositoryInterface
{
    public function createLog(CustomFieldDataLogDto $dto): CustomFieldDataLogDto;
}
