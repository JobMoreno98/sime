@extends('layouts.app')

@section('content')

<div x-data="{
    activeTab: 'criticos',

    kpiStats: {
        avanceGlobal: {{ number_format($globalProgress ?? 0, 2, '.', '') }},
        totalIndicadores: {{ $totalIndicators ?? 0 }},
        enMeta: {{ $enMetaCount ?? 0 }},
        enRiesgo: {{ $enRiesgoCount ?? 0 }},
        criticos: {{ $criticosCount ?? 0 }}
    },

    descargarReporte() {
        console.log('Generando reporte...');
    },

    capturarNuevoAvance() {
        console.log('Abriendo modal...');
    },

    irATablaFiltrada(eje) {
        window.location.href = '/indicadores?eje=' + encodeURIComponent(eje);
    }
}">

    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-theme-xs text-gray-500 mt-0.5">Plan de Desarrollo CUCSH (2025–2031)</p>
            </div>
        </div>

        <!-- BLOQUE 1: METRICAS CLAVE (KPIs) -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Card 1: Avance Global -->
            <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium text-gray-500">Cumplimiento Global</span>
                    <span class="p-2 rounded-xl bg-teal-50 text-teal-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-gray-900" x-text="`${kpiStats.avanceGlobal}%`"></span>
                </div>
                <div class="mt-3 w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-teal-600 h-1.5 rounded-full transition-all duration-500" :style="`width: ${Math.min(100, kpiStats.avanceGlobal)}%`"></div>
                </div>
            </div>

            <!-- Card 2: Total Indicadores -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium text-gray-500">Total de Indicadores</span>
                    <span class="p-2 rounded-xl bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-gray-900" x-text="kpiStats.totalIndicadores"></span>
                    <p class="text-theme-xs text-gray-500 mt-1">Activos en plataforma</p>
                </div>
            </div>

            <!-- Card 3: En Meta -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium text-gray-500">En Meta (≥90%)</span>
                    <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-emerald-600" x-text="kpiStats.enMeta"></span>
                    <span class="text-theme-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700"
                          x-text="`${kpiStats.totalIndicadores ? Math.round((kpiStats.enMeta / kpiStats.totalIndicadores)*100) : 0}% del total`"></span>
                </div>
            </div>

            <!-- Card 4: Críticos -->
            <div class="rounded-2xl border border-rose-200 bg-rose-50/30 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-semibold text-rose-700 uppercase tracking-wider">Críticos (&lt;60%)</span>
                    <span class="p-2 rounded-xl bg-rose-100 text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-rose-600" x-text="kpiStats.criticos"></span>
                    <span class="text-theme-xs font-medium text-rose-600" x-text="`${kpiStats.criticos} requieren atención`"></span>
                </div>
            </div>

        </div>

        <!-- BLOQUE 2: EJES Y ESTATUS -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- Avance por Eje -->
            <div class="lg:col-span-7 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">Avance Promedio por Eje Estratégico</h3>
                            <p class="text-theme-xs text-gray-500">Calculado a partir del promedio de sus indicadores</p>
                        </div>
                    </div>

                    <div class="space-y-4 my-2">
                        @foreach($axesProgress as $axis)
                            <div @click="irATablaFiltrada('{{ $axis['number'] }}')" class="group cursor-pointer">
                                <div class="flex items-center justify-between text-theme-xs mb-1">
                                    <span class="font-medium text-gray-700 group-hover:text-teal-600 transition-colors">
                                        Eje {{ $axis['number'] }}. {{ trim($axis['name']) }}
                                    </span>
                                    <span class="font-semibold text-gray-800">{{ number_format($axis['percentage'], 2) }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                                    <div class="bg-teal-600 h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: {{ min(100, $axis['percentage']) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Distribución de Estatus -->
            <div class="lg:col-span-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 mb-1">Distribución de Estatus</h3>

                    <div class="relative flex items-center justify-center my-6">
                        <div class="w-44 h-44 rounded-full bg-slate-50 border-8 border-slate-100 flex items-center justify-center shadow-inner">
                            <div class="text-center">
                                <span class="text-3xl font-extrabold text-gray-900">{{ $totalIndicators }}</span>
                                <span class="block text-theme-xs text-gray-500 font-medium">Indicadores</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center pt-2">
                        <div class="p-2.5 rounded-xl bg-emerald-50">
                            <span class="block text-theme-xs font-semibold text-emerald-700">En Meta</span>
                            <span class="text-base font-bold text-gray-800">{{ $enMetaCount }}</span>
                            <span class="block text-[10px] text-gray-500">
                                {{ $totalIndicators > 0 ? number_format(($enMetaCount / $totalIndicators) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-amber-50">
                            <span class="block text-theme-xs font-semibold text-amber-700">En Riesgo</span>
                            <span class="text-base font-bold text-gray-800">{{ $enRiesgoCount }}</span>
                            <span class="block text-[10px] text-gray-500">
                                {{ $totalIndicators > 0 ? number_format(($enRiesgoCount / $totalIndicators) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-rose-50">
                            <span class="block text-theme-xs font-semibold text-rose-700">Críticos</span>
                            <span class="text-base font-bold text-gray-800">{{ $criticosCount }}</span>
                            <span class="block text-[10px] text-gray-500">
                                {{ $totalIndicators > 0 ? number_format(($criticosCount / $totalIndicators) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- BLOQUE 3: TABLA DE ATENCIÓN INMEDIATA -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            
            <div class="flex items-center justify-between border-b border-gray-100 px-6 pt-4">
                <div class="flex gap-6">
                    <button @click="activeTab = 'criticos'"
                            :class="activeTab === 'criticos' ? 'border-teal-600 text-teal-600 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="pb-3 border-b-2 text-theme-sm transition-colors flex items-center gap-2">
                        <span>Indicadores Críticos</span>
                        <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-theme-xs font-bold">
                            {{ $criticalIndicators->count() }}
                        </span>
                    </button>
                </div>
            </div>

            <!-- CONTENIDO PESTAÑA: CRÍTICOS -->
            <div x-show="activeTab === 'criticos'" class="max-w-full overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Código</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Indicador Crítico</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Responsable</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Cumplimiento</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($criticalIndicators as $indicator)
                            @php
                                $cumplimiento = $indicator->cumplimiento ?? 0;
                            @endphp
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-rose-600 text-theme-xs">
                                        {{ $indicator->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="/indicadores/{{ $indicator->id }}" class="font-medium text-gray-800 hover:text-teal-600 text-theme-sm block transition-colors">
                                        {{ $indicator->name }}
                                    </a>
                                    <span class="text-[11px] text-gray-400">
                                        Eje {{ $indicator->theme->axis->code ?? $indicator->theme->axis->id ?? '-' }}: 
                                        {{ trim($indicator->theme->axis->name ?? '') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-theme-xs text-gray-600">
                                        {{ $indicator->responsibleUser->name ?? 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                                            <div class="bg-rose-500 h-2 rounded-full" style="width: {{ min(100, $cumplimiento) }}%"></div>
                                        </div>
                                        <span class="text-theme-xs font-bold text-rose-600">
                                            {{ number_format($cumplimiento, 2) }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-theme-xs">
                                    No hay indicadores en estado crítico (&lt;60%).
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
@endsection