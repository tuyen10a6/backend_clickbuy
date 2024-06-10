<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventMarketing;
use Illuminate\Http\Request;

class EventMarketingController extends Controller
{
    public function getEventMarketing()
    {
        $data = EventMarketing::query()->with('eventMarketingDetail')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = [
            "id" => $request->get('id'),
            "name" => $request->get('name'),
            "status" => $request->get('status'),
            "purpose" => $request->get('purpose'),
            "campaign_type" => $request->get('campaign_type'),
            "date_end" => $request->get('date_end'),
            "expected_revenue" => $request->get('expected_revenue')
        ];

        try {
            EventMarketing::query()->create($data);

            return response()->json([
                'status' => true,
                'message' => 'Thêm dữ liệu thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request)
    {

        $key = $request->get('id');

        $eventMarking = EventMarketing::query()->where('id', $key)->first();

        $data = [
            "name" => $request->get('name'),
            "status" => $request->get('status'),
            "purpose" => $request->get('purpose'),
            "campaign_type" => $request->get('campaign_type'),
            "date_end" => $request->get('date_end'),
            "expected_revenue" => $request->get('expected_revenue')
        ];


        try {
            if ($eventMarking) {
                EventMarketing::query()->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật dữ liệu thành công'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Giá trị trên không tồn tại'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage()
            ], 200);
        }
    }
}
