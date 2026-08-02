<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'theme_code', 'code');
    }

    public function axis()
    {
        return $this->belongsTo(Axis::class, 'axis_id', 'id');
    }
}
