<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumSubscriptions extends Model
{
    use HasFactory;
    protected $table = "forums_subscriptions";

    protected $fillable = [
        'user_id',
        'forum_id',
        'status',
    ];

    public function forum() {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
