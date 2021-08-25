<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
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
