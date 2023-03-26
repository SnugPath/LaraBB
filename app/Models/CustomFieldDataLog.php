<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldDataLog extends Model
{
    use HasFactory;

    protected $table = 'custom_field_data_log';

    protected  $fillable = [
        'custom_field_id',
        'content',
        'updated_by'
    ];
}
