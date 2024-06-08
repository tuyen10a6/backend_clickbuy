<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'Reviews';

    protected $guarded = [];

    protected $primaryKey = 'ReviewID';

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }
}
