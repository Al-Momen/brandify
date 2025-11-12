<?php

namespace App\Models;

use App\Models\LogoImage;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logo_images()
    {
        return $this->belongsTo(LogoImage::class);
    }
}
