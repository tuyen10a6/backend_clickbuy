<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WareHouse;
use Illuminate\Http\Request;

class WareHouseController extends Controller
{
    public function getAllWareHouse()
    {
        $data = WareHouse::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getWareHouseByID(Request $request)
    {
        $data = WareHouse::query()->where('id', $request->get('id'))->first();

        if (isset($data)) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }

    public function addWareHouse(Request $request)
    {
        try {
            $data = [
                "ten_kho" => $request->get('ten_kho'),
                "ten_kho2" => $request->get('ten_kho2'),
                "dia_chi" => $request->get('dia_chi'),
                "status" => $request->get('status')
            ];

            WareHouse::create($data);

            return response()->json([
                'status' => true,
                'message' => "Thêm kho hàng thành công"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function updateWareHouse(Request $request)
    {
        try {
            $wareHouse = WareHouse::query()->where('id', $request->get('id'))->first();

            $data = $request->all();

            if (!empty($wareHouse)) {
                $wareHouse->update($data);

                return response()->json([
                    'status' => true,
                    'message' => "Cập nhật lại dữ liệu thành công"
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function deleteWareHouse(Request $request)
    {
        try {
            $wareHouse = WareHouse::query()->where('id', $request->get('id'))->first();

            if (isset($wareHouse)) {
                $wareHouse->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Xoá dữ liệu kho hàng thành công'
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
