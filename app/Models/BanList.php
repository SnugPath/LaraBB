<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "banlist";

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'reason'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

}
