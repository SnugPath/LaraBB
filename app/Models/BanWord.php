<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanWord extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "banword";

    protected $fillable = [
        'word'
    ];
}
