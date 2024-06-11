<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderHistoryMail;
use App\Mail\OrderSuccessMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\ProductVariant;
use App\Models\Reviews;
use App\Models\WareHouseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $customerPhone = ($data['customer'][0]['CustomerPhone']);

            $dataCustomer = Customer::query()->where('CustomerPhone', $customerPhone)->first();

            $customer = [];
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
                        "order_id" => $orderSave['OrderID'],
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
                        "message" => $dataVariant['VARRIANNAME'] . " đã hết hàng."
                    ], 200);
                }
            }

            Mail::to($dataCustomer->CustomerEmail ?? $customer['CustomerEmail'])->send(new OrderSuccessMail($orderSave));

            DB::commit();

            return response()->json([
                'status' => true,
                "message" => "Thêm đơn hàng thành công"
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function getAll()
    {
        $data = Order::query()->with(['orderDetail.productVariant', 'orderStatus', 'customer'])->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getDetail(Request $request)
    {
        $data = Order::query()->with(['orderDetail.productVariant', 'orderStatus', 'customer'])->where('OrderID', $request->get('id'))->first();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function update(Request $request)
    {
        try {
            $order = Order::query()->where('OrderID', $request->get('id'))->first();

            $data = [
                "OrderStatusID" => $request->get('status'),
                "note_address" => $request->get('note_address')
            ];

            if ($order) {
                $order->update($data);

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

    public function getOrderStatus()
    {
        $data = OrderStatus::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getOrderByStatus(Request $request)
    {
        $key = $request->get('id');

        if ($key == 'all') {
            $data = Order::query()
                ->with(['orderDetail.productVariant', 'orderStatus', 'customer'])
                ->get();
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            $data = Order::query()
                ->with(['orderDetail.productVariant', 'orderStatus', 'customer'])
                ->where('OrderStatusID', $key)
                ->get();
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }

    public function countOrder()
    {
        $data = count(Order::query()->get());

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function totalRevenue()
    {
        $orders = Order::query()->where('OrderStatusID', Order::ORDER_THANHCONG)->with('orderDetail')->get();
        $totalRevenue = 0;

        foreach ($orders as $order) {
            foreach ($order->orderDetail as $item) {
                $totalRevenue += $item->price * $item->quantity;
            }
        }

        return response()->json([
            'data' => $totalRevenue
        ], 200);
    }

    public function totalRevenueNowDate()
    {
        $today = Carbon::today();

        $orders = Order::query()
            ->where('OrderStatusID', Order::ORDER_THANHCONG)
            ->whereDate('updated_at', $today)
            ->with('orderDetail')
            ->get();

        $totalRevenue = 0;

        foreach ($orders as $order) {
            foreach ($order->orderDetail as $item) {
                $totalRevenue += $item->price * $item->quantity;
            }
        }

        return response()->json([
            'data' => $totalRevenue
        ], 200);
    }

    public function totalReview()
    {
        $data = count(Reviews::query()->get());

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getProductTopBuy()
    {
        $data = ProductVariant::has('orderDetail')
            ->whereHas('orderDetail', function ($query) {
                $query->where('quantity', '>', 0);
            })
            ->with(['orderDetail' => function ($query) {
                $query->where('quantity', '>', 0);
            }])
            ->withCount('orderDetail as total_quantity')
            ->get();

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function totalOrderStatus()
    {
        $data = OrderStatus::query()->with('getOrder')->get();

        foreach ($data as $item) {
            $item->total_count = count($item->getOrder);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);

    }

    public function searchOrderHistory(Request $request)
    {
        try {
            $keyOrder = $request->get('id');

            $email = $request->get('email');

            $data = Order::query()
                ->with(['orderDetail.productVariant', 'customer', 'orderStatus'])
                ->where('OrderID', $keyOrder)
                ->first();

            if (!empty($data)) {
                Mail::to($email)->send(new OrderHistoryMail($data));
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Đơn hàng trên không tồn tại'
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'Gửi email thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

}
