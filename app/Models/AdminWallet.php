<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model {

    use HasFactory;

    protected $table = 'admin_wallets';

    protected $fillable = [
        'address', 
        'amount', 
        'admin_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coin()
    {
        return $this->hasOne(Coin::class);
    }
}