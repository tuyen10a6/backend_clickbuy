<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function getAllSupplier()
    {
        $data = Supplier::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            Supplier::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $supplierID = $request->get('id');

        $supplier = Supplier::query()->where('id', $supplierID)->first();

        try {
            if (!empty($supplier)) {
                $supplier->update($data);

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

    public function getSupplierByID(Request $request)
    {
        $supplier = Supplier::query()->where('id', $request->get('id'))->first();

        return response()->json([
            'status' => true,
            'data' => $supplier
        ], 200);
    }

}
