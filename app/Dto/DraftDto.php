<?php

namespace App\Dto;

use App\Models\Draft;
use Carbon\Carbon;

class DraftDto
{
    public int $id;
    public int $topic_id;
    public int $user_id;
    public ?string $subject;
    public string $content;
    public Carbon $created_at;
    public Carbon $updated_at;

    public static function fromModel(Draft $draft): DraftDto
    {
        $dto = new DraftDto();
        $dto->id = $draft->id;
        $dto->content = $draft->content;
        $dto->topic_id = $draft->topic_id;
        $dto->user_id = $draft->user_id;
        $dto->subject = $draft->subject ?? null;
        $dto->created_at = $draft->created_at;
        $dto->updated_at = $draft->updated_at;
        return $dto;
    }
}
