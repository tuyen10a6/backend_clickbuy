<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMarketingDetail extends Model
{
    use HasFactory;

    protected $table = 'event_marketing_details';

    protected $guarded = [];

    public function eventMarketing()
    {
        return $this->belongsTo(EventMarketing::class, 'event_marketing_id');
    }


}
