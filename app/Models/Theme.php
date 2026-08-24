<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Theme extends Model
{

    protected $guarded = [];
    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'theme_code', 'code');
    }

    public function axis()
    {
        return $this->belongsTo(Axis::class, 'axis_id', 'id');
    }
}
