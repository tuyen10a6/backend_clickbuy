<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = '/uploads/' . Str::random(32) . "." . $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(public_path('uploads'), $imageName);
            return response()->json(['url' => $imageName], 200);
        }
    }
}
