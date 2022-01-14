<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'barangay',
        'city',
        'province',
        'mobile_no',
        'contact_person_id',
    ];
}
