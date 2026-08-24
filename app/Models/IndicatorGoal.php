<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndicatorGoal extends Model
{
    use HasFactory;

    protected $fillable = ['indicator_code', 'year', 'goal_type', 'target_value'];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_code', 'code');
    }
}
