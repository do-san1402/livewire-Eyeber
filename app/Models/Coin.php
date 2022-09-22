<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends BaseModel {

    use HasFactory;

    protected $table = 'coins';

    protected $fillable = [
        'symbol_name',
        'image',
        'name',
        'admin_wallet_id'
    ];

    public function user_wallet()
    {
        return $this->belongsTo(UserWallet::class);
    }

    public function admin_wallet()
    {
        return $this->belongsTo(AdminWallet::class);
    }

    public function getImageUrlAttribute()
    {
        if(!empty($this->attributes['image'])){
            if(strpos($this->attributes['image'], "http") === 0){
                return $this->attributes['image'];
            }else{
                return url('storage/images/coins/'.$this->attributes['image']);
            }
        }else{
            return null;
        }
    }

    public function coinLogs()
    {
        return $this->hasMany(Coin::class);
    }
}