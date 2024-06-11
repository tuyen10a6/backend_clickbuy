<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function PHPUnit\Framework\status;
use function Termwind\ValueObjects\p;

class ProductController extends Controller
{
    public function getAllProduct(Request $request)
    {
        $per_page = $request->get('per_page', 100);

        $data = Product::query()->with(['categories', 'brands', 'productPrice'])->paginate($per_page);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function getProductByCategory(Request $request)
    {
        $per_page = $request->get('per_page', 20);

        $categoryID = $request->get('id');

        $data = Product::query()->where('CategoryID', $categoryID)->with('productPrice')->paginate($per_page);

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

            $product = Product::create([
                "ProductName" => $request->get('ProductName'),
                "CategoryID" => $request->get('CategoryID'),
                "Description" => $request->get('Description'),
                "ImageURL" => $imageName,
                "DateCreated" => now()->format('Y-m-d'),
                "BrandID" => $request->get('BrandID'),
                "DetailProduct" => $request->get('DetailProduct'),
                "he_dieu_hanh" => $request->get('he_dieu_hanh') ?? null,
                "bo_nho_trong" => $request->get('bo_nho_trong') ?? null,
                "ram" => $request->get('ram') ?? null,
                "camera_chinh" => $request->get('camera_chinh') ?? null,
                "man_hinh" => $request->get('man_hinh') ?? null,
                "kich_thuoc" => $request->get('kich_thuoc') ?? null,
                "trong_luong" => $request->get('trong_luong') ?? null,
                "do_phan_giai" => $request->get('do_phan_giai') ?? null,
                "camera_phu" => $request->get('camera_phu') ?? null,
                "mau_sac" => $request->get('mau_sac') ?? null,
                "dung_luong_pin" => $request->get('dung_luong_pin')
            ]);

            ProductPrice::create([
                "product_id" => $product["ProductID"],
                "price" => $request->get("price"),
                "price_discount" => $request->get("price_discount")
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
            ], 400);
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
        $data = Product::query()->with('reviews')->where('ProductID', $request->get('id'))->first();

        $totalStars = 0;
        $totalReviews = $data->reviews->count();

        foreach ($data->reviews as $review) {
            $totalStars += $review->Rating;
        }

        $averageRating = $totalReviews > 0 ? $totalStars / $totalReviews : 0;

        $data->averageRating = $averageRating;
        $data->totalReviews = $totalReviews;


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

    public function getProductSale()
    {
        $products = Product::with(['productPrice', 'reviews'])->limit(10)->orderBy('created_at', 'desc')->get();

        foreach ($products as $product) {
            $totalStars = 0;
            $totalReviews = $product->reviews->count();

            foreach ($product->reviews as $review) {
                $totalStars += $review->Rating;
            }

            $averageRating = $totalReviews > 0 ? $totalStars / $totalReviews : 0;

            $product->averageRating = $averageRating;
            $product->totalReviews = $totalReviews;
        }

        return response()->json([
            'status' => true,
            'data' => $products
        ], 200);
    }

    public function searchProduct(Request $request)
    {
        $data = Product::query()->where('ProductName', 'like', '%' . $request->get('key') . '%')->with(['categories', 'brands', 'productPrice'])->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);

    }

    public function searchProductByCategories(Request $request)
    {
        $keyQuery = $request->get('key');

        $keyID = $request->get('id');

        $data = Product::query()
            ->where('CategoryID', $keyID)
            ->with('productPrice')
            ->join('product_price', 'Product.ProductID', '=', 'product_price.product_id')
            ->orderBy('product_price.price_discount', $keyQuery)
            ->select('Product.*')->get();

        return response()->json([
            "status" => true,
            'data' => $data
        ], 200);
    }

    public function searchPrice(Request $request)
    {
        $key = $request->get('id');

        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        $data = Product::query()->with('productPrice')
            ->where('CategoryID', $key)
            ->join('product_price as pp', 'Product.ProductID', '=', 'pp.product_id')
            ->where(function ($query) use ($minPrice, $maxPrice) {
                if ($minPrice !== null) {
                    $query->where('pp.price_discount', '>=', $minPrice);
                }
                if ($maxPrice !== null) {
                    $query->where('pp.price_discount', '<=', $maxPrice);
                }
            })
            ->select('Product.*')
            ->get();

        return response()->json([
            "status" => true,
            'data' => $data
        ], 200);
    }

}
