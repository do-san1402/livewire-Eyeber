<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends BaseModel {

    use HasFactory;

    protected $table = 'user_wallets';

    protected $fillable = [
        'amount',
        'address',
        'status',
        'user_id',
        'coin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function getCoinNameAttribute()
    {
        return $this->coin->name;
    }

    public function getStatusNameAttribute()
    {
        if($this->status === config('apps.common.status_wallet.activate')){
            return trans('translation.activate');
        }else{
            return trans('translation.not_activate');
        }
      
    }

    public function getCoinImageAttribute()
    {
        return $this->coin->image_url;
    }

    public function getCoinSymbolNameAttribute()
    {
        return $this->coin->symbol_name;
    }

    public function getPolygonAddressAttribute()
    {
        $wallet_history = WalletAddressHistory::where('user_id', $this->attributes['user_id'])->latest()->first();
        $address = '';
        if($wallet_history){
            $address = $wallet_history->address;
        }
        return $address;
        
    }
}