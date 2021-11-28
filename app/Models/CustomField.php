<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "custom_field";

    protected $fillable = [
        'type',
        'default',
        'required',
        'active'
    ];

    public function custom_field_data() {
        return $this->hasMany(CustomFieldData::class, 'cf_id');
    }
}
