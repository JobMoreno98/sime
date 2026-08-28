<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Axis;
use App\Models\Theme;
use App\Models\Indicator;
use App\Helpers\ThemeHelper;

class HomeController extends Controller
{
    // Método para la página de Inicio / Principal
    public function index()
    {
        // Consultamos solo lo necesario para el público

        $axes = Axis::withCount('indicators')
            ->with([
                'indicators.latestProgress',
                'indicators.shortTermGoal'
            ])
            ->get();

        $countAllIndicators = $axes->sum('indicators_count');

        $indicators = Indicator::with(['latestProgress', 'shortTermGoal'])->get();

        $cumplimientos = $indicators->map(fn($i) => $i->cumplimiento)->filter(fn($val) => $val !== null);

        $globalAverage = $cumplimientos->isNotEmpty() ? round($cumplimientos->avg(), 2) : 0;

        return view('pages.inicio', compact('axes', 'countAllIndicators', 'globalAverage'));
    }


    public function indicators()
    {
        return view('pages.indicadores');
    }
}
