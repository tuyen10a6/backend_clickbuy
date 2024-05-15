<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategory(Request $request)
    {
        $per_page = $request->get('per_page', 10);

        $data = Category::query()->paginate($per_page);

        return response()->json([
            'status' => true,
            'response' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $imageName = null;

            if ($request->hasFile('image')) {
                $imageName = '/category/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('category'), $imageName);
            }

            Category::create([
                'CategoryName' => $request->get('CategoryName'),
                'CategoryImage' => $imageName ?? null,
                'Priority' => $request->get('Priority') ?? null
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = Category::query()->where('CategoryID', $request->get('CategoryID'))->first();

            if ($request->hasFile('image')) {
                $imageName = '/category/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('category'), $imageName);
            }

            $data->update([
                'CategoryName' => $request->get('CategoryName'),
                'CategoryImage' => $request->hasFile('image') ? $imageName : $data->CategoryImage,
                'Priority' => $request->has('Priority') ? $request->get('Priority') : $data->Priority
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Update dữ liệu thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function delete($id)
    {
        $data = Category::query()->where('CategoryID', $id)->first();

        if (!empty($data)) {
            $data->delete();
            return response()->json([
                'status' => 'true',
                'message' => `Xoá danh mục {$data->CategoryName}`
            ], 200);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => `Lỗi xoá danh mục`
            ], 401);
        }
    }

    public function getCategoryByID(Request $request)
    {
        $data = Category::query()->where('CategoryID', $request->get('id'))->first();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
