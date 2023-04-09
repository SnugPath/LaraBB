<?php

namespace App\Dto;

use App\Models\BannedWord;

class BannedWordDto
{
    public int $id;
    public string $word;

    public static function fromModel(BannedWord $bannedWord): BannedWordDto
    {
        $dto = new BannedWordDto();
        $dto->id = $bannedWord->id;
        $dto->word = $bannedWord->word;
        return $dto;
    }
}
