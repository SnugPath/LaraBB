<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "groups";

    protected $fillable = [
        'name',
        'desc',
        'display',
        'img',
        'color'
    ];

    public function ranks() {
        return $this->hasMany(CustomFieldData::class, 'group_id');
    }
}
