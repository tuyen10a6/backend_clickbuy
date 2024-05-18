<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function getVariantByProduct(Request $request)
    {
        $data = ProductVariant::query()->where('ProductID', $request->get('id'))->get();

        if (isset($data)) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => "Dữ liệu trên không tồn tại"
            ], 404);
        }
    }

    public function getVariantByID(Request $request)
    {
        $data = ProductVariant::query()->where('VARRIANTID', $request->get('id'))->first();

        if (!empty($data)) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => "Dữ liệu trên không tồn tại"
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $imageVariant = null;

        try {
            if ($request->hasFile('image')) {
                $imageVariant = '/variant/' . \Illuminate\Support\Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();

                $request->file('image')->move(public_path('variant'), $imageVariant);
            }

            ProductVariant::create([
                "VARRIANNAME" => $request->get("VARRIANNAME"),
                "ProductID" => $request->get('ProductID'),
                "COLOR" => $request->get('COLOR'),
                "Capacity" => $request->get('Capacity'),
                "PRICE" => $request->get('PRICE'),
                "ImageVariant" => $request->hasFile('image') ? $imageVariant : null,
                "ProductVariantSL" => $request->get("ProductVariantSL")
            ]);

            return response()->json([
                'status' => true,
                'message' => "Thêm biến thể thành công"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $data = ProductVariant::query()->where('VARRIANTID', $request->get('id'))->first();

        if (isset($data)) {
            try {
                if ($request->hasFile('image')) {
                    $imageVariant = '/variant/' . \Illuminate\Support\Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();

                    $request->file('image')->move(public_path('variant'), $imageVariant);
                }

                $data->update([
                    "VARRIANNAME" => $request->has("VARRIANNAME") ? $request->get("VARRIANNAME") : $data->VARRIANNAME,
                    "ProductID" => $request->has('ProductID') ? $request->get('ProductID') : $data->ProductID,
                    "COLOR" => $request->has('COLOR') ? $request->get('COLOR') : $data->COLOR,
                    "Capacity" => $request->has('Capacity') ? $request->get('Capacity') : $data->Capacity,
                    "PRICE" => $request->has('PRICE') ? $request->get('PRICE') : $data->PRICE,
                    "ImageVariant" => $request->hasFile('image') ? $imageVariant : $data->ImageVariant,
                    "ProductVariantSL" => $request->has("ProductVariantSL") ? $request->get('ProductVariantSL') : $data->ProductVariantSL
                ]);

                return response()->json([
                    'status' => true,
                    'message' => "Sửa dữ liệu thành công"
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => true,
                    'message' => $e->getMessage()
                ], 404);
            }
        } else {
            return response()->json([
                'status' => false,
                "message" => 'Dữ liệu trên không tồn tại'
            ], 404);
        }
    }

    public function delete(Request $request)
    {
        $data = ProductVariant::query()->where('VARRIANTID', $request->get('id'))->first();

        if (isset($data)) {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xoá dữ liệu thành công'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                "message" => 'ID trên không tồn tại'
            ], 404);
        }
    }

    public function getAllVariant()
    {
        $data = ProductVariant::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
