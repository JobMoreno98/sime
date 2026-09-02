<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use SoftDeletes;

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
