@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- BREADCRUMB Y NAVEGACIÓN -->
        <div class="flex items-center justify-between">
            <nav class="flex items-center gap-2 text-theme-xs text-gray-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="/indicadores" class="hover:text-teal-600 transition-colors">Indicadores</a>
                <span>/</span>
                <span class="text-gray-800 font-medium">Temática {{ $theme->code ?? $theme->id }}</span>
            </nav>

            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 text-theme-xs font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </a>
            <form action="{{ route('tematicas.destroy', $theme) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta temática?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-rose-600 hover:text-rose-800 text-theme-xs font-semibold">
                    Eliminar
                </button>
            </form>
        </div>

        <!-- HEADER DE LA TEMÁTICA -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200/60 mb-2">
                        Eje {{ $theme->axis->code ?? ($theme->axis->axis_number ?? '-') }}:
                        {{ $theme->axis->name ?? 'Sin Eje' }}
                    </span>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $theme->code ? $theme->code . ' · ' : '' }}{{ $theme->name }}
                    </h1>
                </div>

                <!-- Promedio General de la Temática -->
                @php
                    $validCumplimientos = $theme->indicators
                        ->map(fn($i) => $i->cumplimiento)
                        ->filter(fn($v) => $v !== null);
                    $themeAverage = $validCumplimientos->isNotEmpty() ? round($validCumplimientos->avg(), 2) : 0;
                @endphp
                <div
                    class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 px-4 py-3 rounded-xl self-start sm:self-auto">
                    <div class="text-right">
                        <span class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Avance
                            Promedio</span>
                        <span class="text-xl font-extrabold text-teal-700">{{ $themeAverage }}%</span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-lg bg-teal-600 text-white flex items-center justify-center font-bold text-xs">
                        {{ $themeAverage >= 90 ? '🟢' : ($themeAverage >= 60 ? '🟡' : '🔴') }}
                    </div>
                </div>
            </div>

            @if (!empty($theme->description))
                <p class="text-theme-sm text-gray-600 border-t border-gray-100 pt-3 leading-relaxed">
                    {{ $theme->description }}
                </p>
            @endif
        </div>

        <!-- TARJETAS DE MÉTRICAS CLAVE -->
        @php
            $totalInds = $theme->indicators->count();
            $enMeta = $theme->indicators
                ->filter(fn($i) => $i->cumplimiento !== null && $i->cumplimiento >= 90)
                ->count();
            $enRiesgo = $theme->indicators
                ->filter(fn($i) => $i->cumplimiento !== null && $i->cumplimiento >= 60 && $i->cumplimiento < 90)
                ->count();
            $criticos = $theme->indicators
                ->filter(fn($i) => $i->cumplimiento !== null && $i->cumplimiento < 60)
                ->count();
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <span class="text-theme-xs font-medium text-gray-500">Total Indicadores</span>
                <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $totalInds }}</div>
                <p class="text-theme-xs text-gray-400 mt-1">Asignados a la temática</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <span class="text-theme-xs font-medium text-emerald-700">🟢 En Meta (≥90%)</span>
                <div class="mt-2 text-3xl font-extrabold text-emerald-600">{{ $enMeta }}</div>
                <p class="text-theme-xs text-gray-400 mt-1">{{ $totalInds > 0 ? round(($enMeta / $totalInds) * 100) : 0 }}%
                    del total</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <span class="text-theme-xs font-medium text-amber-700">🟡 En Riesgo (60-89%)</span>
                <div class="mt-2 text-3xl font-extrabold text-amber-600">{{ $enRiesgo }}</div>
                <p class="text-theme-xs text-gray-400 mt-1">
                    {{ $totalInds > 0 ? round(($enRiesgo / $totalInds) * 100) : 0 }}% del total</p>
            </div>

            <div class="rounded-2xl border border-rose-200 bg-rose-50/30 p-5 shadow-sm">
                <span class="text-theme-xs font-semibold text-rose-700 uppercase tracking-wider">🔴 Críticos
                    (&lt;60%)</span>
                <div class="mt-2 text-3xl font-extrabold text-rose-600">{{ $criticos }}</div>
                <p class="text-theme-xs text-rose-600 mt-1">Requieren atención</p>
            </div>
        </div>

        <!-- TABLA DE INDICADORES ASOCIADOS -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-900">Indicadores de la Temática</h3>
                <p class="text-theme-xs text-gray-500">Listado y estatus actual de cumplimiento</p>
            </div>

            <div class="max-w-full overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Código</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Indicador</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Responsable</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Cumplimiento</th>
                            <th class="px-6 py-3 text-center text-theme-xs font-medium text-gray-500">Estatus</th>
                            <th class="px-6 py-3 text-end text-theme-xs font-medium text-gray-500">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($theme->indicators as $indicator)
                            @php
                                $cumplimiento = $indicator->cumplimiento ?? 0;

                                if ($cumplimiento >= 90) {
                                    $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $barBg = 'bg-emerald-500';
                                    $statusText = 'En Meta';
                                } elseif ($cumplimiento >= 60) {
                                    $badgeBg = 'bg-amber-50 text-amber-700 border-amber-200';
                                    $barBg = 'bg-amber-500';
                                    $statusText = 'En Riesgo';
                                } else {
                                    $badgeBg = 'bg-rose-50 text-rose-700 border-rose-200';
                                    $barBg = 'bg-rose-500';
                                    $statusText = 'Crítico';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900 text-theme-xs">
                                        {{ $indicator->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="/indicadores/{{ $indicator->id }}"
                                        class="font-medium text-gray-800 hover:text-teal-600 text-theme-sm block transition-colors">
                                        {{ $indicator->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-theme-xs text-gray-600">
                                        {{ $indicator->responsibleUser->name ?? 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                                            <div class="{{ $barBg }} h-2 rounded-full"
                                                style="width: {{ min(100, $cumplimiento) }}%"></div>
                                        </div>
                                        <span class="text-theme-xs font-bold text-gray-700">
                                            {{ number_format($cumplimiento, 1) }}%
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeBg }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end">
                                    <a href="{{ route('indicadores.show', $indicator) }}"
                                        class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-800 text-theme-xs font-semibold transition-colors">
                                        <span>Ver detalle</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-theme-xs">
                                    No hay indicadores asignados a esta temática.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
