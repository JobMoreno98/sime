<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Axis extends Model
{
    protected $guarded = [];

    public function themes()
    {
        return $this->hasMany(Theme::class, 'axis_id', 'id');
    }

    public function calculateProgressPercentage()
    {
        return $this->average_percentage;
    }

    protected function progressStyles(): Attribute
    {
        return Attribute::make(
            get: function () {
                $percentage = $this->progress_percentage ?? 0;

                if ($percentage >= 75) {
                    return [
                        'color'  => 'bg-emerald-500',
                        'border' => 'border-l-purple-600',
                    ];
                }

                if ($percentage >= 50) {
                    return [
                        'color'  => 'bg-blue-600',
                        'border' => 'border-l-blue-600',
                    ];
                }

                if ($percentage >= 35) {
                    return [
                        'color'  => 'bg-amber-500',
                        'border' => 'border-l-amber-500',
                    ];
                }

                return [
                    'color'  => 'bg-rose-500',
                    'border' => 'border-l-rose-500',
                ];
            }
        );
    }
    protected function averagePercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Mapeamos los cumplimientos ignorando los nulos (sin avance o sin meta)
                $cumplimientos = $this->indicators
                    ->map(fn($indicator) => $indicator->cumplimiento)
                    ->filter(fn($val) => $val !== null);

                // Si no hay indicadores con avance, retorna 0
                if ($cumplimientos->isEmpty()) {
                    return 0;
                }

                // Calcula el promedio y lo redondea a 2 decimales
                return round($cumplimientos->avg(), 2);
            }
        );
    }
    public function indicators()
    {
        return $this->hasManyThrough(
            Indicator::class, // 1. Modelo al que queremos llegar
            Theme::class,     // 2. Modelo intermedio
            'axis_id',        // 3. Clave foránea en la tabla 'themes'
            'theme_code',     // 4. Clave foránea en la tabla 'indicators'
            'id',             // 5. Clave local en la tabla 'axes'
            'code'            // 6. Clave local en la tabla 'themes' (que relaciona con theme_code)
        );
    }
}
