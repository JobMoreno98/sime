<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicator;
use App\Models\Axis;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Obtener todos los indicadores con sus relaciones necesarias
        $indicators = Indicator::with([
            'theme.axis',
            'goals',
            'latestProgress',
            'responsibleUser'
        ])->get();

        // 2. Tarjetas KPI Superiores
        $totalIndicators = $indicators->count();
        
        $enMetaCount    = $indicators->filter(fn($i) => $i->status === 'meta')->count();
        $enRiesgoCount  = $indicators->filter(fn($i) => $i->status === 'riesgo')->count();
        $criticosCount  = $indicators->filter(fn($i) => $i->status === 'critico')->count();

        // Avance global promedio de todos los indicadores
        $globalProgress = $totalIndicators > 0 
            ? round($indicators->avg(fn($i) => $i->percentage), 1) 
            : 0;

        // 3. Avance Promedio por Eje Estratégico
        $axes = Axis::with(['themes.indicators.goals', 'themes.indicators.latestProgress'])->get();
        
        $axesProgress = $axes->map(function ($axis) {
            $axisIndicators = $axis->themes->flatMap->indicators;
            $avg = $axisIndicators->count() > 0 
                ? round($axisIndicators->avg(fn($i) => $i->percentage), 1) 
                : 0;

            return [
                'id'         => $axis->id,
                'name'       => $axis->name,
                'number'     => $axis->axis_number,
                'percentage' => $avg,
            ];
        });


        // 4. Indicadores Críticos (Tabla inferior - Filtrar los que están en 'critico')
        $criticalIndicators = $indicators
            ->filter(fn($i) => $i->status === 'critico')
            ->take(5); // Tomamos los primeros 5 para la vista

        return view('pages.admin.dashboard', compact(
            'globalProgress',
            'totalIndicators',
            'enMetaCount',
            'enRiesgoCount',
            'criticosCount',
            'axesProgress',
            'criticalIndicators'
        ));
    }
}
