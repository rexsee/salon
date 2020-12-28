<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'is_active',
        'description',
        'price',
        'size',
        'order',
    ];
}
