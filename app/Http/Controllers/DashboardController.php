<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicator;
use App\Models\Axis;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Cargamos ejes con sus indicadores precargados para el accesor average_percentage
        $axes = Axis::with(['indicators.latestProgress', 'indicators.shortTermGoal'])->get();

        // 2. Cargamos todos los indicadores con sus relaciones necesarias para el dashboard
        $indicators = Indicator::with(['latestProgress', 'shortTermGoal', 'theme.axis', 'responsibleUser'])->get();

        $totalIndicators = $indicators->count();

        // 3. Evaluamos semáforos basados en la propiedad $indicator->cumplimiento
        $enMeta = $indicators->filter(fn($i) => $i->cumplimiento !== null && $i->cumplimiento >= 90);
        $enRiesgo = $indicators->filter(fn($i) => $i->cumplimiento !== null && $i->cumplimiento >= 60 && $i->cumplimiento < 90);
        $criticos = $indicators->filter(fn($i) => $i->cumplimiento !== null && $i->cumplimiento < 60);

        // 4. Promedio global excluyendo nulos
        $validCumplimientos = $indicators->map(fn($i) => $i->cumplimiento)->filter(fn($v) => $v !== null);
        $globalProgress = $validCumplimientos->isNotEmpty() ? round($validCumplimientos->avg(), 2) : 0;

        // 5. Mapeo de avance por Eje Estratégico
        $axesProgress = $axes->map(function ($axis) {
            return [
                'number' => $axis->code ?? $axis->id,
                'name' => $axis->name,
                'percentage' => $axis->average_percentage,
            ];
        });

        return view('pages.admin.dashboard', [
            'globalProgress' => $globalProgress,
            'totalIndicators' => $totalIndicators,
            'enMetaCount' => $enMeta->count(),
            'enRiesgoCount' => $enRiesgo->count(),
            'criticosCount' => $criticos->count(),
            'axesProgress' => $axesProgress,
            'criticalIndicators' => $criticos->values(),
        ]);
    }
}
