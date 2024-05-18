<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WareHouseDetails;
use Illuminate\Http\Request;

class WareHouseDetailsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $variant = $request->get('variant_id');
            $wareHouse = $request->get('warehouse_id');

            $wareHouseDetails = WareHouseDetails::query()->where('variant_id', $variant)->where('warehouse_id', $wareHouse)->first();

            if (empty($wareHouseDetails)) {
                WareHouseDetails::create($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Thêm dữ liệu thành công'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Biến thể trên đã tồn tại trong kho'
                ], 401);
            }


        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function getAllWareHouse()
    {
        $data = WareHouseDetails::query()->with(['wareHouse', 'variant'])->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getAllWareHouseDetailsByID(Request $request)
    {
        if(!($request->get('id') === 'all'))
        $wareHouse = WareHouseDetails::query()->with(['wareHouse', 'variant'])->where('warehouse_id', $request->get('id'))->get();
        else
        {
            $wareHouse = WareHouseDetails::query()->with(['wareHouse', 'variant'])->get();
        }

        if (!empty($wareHouse)) {
            return response()->json([
                'status' => true,
                'data' => $wareHouse
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Chưa có dữ liệu !!!'
            ], 401);
        }
    }
}
