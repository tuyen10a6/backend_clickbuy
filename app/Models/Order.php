<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'Orders';

    protected $guarded = [];

    protected $primaryKey = 'OrderID';

    CONST ORDER_CHUAXACNHAN = 1;

    CONST ORDER_THANHCONG = 8;

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'OrderStatusID');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }


}
