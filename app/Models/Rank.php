<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "ranks";

    protected $fillable = [
        'group_id',
        'name',
    ];

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function users() {
        return $this->hasMany(User::class, 'rank_id');
    }
}
