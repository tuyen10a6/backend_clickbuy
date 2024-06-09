<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoice extends Model
{
    use HasFactory;

    protected $table = 'import_invoice';

    protected $guarded = [];

    CONST COMPLETE = 1;

//    protected  $primaryKey = false;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function importInvoiceDetails()
    {
        return $this->hasMany(ImportInvoiceDetails::class, 'import_invoice_id');
    }


}
