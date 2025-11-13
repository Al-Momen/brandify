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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function logo_images()
    {
        return $this->hasMany(LogoImage::class);
    }

}
