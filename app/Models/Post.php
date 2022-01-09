<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";

    protected $fillable = [
        'topic_id',
        'author',
        'author_ip',
        'approved',
        'reported',
        'content',
        'edit_reason',
        'edit_count',
        'edit_user',
    ];

    public function author() {
        return $this->hasOne(User::class, 'author');
    }

    public function edit_user() {
        return $this->hasOne(User::class, 'edit_user');
    }

    public function topic() {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function reports() {
        return $this->hasMany(Report::class, 'post_id');
    }
}
