<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Clients extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'lname',
        'fname',
        'mname',
        'contact_number_1',
        'contact_number_2',
        'email',
        'marital_status',
        'dob',
        'address',
        'barangay',
        'city',
        'province',
        'remarks',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'client_id')->orderBy('created_at','desc');
    }

    public function applicationsSortStatus()
    {
        return $this->hasMany(Application::class, 'client_id')
            ->orderBy('created_at','asc')
            ->orderBy('status','desc')
            ;
    }

    public function application()
    {
        return $this->hasOne(Application::class, 'client_id')->orderBy('created_at','desc');
    }

    public function getImagePrimaryAttribute()
    {
        if($this->hasMedia('primary')){
            return $this->getFirstMediaUrl('primary');
        }else{
            return url('img/blank-profile.jpg');

        }
    }

    public function getNameAttribute()
    {
        return $this->lname." ".$this->fname;
    }

    public function getCompleteAddressAttribute()
    {
        return $this->address." ".$this->barangay." ".$this->city." ".$this->province;
    }

    public function getMobileNumbersAttribute()
    {
        if($this->contact_number_1){
            if($this->contact_number_2){
                return $this->contact_number_1."/".$this->contact_number_2;
            }
            return $this->contact_number_1;
        }else{
            if($this->contact_number_2){
                return $this->contact_number_2;
            }
        }
        return '';
    }
}
