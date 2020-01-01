<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //

    public function booking_item()
    {
        return $this->hasMany('App\BookedItem');
    }

    public function customer(){
        return $this->hasOne('App\Customer');
    }

    public function payment(){
        return $this->hasOne('App\Payment');
    }
}
