<?php

namespace App\Repositories\Interfaces;

use App\Dto\BannedWordDto;

interface BannedWordRepositoryInterface extends BaseRepositoryInterface
{
    public function isBannedWord(string $word): bool;
    public function containsBannedWord(string $text): bool;
    public function createBannedWord(BannedWordDto $dto): BannedWordDto;
    public function deleteBannedWord(string $word): void;
}
