<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends BaseModel
{
    use HasFactory;
    protected $table = 'banners';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'date_end',
        'date_start',
        'image',
        'link',
        'status'
    ];

    public function getImageUrlAttribute()
    {
        if(!empty($this->attributes['image'])){
            if(strpos($this->attributes['image'], "http") === 0){
                return $this->attributes['image'];
            }else{
                return url('storage/images/banners/'.$this->attributes['image']);
            }
        }else{
            return null;
        }
    }

    public function getStatusNameAttribute()
    {
        if($this->attributes['status'] === config('apps.common.ads_status.show')){
            return trans('translation.show');
        }
        return trans('translation.hide');

    }
}
