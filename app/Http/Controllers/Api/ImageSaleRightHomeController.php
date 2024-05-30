<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImageSaleRightHome;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageSaleRightHomeController extends Controller
{
    public function getAll()
    {
        $data = ImageSaleRightHome::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image',
            ]);

            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = '/slide/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('slide'), $imageName);
            }

            ImageSaleRightHome::create([
                'Image' => $imageName,
                'ImageURL' => $request->get('ImageURL'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $data = ImageSaleRightHome::query()->where('ImageBannerID', $request->get('id'))->first();
        try {
            if ($data) {
                if ($request->hasFile('image')) {
                    $imageName = '/slide/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();
                    $request->file('image')->move(public_path('slide'), $imageName);
                }

                $data->update([
                    "Image" => $request->hasFile('image') ? $imageName : $data->Image,
                    "ImageURL" => $request->get('ImageURL')
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Update dữ liệu thành công',
                    "data" => $data
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false,
                'message' => $e->getMessage()], 400);
        }
    }

    public function getDetail(Request $request)
    {
        $key = $request->get('id');

        $data = ImageSaleRightHome::query()->where('ImageBannerID', $key)->first();

        if ($data) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }
    }


}
