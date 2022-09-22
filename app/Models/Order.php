<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'product_purchase_date',
        'user_id',
        'category_id',
        'product_id',
        'status_id',
        'method_of_payment',
        'amount_of_payment',
        'cancellation_processing',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function order_details()
    {
        return $this->hasOne(OrderDetail::class);
    }
}