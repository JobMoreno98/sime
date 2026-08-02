<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndicatorGoal extends Model
{
    use HasFactory;

    protected $table = 'indicator_goals';

    protected $fillable = [
        'indicator_code',
        'year',
        'goal_type',
        'target_value',
    ];

    protected $casts = [
        'year' => 'integer',
        'target_value' => 'decimal:4',
    ];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_code');
    }
}
