<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    //

    protected $fillable = [
        'plate_no',
        'engine_no',
        'chassis_no',
        'brand',
        'model',
        'color',
        'type',
        'bnew_repo',
        'remarks',
    ];
}
