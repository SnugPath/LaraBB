<?php

namespace App\Repositories\Interfaces;

use App\Dto\DraftDto;

interface DraftRepositoryInterface extends BaseRepositoryInterface
{
    public function create(DraftDto $draft): DraftDto;
    public function edit(DraftDto $draft): DraftDto;
    public function deleteDraft(int $draft_id, int $user_id);
}
