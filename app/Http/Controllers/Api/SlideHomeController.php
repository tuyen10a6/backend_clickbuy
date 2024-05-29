<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlideHome;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nette\Schema\ValidationException;

class SlideHomeController extends Controller
{
    public function getAll()
    {
        $data = SlideHome::query()->limit('6')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'Image' => 'required|image',
            ]);

            $imageName = null;
            if ($request->hasFile('Image')) {
                $imageName = '/slide/' . Str::random(32) . "." . $request->file('Image')->getClientOriginalExtension();
                $request->file('Image')->move(public_path('slide'), $imageName);
            }

            SlideHome::create([
                'Image' => $imageName,
                'ImageURL' => $request->get('ImageURL'),
                'NameSlide' => $request->get('NameSlide'),
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
        $data = SlideHome::query()->where('SlileID', $request->get('id'))->first();

        try {
            if ($data) {
                if ($request->hasFile('Image')) {
                    $imageName = '/slide/' . Str::random(32) . "." . $request->file('Image')->getClientOriginalExtension();
                    $request->file('Image')->move(public_path('slide'), $imageName);
                }

                $data->update([
                    "Image" => $request->hasFile('Image') ? $imageName : $data->Image,
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

}
