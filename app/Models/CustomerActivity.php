<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model
{
    protected $fillable = ['service_id', 'remark', 'stylist_id', 'customer_id'];

    public function stylist()
    {
        return $this->belongsTo('App\Models\Stylist');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
