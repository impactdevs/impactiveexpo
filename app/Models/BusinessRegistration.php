<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRegistration extends Model
{
    protected $fillable = [
        'business_name',
        'email',
        'phone',
        'sponsor_package',
        'exhibitor_package',
        'dinner_package',
        'magazine_options',
        'message',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'magazine_options' => 'array'
    ];
}