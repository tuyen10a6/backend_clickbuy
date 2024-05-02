<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Product';

    protected $primaryKey = 'ProductID';

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

    public function variant()
    {
        return $this->hasMany(ProductVariant::class, 'ProductID');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'BrandID');
    }


}
