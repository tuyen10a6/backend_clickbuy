<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getAll()
    {
        $data = Reviews::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getCommentByProduct($id)
    {
        $data = Reviews::query()->where('ProductID', $id)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function addComment(\Illuminate\Http\Client\Request $request)
    {
        $data = $request->all();

        try {
             Reviews::create($data);

             return response()->json([
                 'status' => true,
                 'data' => $data
             ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
