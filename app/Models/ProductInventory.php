<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends BaseModel {

    use HasFactory;

    protected $table = 'product_inventory';

    protected $fillable = [
        'product_id',
        'user_id',
        'durability',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function setting_advertisement()
    {
        return $this->hasOne(AdvertisementsSettings::class);

    }
    public function getProductInventoryNameAttribute()
    {
        $glass_category = config('apps.common.glass_category');
        foreach($glass_category as $key => $glass){
            if($this->attributes['glass_type'] === $glass){
                return '['.trans('translation.'.$key).']'. $this->product->name;
            }
        }
    }

    public function watch_advertisements_log()
    {
       return $this->hasMany(WatchAdvertisementsLog::class);
    }

    public function getViewsAttribute()
    {
      return $this->watch_advertisements_log->count();
    }
}