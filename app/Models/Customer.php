<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'tel', 'email', 'dob', 'gender', 'address', 'city', 'allergies', 'remark', 'stylist_id'];
    protected $dates = ['dob'];

    public function stylist() {
        return $this->belongsTo('App\Models\Stylist');
    }

    public function logs() {
        return $this->hasMany('App\Models\CustomerLog');
    }

    public function bookings() {
        return $this->hasMany('App\Models\Booking');
    }
}
