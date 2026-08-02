<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;


class Indicator extends Model
{

    use HasFactory;

    protected $table = 'indicators';
    protected $fillable = [
        'code',
        'name',
        'theme_id',
        'measurement_unit',
        'measurement_frequency',
        'responsible_user_id',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_code', 'code');
    }

    public function goals()
    {
        return $this->hasMany(IndicatorGoal::class, 'indicator_code', 'code');
    }

    /**
     * Relación con TODOS los avances (ProgressRecords)
     */
    public function progressRecords()
    {
        return $this->hasMany(ProgressRecord::class, 'indicator_code');
    }

    /**
     * RELACIÓN CLAVE: Obtiene SOLO el último avance registrado
     */
    public function latestProgress()
    {
        return $this->hasOne(ProgressRecord::class, 'indicator_code')->latestOfMany('captured_at');
    }




    public function getPercentageAttribute()
    {
        $current = $this->latestProgress?->actual_value 
            ?? $this->goals->firstWhere('goal_type', 'BASE')?->target_value 
            ?? 0;

        $target = $this->goals->firstWhere('goal_type', 'FINAL')?->target_value 
            ?? $this->goals->firstWhere('goal_type', 'INTERMEDIATE')?->target_value 
            ?? 1;

        if ($target == 0) return 0;

        return min(100, round(($current / $target) * 100, 1));
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    /**
     * Determina el Estatus del Indicador: 'meta', 'riesgo' o 'critico'
     */
    public function getStatusAttribute()
    {
        $percentage = $this->percentage;

        if ($percentage >= 70) {
            return 'meta';     // En verde / Buen ritmo (>= 70%)
        } elseif ($percentage >= 40) {
            return 'riesgo';   // En amarillo / Riesgo (40% - 69%)
        }

        return 'critico';      // En rojo / Crítico (< 40%)
    }
}
