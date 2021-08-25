<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    public function toArray()
    {
        $array = parent::toArray();
        $array['paid_date_formatted'] = Carbon::parse($this->due_date)->toFormattedDateString();
        return $array;
    }
}
