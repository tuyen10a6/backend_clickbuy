<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventMarketingDetail;
use Illuminate\Http\Request;
use function PHPUnit\Framework\status;

class EventMarketingDetailController extends Controller
{
    public function getEventMarketingDetail()
    {
        $data = EventMarketingDetail::query()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = [
            "name" => $request->get('name'),
            "nguoi_phu_trach" => $request->get('nguoi_phu_trach'),
            "address_event" => $request->get('address_event'),
            "date_start" => $request->get("date_start"),
            "date_end" => $request->get('date_end'),
            "status" => $request->get('status'),
            "event_marketing_id" => $request->get('event_marketing_id')
        ];

        try {
            EventMarketingDetail::query()->create($data);

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

        $eventMarketingDetail = EventMarketingDetail::query()->where('id', $key)->first();

        $data = [
            "name" => $request->get('name'),
            "nguoi_phu_trach" => $request->get('nguoi_phu_trach'),
            "address_event" => $request->get('address_event'),
            "date_start" => $request->get('date_start'),
            "date_end" => $request->get('date_end'),
            "status" => $request->get('status'),
            "event_marketing_id" => $request->get('event_marketing_id')
        ];

        try {
            if ($eventMarketingDetail) {
                $eventMarketingDetail->update($data);

                return response()->json([
                    'status' => true,
                    'message' => "Cập nhật dữ liệu thành công"
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Giá trị trên không tồn tại'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
