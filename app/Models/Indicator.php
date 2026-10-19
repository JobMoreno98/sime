<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model
{

    use SoftDeletes;
    protected $appends = ['cumplimiento'];
    protected $fillable = [
        'code',
        'name',
        'theme_code',
        'measurement_unit',
        'measurement_frequency',
        'responsible_user_id'
    ];

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

    protected function cumplimiento(): Attribute
    {
        return Attribute::make(
            get: function () {
                $actual = $this->latestProgress?->actual_value;
                $target = $this->shortTermGoal?->target_value;
                if ($actual === null || !$target || $target == 0) {
                    return null;
                }

                return ($actual / $target) * 100;
            }
        );
    }

    /**
     * Accesor para determinar el Estatus del Indicador
     */
    protected function estatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $pct = $this->cumplimiento;

                if ($pct === null) {
                    return 'Sin registrar';
                }

                if ($pct >= 90) {
                    return 'En Meta';
                }

                if ($pct >= 60) {
                    return 'En Riesgo';
                }

                return 'Crítico';
            }
        );
    }
}
