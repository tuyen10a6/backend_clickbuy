<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouseDetails extends Model
{
    use HasFactory;

    protected $table = 'warehouse_details';

    protected $guarded = [];

    public function wareHouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
