<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnhancementSetting extends Model
{
    use HasFactory;
    protected $table = 'enhancement_settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'product_id',
        'bst',
        'durability',
        'mining',
        'reinforced_division'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
