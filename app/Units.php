<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Units extends Model implements HasMedia
{
    //
    use HasMediaTrait;

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

    public function getImagePrimaryAttribute()
    {
        if($this->hasMedia('primary')){
            return $this->getFirstMediaUrl('primary');
        }else{
            return url('img/blank-landscape.jpg');

        }
    }
}
