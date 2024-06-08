<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getAll()
    {
        $data = Reviews::query()->with(['product', 'customer'])->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getCommentByProduct(Request $request)
    {
        $key = $request->get('id');
        $data = Reviews::query()->with(['product', 'customer'])->where('ProductID', $key)->where('status', '=', 1)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function update(Request $request)
    {
        $key = $request->get('id');
        $review = Reviews::query()->where('ReviewID', $key)->first();

        $data = [
            'status' => $request->get('status')
        ];

        try {
            if ($review) {
                $review->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật dữ liệu thành công'
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'ID trên không tồn tại'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => ''
            ], 400);
        }
    }

    public function addComment(Request $request)
    {


        $customerPhone = $request->get('phone');

        $checkCustomer = Customer::query()->where('CustomerPhone', $customerPhone)->first();

//        dd($checkCustomer['CustomerID']);
        $data = [
            'ProductID' => $request->get('ProductID'),
            'Rating' => $request->get('Rating'),
            'Comment' => $request->get('Comment'),
            'CustomerID' => $checkCustomer['CustomerID'] ?? null
        ];

        try {
            if ($checkCustomer) {
                Reviews::create($data);

                return response()->json([
                    'status' => true,
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Khách hàng trên chưa mua sản phẩm này'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function searchByProductName(Request $request)
    {
        $productName = $request->get('name');

        $data = Reviews::query()
            ->whereHas('product', function ($query) use ($productName) {
                $query->where('ProductName', 'LIKE', '%' . $productName . '%');
            })
            ->with(['product', 'customer'])
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }


}
