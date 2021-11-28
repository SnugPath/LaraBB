<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasFactory;

    protected $table = "drafts";

    protected $fillable = [
        'user_id',
        'topic_id',
        'subject',
        'content'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topic() {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
