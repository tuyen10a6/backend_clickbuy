<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProduct(Request $request)
    {
        $per_page = $request->get('per_page', 10);

        $data = Product::query()->paginate($per_page);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getProductByCategory(Request $request)
    {
        $per_page = $request->get('per_page', 10);

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

    public function addProduct(Request $request)
    {

    }

}
