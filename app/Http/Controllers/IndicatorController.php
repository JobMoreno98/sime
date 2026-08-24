<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIndicatorRequest;
use App\Http\Requests\StoreProgressRequest;
use App\Http\Requests\UpdateIndicatorRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Models\Indicator;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index()
    {
        $indicadores = Indicator::with(['theme.axis', 'responsibleUser', 'shortTermGoal', 'latestProgress'])
            ->latest()
            ->get()
            ->map(function ($indicador) {
                $meta = $indicador->shortTermGoal?->target_value;
                $avance = $indicador->latestProgress?->actual_value;

                $cumplimiento = ($meta && $avance !== null)
                    ? min(round(($avance / $meta) * 100), 100)
                    : null;

                $estatus = match (true) {
                    $cumplimiento === null => 'Sin Datos',
                    $cumplimiento >= 90 => 'En Meta',
                    $cumplimiento >= 60 => 'En Riesgo',
                    default => 'Crítico',
                };

                $indicador->cumplimiento = $cumplimiento;
                $indicador->estatus = $estatus;

                return $indicador;
            });

        $tematicas = Theme::with('axis')->orderBy('code')->get();
        $usuarios = User::orderBy('name')->get();

        return view('pages.admin.indicadores', compact('indicadores', 'tematicas', 'usuarios'));
    }

    public function store(StoreIndicatorRequest $request)
    {
        $data = $request->validated();

        $indicador = Indicator::create(collect($data)->except('short_term_goal')->toArray());

        $indicador->goals()->create([
            'year'         => now()->year,
            'goal_type'    => 'INTERMEDIATE',
            'target_value' => $data['short_term_goal'],
        ]);

        return redirect()->route('indicadores.index')->with('success', 'Indicador creado correctamente.');
    }

    public function update(UpdateIndicatorRequest $request, Indicator $indicador)
    {
        $data = $request->validated();

        $indicador->update(collect($data)->except('short_term_goal')->toArray());

        $indicador->goals()->updateOrCreate(
            ['year' => now()->year, 'goal_type' => 'INTERMEDIATE'],
            ['target_value' => $data['short_term_goal']]
        );

        return redirect()->route('indicadores.index')->with('success', 'Indicador actualizado correctamente.');
    }
    public function storeProgress(StoreProgressRequest $request, Indicator $indicador)
    {

    
        $data = $request->validated();

        $indicador->progressRecords()->create([
            ...$data,
            'captured_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('indicadores.index')->with('success', 'Avance capturado correctamente.');
    }
}
