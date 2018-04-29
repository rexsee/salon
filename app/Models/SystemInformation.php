<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemInformation extends Model
{
    protected $fillable = [
        'address',
        'contact_number',
        'fax_number',
        'email',
        'head_line',
        'slogan',
        'image_path',
        'about_slider_path_1',
        'about_slider_path_2',
        'about_slider_path_3',
        'about_us_desc',
        'vision_image_path',
        'vision_desc'
    ];
}
