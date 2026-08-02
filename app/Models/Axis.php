<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Axis extends Model
{
    public function themes()
    {
        return $this->hasMany(Theme::class, 'axis_id', 'id');
    }

    public function calculateProgressPercentage()
    {
        return 75;
    }
}
