<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLog extends Model
{
    protected $fillable = ['services_id', 'services', 'remark', 'handle_by', 'products', 'log_date', 'total', 'stylist_id', 'customer_id'];
    protected $dates = ['log_date'];

    public function stylist()
    {
        return $this->belongsTo('App\Models\Stylist');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
