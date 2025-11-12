<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogoImage extends Model
{
     public function logo()
    {
        return $this->belongsTo(Logo::class);
    }
}
