<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchAdvertisementsLog extends Model
{
    use HasFactory;
    protected $table = 'watch_advertisements_log';
    
    protected $fillable = [
        'product_inventory_id',
        'user_id',
        'advertisement_id',
        'view',
        'time',
        'cumulative_mining',
        'rewards',
    ];

    public function product_inventory()
    {
        return $this->belongsTo(ProductInventory::class);
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
