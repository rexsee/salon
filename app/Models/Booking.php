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
        'stylist_id',
        'hour_take'
    ];

    protected $dates = ['booking_date'];

    public function stylist() {
        return $this->belongsTo('App\Models\Stylist');
    }
}
