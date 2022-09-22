<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends BaseModel
{
    protected $table = 'notices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'registration_date',
        'views',
        'ad_status_id',
        'content',
    ];

    public function getStatusAttribute()
    {
        $list_status = config('apps.common.ads_status');
        foreach($list_status as $key => $status){
            if((int)$status === (int)$this->attributes['ad_status_id'] ){
                return trans('translation.'.$key);
            }
        }
    }
}
