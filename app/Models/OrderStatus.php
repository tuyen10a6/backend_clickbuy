<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'OrderStatus';

    protected $primaryKey ='OrderStatusID';

    protected $guarded = [];

    public function getOrder()
    {
        return $this->hasMany(Order::class, 'OrderStatusID');
    }
}
