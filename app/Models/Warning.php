<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;
    protected $table = "warnings";

    protected $fillable = [
        'user_id',
        'warned_by',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function warned_by() {
        return $this->belongsTo(User::class, 'warned_by');
    }
}
