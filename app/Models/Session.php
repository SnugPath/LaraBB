<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "sessions";

    protected $fillable = [
        'user_id',
        'start',
    ];

    protected $casts = [
        'start' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
