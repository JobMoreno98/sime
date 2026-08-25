<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Indicator extends Model
{
    
    protected $fillable = [
        'code',
        'name',
        'theme_code',
        'measurement_unit',
        'measurement_frequency',
        'responsible_user_id'
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }


    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_code', 'code');
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function goals()
    {
        return $this->hasMany(IndicatorGoal::class, 'indicator_code', 'code');
    }

    // Meta a corto plazo del año en curso (lo único activo por ahora)
    public function shortTermGoal()
    {
        return $this->hasOne(IndicatorGoal::class, 'indicator_code', 'code')
            ->where('year', now()->year)
            ->where('goal_type', 'INTERMEDIATE');
    }

    // Ya queda la relación lista para cuando se active mediano/largo plazo
    public function longTermGoal()
    {
        return $this->hasOne(IndicatorGoal::class, 'indicator_code', 'code')
            ->where('goal_type', 'FINAL');
    }

    public function progressRecords()
    {
        return $this->hasMany(ProgressRecord::class, 'indicator_code', 'code');
    }

    // El registro de avance más reciente (por captured_at)
    public function latestProgress()
    {
        return $this->hasOne(ProgressRecord::class, 'indicator_code', 'code')
            ->latestOfMany('captured_at');
    }
}
