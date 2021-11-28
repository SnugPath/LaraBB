<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $table = "topics";

    protected $fillable = [
        'forum_id',
        'approved',
        'reported',
        'title',
        'views',
        'status',
        'type',
    ];

    public function forum() {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'topic_id');
    }

    public function drafts() {
        return $this->hasMany(Draft::class, 'topic_id');
    }

    public function reports() {
        return $this->hasMany(Report::class, 'topic_id');
    }

    public function subscribed_users() {
        return $this->belongsToMany(User::class, 'topics_subscriptions', 'topic_id', 'user_id');
    }
}
