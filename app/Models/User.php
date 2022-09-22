<?php

namespace App\Models;

use App\Services\Wallets\WalletService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nick_name',
        'full_name',
        'nation_id',
        'age',
        'birthday',
        'status_user_id',
        'joining_form_id',
        'email',
        'password',
        'avatar',
        'location_detail',
        'number_phone',
        'role_type',
        'rank_id',
        'date_of_joining',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function joining_form()
    {
        return $this->belongsTo(JoiningForm::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function product_inventory()
    {
        return $this->hasMany(ProductInventory::class);
    }
    
    /**
     * Check user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_type === config('apps.common.role_type.admin');
    }

    
    public function user_wallet()
    {
        return $this->hasMany(UserWallet::class)->where('role_type', config('apps.common.role_type.customer'));
    }

    public function admin_wallet()
    {
        return $this->hasMany(AdminWallet::class)->where('role_type', config('apps.common.role_type.admin'));
    }

    public function advertisements_setting()
    {
        return $this->hasOne(AdvertisementsSettings::class);
    }
    
    public static function boot() {

        parent::boot();

        static::created(function($model) {
            $coins = Coin::all();
            if($model->role_type  === config('apps.common.role_type.customer')){
                foreach($coins as $coin ){
                    $user_wallet = new UserWallet();
                    $user_wallet->amount   = 0;
                    $user_wallet->address  = WalletService::generateAddress();
                    $user_wallet->status   = config('apps.common.status_wallet.activate');
                    $user_wallet->user_id  = $model->id;
                    $user_wallet->coin_id  = $coin->id;
                    $user_wallet->save();
                }
            }
        });
    }
    
    public function coinLogs()
    {
        return $this->hasMany(CoinLog::class);
    }
    
    public function watchAdvertisements()
    {
        return $this->hasMany(WatchAdvertisementsLog::class);
    }

    public function getAvatarUrlAttribute()
    {
        if(!empty($this->attributes['avatar'])){
            if(strpos($this->attributes['avatar'], "http") === 0){
                return $this->attributes['avatar'];
            }else{
                return url('storage/images/avatars/'.$this->attributes['avatar']);
            }
        }else{
            return null;
        }
    }

    public function getPolygonAddressAttribute()
    {
        $wallet_history = WalletAddressHistory::where('user_id', $this->attributes['id'])->latest()->first();
        $address = '';
        if($wallet_history){
            $address = $wallet_history->address;
        }
        return $address;
        
    }
}
