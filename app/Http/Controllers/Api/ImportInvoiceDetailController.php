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
        $data = [
            'quantity' => $request->get('quantity'),
            'import_invoice_id' => $request->get('import_invoice_id'),
            "variant_id" => $request->get('variant_id'),
            "price" => $request->get('price'),
            "discount" => $request->get('discount'),
            "status" => $request->get('status')
        ];

        $importInvoice = ImportInvoice::query()->where('id', $request->get('import_invoice_id'))->first();

        try {
            ImportInvoiceDetails::create($data);

            if (!empty($importInvoice)) {

                $importInvoice->total_amount += ($data['quantity'] * $data['price']) - $data['discount'];
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
            ], 400);
        }
    }
}
