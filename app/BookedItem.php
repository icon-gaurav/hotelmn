<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookedItem extends Model
{
    //

//    protected $table = 'BookedItem';

    public function booking(){
        return $this->belongsTo('App\Booking');
    }

    public function customer(){
        return $this->hasOne('App\Customer');
    }

    public function room(){
        return $this->hasOne('App\Room');
    }
}
