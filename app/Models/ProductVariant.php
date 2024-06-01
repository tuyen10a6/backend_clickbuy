<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'ProductVariant';

    protected $primaryKey = 'VARRIANTID';

    protected $guarded = [];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'variant_id');
    }
}
