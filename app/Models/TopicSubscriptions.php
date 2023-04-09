<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicSubscriptions extends Model
{
    use HasFactory;
    protected $table = "topics_subscriptions";

    protected $fillable = [
        'user_id',
        'topic_id',
        'status',
    ];

    public function topic() {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}