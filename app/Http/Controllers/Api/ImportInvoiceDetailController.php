<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImportInvoice;
use App\Models\ImportInvoiceDetails;
use App\Models\WareHouse;
use App\Models\WareHouseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\HttpFoundation\Session\Storage\Handler\beginTransaction;
use function Symfony\Component\HttpFoundation\Session\Storage\Handler\commit;
use function Symfony\Component\HttpFoundation\Session\Storage\Handler\rollback;

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
            "status" => $request->get('status'),
            "warehouse_id" => $request->get('warehouse_id')];

        $importInvoice = ImportInvoice::query()->where('id', $request->get('import_invoice_id'))->first();

        $wareHouseDetail = WareHouseDetails::query()->where('warehouse_id', $request->get('warehouse_id'))->where('variant_id', $request->get('variant_id'))->first();

        try {
            DB::beginTransaction();

            ImportInvoiceDetails::create($data);

            if (!empty($wareHouseDetail)) {
                $quantityWareHouseDetail = $wareHouseDetail->quantity;

                $wareHouseDetail->update([
                    "quantity" => $quantityWareHouseDetail + $data['quantity']
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Kho ' . $request->get('warehouse_id')  . ' không có sản phẩm này'
                ], 422);
            }

            if (!empty($importInvoice)) {

                $importInvoice->total_amount += ($data['quantity'] * $data['price']) - $data['discount'];
                $importInvoice->update([
                    "total_amount" => $importInvoice->total_amount
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu chi tiết hoá đơn nhập thành công'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
