<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRegistration extends Model
{
        protected $fillable = [
        'business_name',
        'email',
        'phone',
        'package',
        'message',
        'ip_address',
        'user_agent'
    ];
}
