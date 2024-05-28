<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function getAllProduct(Request $request)
    {
        $per_page = $request->get('per_page', 10);

        $data = Product::query()->with(['categories', 'brands'])->paginate($per_page);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getProductByCategory(Request $request)
    {
        $per_page = $request->get('per_page', 20);

        $categoryID = $request->get('category_id');

        $data = Product::query()->where('CategoryID', $categoryID)->paginate($per_page);

        if (!empty($data)) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Errors'
            ], 401);
        }
    }

    public function store(Request $request)
    {
        try {
            $imageName = null;

            if ($request->hasFile('image')) {
                $imageName = '/product/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();

                $request->file('image')->move(public_path('product'), $imageName);
            }

            Product::create([
                "ProductName" => $request->get('ProductName'),
                "CategoryID" => $request->get('CategoryID'),
                "Description" => $request->get('Description'),
                "ImageURL" => $imageName,
                "DateCreated" => now()->format('Y-m-d'),
                "BrandID" => $request->get('BrandID'),
                "DetailProduct" => $request->get('DetailProduct')
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $data = Product::query()->where('ProductID', $request->get('id'))->first();
        $imageURL = null;

        try {
            if ($request->hasFile('image')) {
                $imageName = '/product/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();

                $request->file('image')->move(public_path('product'), $imageName);
            }

            $data->update([
                "ProductName" => $request->has('ProductName') ? $request->get('ProductName') : $data->ProductName,
                "CategoryID" => $request->has('CategoryID') ? $request->get('CategoryID') : $data->CategoryID,
                "Description" => $request->has('Description') ? $request->get('Description') : $data->Description,
                "ImageURL" => $request->hasFile('image') ? $imageName : $data->ImageURL,
                "BrandID" => $request->has('BrandID') ? $request->get('BrandID') : $data->BrandID,
                "DetailProduct" => $request->has('DetailProduct') ? $request->get('DetailProduct') : $data->DetailProduct,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Update dữ liệu thành công',
                "data" => $data
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
        $data = Product::query()->where('ProductID', $request->get('id'))->first();

        if (isset($data)) {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => "Xoá dữ liệu thành công"
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'ID trên không tồn tại'
            ], 404);
        }
    }

    public function getProductByID(Request $request)
    {
        $data = Product::query()->where('ProductID', $request->get('id'))->first();

        if (!empty($data)) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'ID trên không tồn tại'
            ], 404);
        }
    }
}
