<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SponsoredAd extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'poster_path',
        'business_name'
    ];

}
