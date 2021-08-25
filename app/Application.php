<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    protected $fillable = [
        'client_id',
        'unit_id',
        'application_number',
        'total_price',
        'down_payment',
        'terms',
        'rebate',
        'amortization',
        'first_payment_due',
        'gross_monthly_rate',
        'net_monthly_rate',
        'start_date',
        'end_date',
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function unit()
    {
        return $this->belongsTo(Units::class, 'unit_id');
    }

    public function schedules()
    {
        return $this->hasMany(PaymentSchedule::class, 'application_id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'application_id');
    }

    public function getRemBalAttribute()
    {
        $query = $this->schedules()->select(DB::raw('sum(payable_amount) - sum(paid_amount) as rem_bal'))->first();
        return optional($query)->rem_bal;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $rem_bal_query = $this->schedules()->select(DB::raw('sum(payable_amount) - sum(paid_amount) as rem_bal'))->first();
        $total_paid_query = $this->schedules()->sum('paid_amount');
        $total_payable_query = $this->schedules()->sum('payable_amount');
        $array["rem_bal"] = optional($rem_bal_query)->rem_bal;
        $array["total_paid"] = $total_paid_query;
        $array["total_payable"] = $total_payable_query;

        return $array;
    }
}
