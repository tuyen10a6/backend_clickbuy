<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoiceDetails extends Model
{
    use HasFactory;

    protected $table = 'import_invoice_details';

    protected $guarded = [];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
