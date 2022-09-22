<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendProductLog extends BaseModel
{
    protected $table = 'send_product_logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_receive',
        'user_give',
        'order_id',
        'product_inventory_id',
    ];

}
