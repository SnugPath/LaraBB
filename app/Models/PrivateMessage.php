<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    use HasFactory;
    protected $table = "private_messages";

    protected $fillable = [
        'author_id',
        'subject',
        'content',
        'edit_reason',
        'edit_count',
        'response_to',
        'to'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function sent_to() {
        return $this->belongsTo(User::class, 'to');
    }
}
