<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'status',
        'name',
        'tel',
        'booking_date',
        'services',
        'services_id',
        'stylist_id',
        'customer_id',
        'minutes_take'
    ];

    protected $dates = ['booking_date'];

    public function stylist() {
        return $this->belongsTo('App\Models\Stylist');
    }
    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }
}
