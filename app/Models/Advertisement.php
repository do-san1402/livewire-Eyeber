<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends BaseModel
{
    protected $table = 'advertisements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'date',
        'date_end',
        'date_start',
        'views',
        'mining_settings',
        'rewards',
        'ad_status_id',
        'set_collection_deduction',
        'nation_id',
    ];

    
    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function getNationIdAttribute()
    {
        return json_decode($this->attributes['nation_id']);
    }
   
    public function getVideoUrlAttribute()
    {
        if(!empty($this->attributes['video'])){
            if(strpos($this->attributes['video'], "http") === 0){
                return $this->attributes['video'];
            }else{
                return url('storage/video/advertisements/'.$this->attributes['video']);
            }
        }else{
            return null;
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
