<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMarketing extends Model
{
    use HasFactory;

    protected $table = 'event_marketing';

    protected $guarded = [];

    public function eventMarketingDetail()
    {
        return $this->hasMany(EventMarketingDetail::class, 'event_marketing_id');
    }
}
