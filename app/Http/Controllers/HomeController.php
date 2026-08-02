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
        //$totalIndicators = Indicator::count(); // Ej. 53
        //$axes = Axis::with('themes')->get();   // Ejes con sus temáticas
        //$axes = Axis::all();
        //$axes = Axis::with('themes')->get();
        $axes = Axis::with([
            'themes' => function ($query) {
                $query->withCount('indicators');
            }
        ])->get();
        $countAllIndicators = 0;
        foreach ($axes as $axis) {
            $axis->total_indicators = $axis->themes->sum('indicators_count');
            $countAllIndicators += $axis->total_indicators;
        }
        //$recentProgress = ProgressRecord::latest()->take(5)->get(); // Últimos 5 avances

        return view('pages.inicio', compact('axes', 'countAllIndicators'));
    }


    public function indicators(Request $request)
    {

        $query = Indicator::with([
            'theme',
            'theme.axis',
            'goals',
            'latestProgress'
        ]);


        if ($request->filled('axis') && $request->axis != "Todos") {
             $query->whereHas('theme', function ($q) use ($request) {
                $q->where('axis_id', $request->axis);
            });
        }

        if ($request->filled('theme') && $request->theme != "Todas") {
            $query->where('theme_code', $request->theme);
        }

        $indicators = $query->get();

        // Inyectamos el ícono a cada objeto de la colección
        $indicators->transform(function ($indicator) {
            $indicator->icon_svg = ThemeHelper::getTematicaIconSvg($indicator->theme_code);
            return $indicator;
        });

        $axes = Axis::all();

        $themes = Theme::all();

        return view('pages.indicadores', compact('indicators', 'axes', 'themes', 'request'));
    }
}
