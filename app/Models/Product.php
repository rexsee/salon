<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'collection',
        'image_path',
        'is_active',
        'description',
        'price',
        'size',
        'order',
    ];
}
