<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinLog extends BaseModel {

    use HasFactory;

    protected $table = 'coin_logs';

    protected $fillable = [
        'status_classification_coin',
        'date_start',
        'user_id',
        'coin_id',
        'status_log_coin',
        'date_end'
    ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function coin()
   {
     return   $this->belongsTo(Coin::class);
   }

   public function getStatusDepositOrWithdrawalAttribute()
   {
        $status_classification = config('app.common.status_classification_coin.deposit');
        if($this->attributes['status_classification_coin'] === $status_classification){
            return trans('translation.deposit');
        }
        return trans('translation.withdrawal');
   }


   public function getStatusLogCoinNameAttribute()
   {
        $status_log_coin = config('apps.common.status_log_coin');
        foreach($status_log_coin as $key => $status){
            if($status ===  $this->attributes['status_log_coin']){
                return trans('translation.'.$key);
            }
        }
   }

   public function getUserNameAttribute()
    {
        if($this->user) {
            return $this->user->nick_name;
        }
        return '';
    }
}