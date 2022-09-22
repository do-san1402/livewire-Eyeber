<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nation extends Model {

    use HasFactory;

    protected $table = 'nations';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}