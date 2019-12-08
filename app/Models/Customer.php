<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'tel', 'email', 'dob', 'occupation', 'gender', 'handle_by', 'address', 'city', 'allergies', 'remark', 'follow_up_date','stylist_id'];
    protected $dates = ['dob','last_visit_at','follow_up_date'];

    public function stylist() {
        return $this->belongsTo('App\Models\Stylist');
    }

    public function logs() {
        return $this->hasMany('App\Models\CustomerLog');
    }
    public function last_log() {
        return $this->hasMany('App\Models\CustomerLog')->latest()->first();
    }

    public function bookings() {
        return $this->hasMany('App\Models\Booking');
    }
}
