<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model
{
    protected $fillable = ['services_id', 'services', 'remark', 'stylist_id', 'customer_id'];

    public function stylist()
    {
        return $this->belongsTo('App\Models\Stylist');
    }
}
