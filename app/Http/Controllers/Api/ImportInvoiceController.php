<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImportInvoice;
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

    public function update(Request $request)
    {
        try {
            $importInvoice = ImportInvoice::query()->where('id', $request->get('id'))->first();

            $data = $request->all();

            if (!empty($importInvoice)) {
                $importInvoice->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật dữ liệu thành công'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }
}

