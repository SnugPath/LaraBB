<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = "reports";

    protected $fillable = [
        'reason',
        'post_id',
        'topic_id',
        'author',
        'status'
    ];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function topic() {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function author() {
        return $this->belongsTo(User::class, 'author');
    }
}
