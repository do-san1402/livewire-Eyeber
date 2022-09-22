<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletAddressHistory extends Model
{
    use HasFactory;
    protected $table = 'wallet_address_historys';
    
    protected $fillable = [
        'user_id',
        'address',
        'private_key',
        'coin_bmt',
        'coin_bst',
        'coin_matic'
    ];
    
}