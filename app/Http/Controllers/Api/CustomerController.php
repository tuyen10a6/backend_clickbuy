<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getAll()
    {
        $data = Customer::query()->with('order')->get();

        foreach ($data as $customer) {

            $countOrder = $customer->order->count();

            $customer->count_order = $countOrder;
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function searchProduct(Request $request)
    {
        $key = '%' . $request->get('key') . '%';

        $data = Customer::query()->with('order')->where('CustomerName', 'like', $key)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
