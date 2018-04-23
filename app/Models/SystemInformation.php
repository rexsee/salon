<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemInformation extends Model
{
    protected $fillable = ['address','contact_number','fax_number','email','head_line','slogan'];
}
