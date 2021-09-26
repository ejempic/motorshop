<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repossessed extends Model
{
    //
    protected $fillable = [
        'unit_id',
        'client_id',
        'date_acquired',
        'date_returned',
    ];
}
