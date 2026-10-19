@extends('layouts.landing')

@section('content')
@php
    $actual = $indicador->latestProgress?->actual_value;
    $meta = $indicador->shortTermGoal?->target_value;
    $cumplimiento = $indicador->cumplimiento;
    $estatus = $indicador->estatus ?? 'Sin registrar';

    $badgeStyle = match ($estatus) {
        'En Meta' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
        'En Riesgo' => 'bg-amber-50 text-amber-700 border-amber-200/80',
        'Crítico' => 'bg-rose-50 text-rose-700 border-rose-200/80',
        default => 'bg-slate-100 text-slate-600 border-slate-200',
    };

    $dotStyle = match ($estatus) {
        'En Meta' => 'bg-emerald-500',
        'En Riesgo' => 'bg-amber-500',
        'Crítico' => 'bg-rose-500',
        default => 'bg-slate-400',
    };

    $axisColor = $indicador->theme?->axis?->color ?? '#0d2f3d';
    $maxFecha = $indicador->latestProgress?->captured_at ?? $indicador->latestProgress?->updated_at;
    $ultimaActualizacion = $maxFecha ? \Carbon\Carbon::parse($maxFecha)->format('d/m/Y') : 'Sin registro';
@endphp

<div>
    <!-- Encabezado del Indicador -->
    <div class="bg-slate-900 text-white pt-6 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-300 hover:text-white bg-white/10 hover:bg-white/20 px-3.5 py-2 rounded-lg backdrop-blur-sm transition-all">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Volver al listado
                </a>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-white shadow-sm" style="background-color: {{ $axisColor }}">
                    Eje {{ $indicador->theme?->axis?->axis_number ?? '1' }}. {{ $indicador->theme?->axis?->name ?? 'Eje Institucional' }}
                </span>
            </div>

            <div class="flex flex-col md:flex-row md:items-start gap-5">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-md border border-white/10" style="background-color: {{ $axisColor }}">
                   <img class="p-1" src="{{  asset('images/logos/' . $indicador->theme?->axis?->id . '.png')  }}" alt="">
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="text-xs font-bold text-teal-400 uppercase tracking-widest bg-teal-500/10 px-2.5 py-1 rounded border border-teal-500/20">
                            ID: {{ $indicador->code ?? 'IND-'.$indicador->id }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">
                            Temática: {{ $indicador->theme?->code }}. {{ $indicador->theme?->name ?? 'Sin temática' }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                        {{ $indicador->name }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Bloque de Tarjetas Informativas -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Valor Actual</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-800">{{ $actual !== null ? number_format($actual, 2) : '—' }}</span>
                    <span class="text-xs font-semibold text-slate-500">{{ $indicador->unit_of_measure ?? '' }}</span>
                </div>
                <div class="mt-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dotStyle }}"></span>
                        {{ $estatus }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Meta Programada</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-800">{{ $meta !== null ? number_format($meta, 2) : '—' }}</span>
                    <span class="text-xs font-semibold text-slate-500">{{ $indicador->unit_of_measure ?? '' }}</span>
                </div>
                <div class="mt-3 text-xs text-slate-500 font-medium">
                    Fecha meta: {{ $indicador->shortTermGoal?->target_date ? \Carbon\Carbon::parse($indicador->shortTermGoal->target_date)->format('Y') : 'Por definir' }}
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">% Cumplimiento</div>
                <div class="text-3xl font-black text-slate-800">{{ $cumplimiento !== null ? number_format($cumplimiento, 1).'%' : '—' }}</div>
                <div class="mt-3">
                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full {{ $dotStyle }} rounded-full" style="width: {{ min($cumplimiento ?? 0, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Corte de Información</div>
                <div class="text-2xl font-black text-slate-800">{{ $ultimaActualizacion }}</div>
                <div class="mt-3 text-xs text-slate-500 font-medium flex items-center gap-1">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9"/></svg>
                    Frecuencia: {{ $indicador->frequency ?? 'Anual' }}
                </div>
            </div>

        </div>

        <!-- Secciones Técnicas e Histórico -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        Alineación Institucional
                    </h2>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-2">
                        <div class="text-xs font-bold text-slate-500 uppercase">Temática {{ $indicador->theme?->code }}</div>
                        <div class="text-base font-bold text-slate-800">{{ $indicador->theme?->name }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">Histórico de Avances Registrados</h2>
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase">
                                    <th class="px-4 py-3">Fecha de Corte</th>
                                    <th class="px-4 py-3">Valor Reportado</th>
                                    <th class="px-4 py-3">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($indicador->progressRecords as $progreso)
                                    <tr class="hover:bg-slate-50/60">
                                        <td class="px-4 py-3 font-semibold">{{ \Carbon\Carbon::parse($progreso->captured_at ?? $progreso->created_at)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 font-bold text-slate-900">{{ number_format($progreso->actual_value, 2) }} {{ $indicador->unit_of_measure }}</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $progreso->notes ?? 'Sin observaciones' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-slate-400">No hay registros históricos guardados aún.</td>
                                    </tr>
                                
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral de Acciones -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 shadow-md text-white space-y-4">
                    <h4 class="font-bold text-base">Ficha Técnica Oficial</h4>
                    <p class="text-xs text-slate-300">Consulta o imprime la ficha técnica del indicador.</p>
                    <button type="button" onclick="window.print()" class="w-full py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all">
                        Imprimir / Guardar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection