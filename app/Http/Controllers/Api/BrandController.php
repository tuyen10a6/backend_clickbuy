<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use http\Env\Response;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function getAllBrand(Request $request)
    {
        $per_page = $request->get('per_page', 10);

        $data = Brand::query()->paginate($per_page);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'BrandName' => 'required|unique:Brand|max:255',
            'Country' => 'required',
        ]);

        try {
            $data = $request->all();

            Brand::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = Brand::query()->where('BrandID', $request->get('id'))->first();

            $data->update([
                'BrandName' => $request->get('BrandName') ? $request->get('BrandName') : $data->BrandName,
                'Country' => $request->get('Country') ? $request->get('Country') : $data->Country,
                'Website' => $request->get('Website') ? $request->get('Website') : $data->Website,
                'ContactPhone' => $request->get('ContactPhone') ? $request->get('ContactPhone') : $data->ContactPhone,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Sửa dữ liệu thành công',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        }

    }

    public function delete(Request $request)
    {
        $data = Brand::query()->where('BrandID', $request->get('id'))->first();

        if (!empty($data)) {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xoá dữ liệu thành công'
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Xoá lỗi, ID trên không tồn tại'
            ], 404);
        }
    }

    public function getBrandByID(Request $request)
    {
        $data = Brand::query()->where('BrandID', $request->get('id'))->first();

        if (!empty($data)) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Brand trên không tồn tại, vui lòng xem lại'
            ], 404);
        }
    }
}
