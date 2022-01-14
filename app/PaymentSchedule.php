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

    public function getIsOverdueAttribute()
    {
        $overdue = 0;
        if($this->status=='unpaid'){
            if(Carbon::parse($this->due_date)->isPast()){
                $overdue = 1;
            }else{
                $overdue = 0;
            }
        }else{
            if(Carbon::parse($this->due_date)->isBefore(Carbon::parse($this->paid_date))){
                $overdue = 1;
            }else{
                $overdue = 0;
            }
        }
        return $overdue;
    }

    public function getDueDateDisplayAttribute()
    {
        return $this->due_date?Carbon::parse($this->due_date)->toFormattedDateString():'';
    }

    public function getPaidDateDisplayAttribute()
    {
        if($this->status == 'paid' && $this->payable_amount > 0 && $this->paid_date != null){
            return Carbon::parse($this->paid_date)->toFormattedDateString();
        }
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['due_date_display'] = Carbon::parse($this->due_date)->toFormattedDateString();
        $array['paid_date_display'] = $this->paid_date?Carbon::parse($this->paid_date)->toFormattedDateString():'';
        $overdue = 0;
        if($this->status=='unpaid'){
            if(Carbon::parse($this->due_date)->isPast()){
                $overdue = 1;
            }else{
                $overdue = 0;
            }
        }else{
            if(Carbon::parse($this->due_date)->isBefore(Carbon::parse($this->paid_date))){
                $overdue = 1;
            }else{
                $overdue = 0;
            }
        }
        $array['is_overdue'] = $overdue;
        $array['status_display'] = ucfirst($this->status);
        if($array['is_overdue']){
            $array['payable_amount'] = $this->application->gross_monthly_rate;
        }
        return $array;
    }
}
