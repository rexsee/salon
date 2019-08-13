<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    protected $fillable = ['name','experience','specialty','order','is_stylist','availability','title','avatar_path','description'];
}
