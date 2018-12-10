<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function article()
    {
        return $this->belongsToMany('App\Models\Article');
    }
}
