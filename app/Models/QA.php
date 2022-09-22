<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QA extends BaseModel
{
    protected $table = 'qas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'registration_date',
        'description',
        'status',
    ];

    public function getStatusNameAttribute()
    {
        $list_status = config('apps.common.ads_status');
        foreach($list_status as $key => $status){
            if((int)$status === (int)$this->attributes['status'] ){
                return trans('translation.'.$key);
            }
        }
    }
}
