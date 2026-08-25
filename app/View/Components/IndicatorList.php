<?php

namespace App\Livewire;


use App\Models\Indicator;
use App\Models\Axis;
use App\Models\Theme;
use App\Helpers\ThemeHelper; // Ajusta este namespace según tu proyecto
use Illuminate\View\Component;

class IndicatorList extends Component
{
    // Propiedades para enlazar con los selects (filtros)
    public $selectedAxis = 'Todos';
    public $selectedTheme = 'Todas';

    // Método para limpiar los filtros
    public function clearFilters()
    {
        $this->selectedAxis = 'Todos';
        $this->selectedTheme = 'Todas';
    }

    public function render()
    {
        $query = Indicator::with([
            'theme.axis',
            'responsibleUser',
            'shortTermGoal',
            'latestProgress',
        ]);

        // Filtro por Eje
        if ($this->selectedAxis !== 'Todos') {
            $query->whereHas('theme', function ($q) {
                $q->where('axis_id', $this->selectedAxis);
            });
        }

        // Filtro por Temática
        if ($this->selectedTheme !== 'Todas') {
            $query->where('theme_code', $this->selectedTheme);
        }

        $indicators = $query->get()->map(function ($indicator) {
            $meta = $indicator->shortTermGoal?->target_value;
            $avance = $indicator->latestProgress?->actual_value;

            $indicator->cumplimiento = ($meta && $avance !== null)
                ? min(round(($avance / $meta) * 100), 100)
                : null;

            $indicator->estatus = match (true) {
                $indicator->cumplimiento === null => 'Sin Datos',
                $indicator->cumplimiento >= 90 => 'En Meta',
                $indicator->cumplimiento >= 60 => 'En Riesgo',
                default => 'Crítico',
            };

            $indicator->icon_svg = ThemeHelper::getTematicaIconSvg($indicator->theme_code);

            return $indicator;
        });

        $axes = Axis::all();
        $themes = Theme::all();

        return view('components.indicator-list', compact('indicators', 'axes', 'themes'));
    }
}