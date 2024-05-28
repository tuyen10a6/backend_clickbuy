<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'Orders';


    protected  $guarded = [];


    CONST ORDER_CHUAXACNHAN = 1;

}
