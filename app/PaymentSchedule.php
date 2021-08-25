<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    //
    protected $fillable = [
        "application_id",
        "due_date",
        "paid_date",
        "payable_amount",
        "paid_amount",
        "status",
    ];

    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['due_date_display'] = Carbon::parse($this->due_date)->toFormattedDateString();
        $array['is_overdue'] = $this->status=='unpaid'?(Carbon::parse($this->due_date)->isPast()?1:0):0;
        $array['status_display'] = ucfirst($this->status);
        return $array;
    }
}
