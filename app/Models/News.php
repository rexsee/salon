<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title','slug','news_date','type','description','content'];
    protected $dates = ['news_date'];
}
