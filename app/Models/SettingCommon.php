<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCommon extends Model {

    use HasFactory;

    protected $table = 'setting_commons';

    protected $fillable = [
        'key',
        'value'
    ];
}