<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementsSettings extends Model
{
    use HasFactory;

    protected $table = 'advertisements_settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'user_id',
        'product_inventory_id',
        'time',
    ];
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function product_inventory()
    {
        return $this->belongsTo(ProductInventory::class);
    }
}


