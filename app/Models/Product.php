<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel {

    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price_MATIC',
        'price_KRW',
        'price_USD',
        'level',
        'mining',
        'sale_status_id',
        'product_upgrade',
        'image'
        
    ];

    
    public function product_inventory()
    {
        return $this->hasMany(ProductInventory::class);
    }

    public function getImageUrlAttribute()
    {
        if(!empty($this->attributes['image'])){
            if(strpos($this->attributes['image'], "http") === 0){
                return $this->attributes['image'];
            }else{
                return url('storage/images/products/'.$this->attributes['image']);
            }
        }else{
            return null;
        }
    }

    public function product_upgrades()
    {
        return $this->hasMany(ProductUpgrade::class)->orderBy('level','asc');
    }

    public function order_detail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function enhancement_settings()
    {
        return $this->hasMany(EnhancementSetting::class)->orderBy('reinforced_division','asc');
    }

    public function getNameGlassAttribute()
    {
        $glass_category = config('apps.common.glass_category');
        foreach($glass_category as $key => $glass){
            if($this->attributes['glass_type'] === $glass){
                return '['.trans('translation.'.$key).']'. $this->attributes['name'];
            }
        }
    }
}