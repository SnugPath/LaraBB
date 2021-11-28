<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $table = "forums";

    protected $fillable = [
        'parent',
        'name',
        'desc',
        'img',
        'topics_per_page',
        'type',
        'status',
        'last_post',
        'last_author',
        'display_on_index',
        'display_indexed',
        'display_icons'
    ];

    public function parent_forum() {
        return $this->belongsTo(Forum::class, 'parent');
    }

    public function sub_forums() {
        return $this->hasMany(Forum::class, 'id');
    }

    public function topics() {
        return $this->hasMany(Topic::class, 'forum_id');
    }

    public function last_post() {
        return $this->belongsTo(Post::class, 'id');
    }

    public function last_author() {
        return $this->belongsTo(User::class, 'id');
    }

    public function subscribed_users() {
        return $this->belongsToMany(User::class, 'forums_subscriptions', 'forum_id', 'user_id');
    }
}
