<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlideHome;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            $imageName = null;

            if ($request->hasFile('image')) {
                $imageName = '/slide/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();

                $request->file('image')->move(public_path('slide'), $imageName);
            }

            SlideHome::create([
                'Image' => $imageName,
                "ImageURL" => $request->get('ImageURL'),
                "NameSlide" => $request->get('NameSlide')
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

}
