<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldData extends Model
{
    use HasFactory;
    protected $table = "custom_field_data";

    protected $fillable = [
        'user_id',
        'cf_id',
        'content'
    ];

    public function custom_field() {
        return $this->belongsTo(CustomField::class, 'cf_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
