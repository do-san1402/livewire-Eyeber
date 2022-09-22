<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoiningForm extends Model {

    use HasFactory;

    protected $table = 'joining_forms';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}