<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImportInvoice;
use App\Models\ImportInvoiceDetails;
use Illuminate\Http\Request;

class ImportInvoiceDetailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $quantity = $request->get('quantity');

        $price = $request->get('price');

        $discount = $request->get('discount');

        $importInvoice = ImportInvoice::query()->where('id', $request->get('import_invoice_id'))->first();

        try {
            ImportInvoiceDetails::create($data);

            if (!empty($importInvoice)) {

                $importInvoice->total_amount += ($quantity * $price) - $discount;
                $importInvoice->update([
                    "total_amount" => $importInvoice->total_amount
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu chi tiết hoá đơn nhập thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
