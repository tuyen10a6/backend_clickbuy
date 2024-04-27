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

    public function addBrand(Request $request)
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
                'message' => $e->getMessage()], 401);
        }
    }

    public function updateBrand(Request $request)
    {
        try {
            $data = Brand::query()->where('BrandID', $request->get('BrandID'))->first();

            $data->update([
                'BrandName' => $request->get('BrandName'),
                'Country' => $request->get('Country'),
                'Website' => $request->get('Website') ?? null,
                'ContactPerson' => $request->get('ContactPerson') ?? null,
                'ContactPhone' => $request->get('ContactPhone') ?? null,
                'CategoryID' => $request->get('CategoryID') ?? null
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
            ]);
        }

    }

    public function deleteBrand(Request $request)
    {
        $data = Brand::query()->where('BrandID', $request->get('id'))->first();

        if (!empty($data)) {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xoá dữ liệu thành công'
            ]);
        } else {
            return response([
                'status' => false,
                'message' => 'Xoá lỗi, ID trên không tồn tại'
            ]);
        }
    }
}
