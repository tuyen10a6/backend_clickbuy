<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImportInvoice;
use App\Models\ImportInvoiceDetails;
use Illuminate\Http\Request;

class ImportInvoiceController extends Controller
{
    public function getAllImportInvoice()
    {
        $data = ImportInvoice::query()->with('supplier')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            ImportInvoice::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 401);
        }
    }

    public function getImportInvoiceDetails(Request $request)
    {
        $data = ImportInvoiceDetails::query()->with('productVariant')->where('import_invoice_id', $request->get('id'))->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function update(Request $request)
    {

        try {
            $key  = $request->get('id');
            $importInvoice = ImportInvoice::query()->where('id', $key)->first();


            if (!empty($importInvoice)) {
                $importInvoiceDetail = ImportInvoiceDetails::query()->where('import_invoice_id', $key)->get();

                foreach ($importInvoiceDetail as $item)
                {
                    $item->update([
                        'status' => 1
                    ]);
                }
                $importInvoice->update([
                    'status' => ImportInvoice::COMPLETE
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật dữ liệu thành công'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}

