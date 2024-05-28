<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\WareHouseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $customerPhone = ($data['customer'][0]['CustomerPhone']);

            $dataCustomer = Customer::query()->where('CustomerPhone', $customerPhone)->first();

            if (empty($dataCustomer)) {
                $customer = Customer::query()->create($data['customer'][0]);
            }

            $dataOrder = [
                "CustomerID" => empty($dataCustomer) ? $customer["id"] : $dataCustomer['CustomerID'],
                "OrderDate" => Now()->format('d/m/y'),
                "OrderStatusID" => Order::ORDER_CHUAXACNHAN
            ];

            $orderSave = Order::query()->create($dataOrder);

            $orderDetails = $request->get('details');

            foreach ($orderDetails as $detail) {
                $dataVariant = ProductVariant::query()->where('VARRIANTID', $detail['variant_id'])->first();

                $checkQuantityWareHouse = WareHouseDetails::query()
                    ->with('variant')
                    ->where("variant_id", $detail['variant_id'])
                    ->where("quantity", ">=", $detail['quantity'])->first();


                if (!empty($checkQuantityWareHouse)) {
                    $dataDetail = [
                        "order_id" => $orderSave['id'],
                        "variant_id" => $detail['variant_id'],
                        "quantity" => $detail['quantity'],
                        "price" => $detail["price"]
                    ];

                    OrderDetail::create($dataDetail);

                    $checkQuantityWareHouse->update([
                        'quantity' => $checkQuantityWareHouse['quantity'] - $detail['quantity']
                    ]);
                } else {
                    return response()->json([
                        "status" => false,
                        "message" => 'Số lượng sản phẩm ' . $dataVariant['VARRIANNAME'] . " đã hết số lượng"
                    ], 200);
                }
            }

            DB::commit();
            return response()->json([
                'status' => true,
                "message" => "Thêm giỏ hàng thành công"
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }
}
