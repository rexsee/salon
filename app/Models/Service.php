<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'type', 'order', 'price_type', 'price', 'minutes_needed', 'description'];
}
