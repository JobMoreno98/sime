@extends('layouts.app')

@section('content')

<div x-data="{
    activeTab: 'criticos', // 'criticos' | 'actividad'

    // Datos dinámicos inyectados desde Laravel
    kpiStats: {
        avanceGlobal: {{ $globalProgress ?? 0 }},
        totalIndicadores: {{ $totalIndicators ?? 0 }},
        enMeta: {{ $enMetaCount ?? 0 }},
        enRiesgo: {{ $enRiesgoCount ?? 0 }},
        criticos: {{ $criticosCount ?? 0 }}
    },

    descargarReporte() {
        console.log('Generando reporte ejecutivo PDF/Excel...');
    },

    capturarNuevoAvance() {
        console.log('Abriendo modal de captura rápida...');
    },

    irATablaFiltrada(eje) {
        console.log('Redirigiendo a Tabla de Indicadores filtrada por:', eje);
    }
}">

    <div class="space-y-6">

        <!-- ========================================== -->
        <!-- HEADER: TÍTULO Y BOTONES DE ACCESO RÁPIDO  -->
        <!-- ========================================== -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    Dashboard
                </h2>
                <p class="text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Plan de Desarrollo CUCSH (2025–2031)
                </p>
            </div>

            <!-- Accesos Rápidos del Administrador -->
            <div class="flex items-center gap-2.5">
                <button style="display:none;" @click="descargarReporte()" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/60 text-theme-xs font-semibold shadow-theme-xs transition-colors">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Reporte Ejecutivo</span>
                </button>

                <button @click="capturarNuevoAvance()" 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#465fff] hover:bg-[#465fff] text-white text-theme-xs font-semibold shadow-theme-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Capturar Avance</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- BLOQUE 1: TARJETAS DE MÉTRICAS CLAVE (KPIs)-->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Card 1: Avance Global (Destacada) -->
            <div class="relative overflow-hidden rounded-2xl border border-gray bg-gradient-to-br from-gray/5 via-white to-white p-5 dark:border-gray/30 dark:from-gray/20 dark:via-gray-900 dark:to-gray-900 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium  text-gray-500 dark:text-gray-400">
                        Cumplimiento Global
                    </span>
                    <span class="p-2 rounded-xl bg-[#c7cfff] text-[#465fff] dark:bg-[#c7cfff]/40 dark:text-[#465fff]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-gray-900 dark:text-white" x-text="`${kpiStats.avanceGlobal}%`"></span>
                </div>
                <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#465fff] h-1.5 rounded-full" :style="`width: ${kpiStats.avanceGlobal}%`"></div>
                </div>
            </div>

            <!-- Card 2: Total Indicadores -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                        Total de Indicadores
                    </span>
                    <span class="p-2 rounded-xl bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-gray-900 dark:text-white" x-text="kpiStats.totalIndicadores"></span>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400 mt-1">Activos en plataforma</p>
                </div>
            </div>

            <!-- Card 3: En Meta -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                        En Meta
                    </span>
                    <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400" x-text="kpiStats.enMeta"></span>
                    <span class="text-theme-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400"
                          x-text="`${kpiStats.totalIndicadores ? Math.round((kpiStats.enMeta / kpiStats.totalIndicadores)*100) : 0}% del total`"></span>
                </div>
            </div>

            <!-- Card 4: Críticos (🔴 Atención Urgente) -->
            <div class="rounded-2xl border border-rose-200 bg-rose-50/30 p-5 dark:border-rose-900/30 dark:bg-rose-950/10 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-semibold text-rose-700 dark:text-rose-400 uppercase tracking-wider">
                        Requieren Atención
                    </span>
                    <span class="p-2 rounded-xl bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-rose-600 dark:text-rose-400" x-text="kpiStats.criticos"></span>
                    <span class="text-theme-xs font-medium text-rose-600 dark:text-rose-400" x-text="`${kpiStats.criticos} indicadores en rojo`">
                    </span>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- BLOQUE 2: GRÁFICAS DE SALUD DEL PLAN       -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- Gráfica 1: Avance Promedio por Eje Estratégico -->
            <div class="lg:col-span-7 rounded-2xl border border-gray-200 bg-white p-6 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                                Avance Promedio por Eje Estratégico
                            </h3>
                            <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                                Clic en un eje para filtrar el sistema
                            </p>
                        </div>
                        
                    </div>

                    <!-- Barras Dinámicas por Eje -->
                    <div class="space-y-4 my-2">
                        @foreach($axesProgress as $axis)
                            <div @click="irATablaFiltrada('EJE {{ $axis['number'] }}')" class="group cursor-pointer">
                                <div class="flex items-center justify-between text-theme-xs mb-1">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-[#465fff] transition-colors">
                                        Eje {{ $axis['number'] }}. {{ trim($axis['name']) }}
                                    </span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $axis['percentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 h-3 rounded-full overflow-hidden">
                                    <div class="bg-[#465fff] h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: {{ $axis['percentage'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Gráfica 2: Distribución del Semáforo -->
            <div class="lg:col-span-5 rounded-2xl border border-gray-200 bg-white p-6 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-1">
                        Distribución de Estatus
                    </h3>

                    <!-- Anillo Visual de Resumen -->
                    <div class="relative flex items-center justify-center my-4">
                        <div class="w-44 h-44 rounded-full border-[14px] border-emerald-500 border-t-amber-500 border-r-rose-500 flex items-center justify-center">
                            <div class="text-center">
                                <span class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalIndicators }}</span>
                                <span class="block text-theme-xs text-gray-500 dark:text-gray-400 font-medium">Indicadores</span>
                            </div>
                        </div>
                    </div>

                    <!-- Leyenda del Semáforo -->
                    <div class="grid grid-cols-3 gap-2 text-center pt-4">
                        <div class="p-2.5 rounded-xl bg-emerald-50/60 dark:bg-emerald-500/10">
                            <span class="block text-theme-xs font-semibold text-emerald-700 dark:text-emerald-400">🟢 En Meta</span>
                            <span class="text-base font-bold text-gray-800 dark:text-white">{{ $enMetaCount }}</span>
                            <span class="block text-[10px] text-gray-500">
                                {{ $totalIndicators > 0 ? number_format(($enMetaCount / $totalIndicators) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-amber-50/60 dark:bg-amber-500/10">
                            <span class="block text-theme-xs font-semibold text-amber-700 dark:text-amber-400">🟡 En Riesgo</span>
                            <span class="text-base font-bold text-gray-800 dark:text-white">{{ $enRiesgoCount }}</span>
                            <span class="block text-[10px] text-gray-500">
                                {{ $totalIndicators > 0 ? number_format(($enRiesgoCount / $totalIndicators) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-rose-50/60 dark:bg-rose-500/10">
                            <span class="block text-theme-xs font-semibold text-rose-700 dark:text-rose-400">🔴 Críticos</span>
                            <span class="text-base font-bold text-gray-800 dark:text-white">{{ $criticosCount }}</span>
                            <span class="block text-[10px] text-gray-500">
                                {{ $totalIndicators > 0 ? number_format(($criticosCount / $totalIndicators) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- BLOQUE 3: TABLA DE ATENCIÓN INMEDIATA      -->
        <!-- ========================================== -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm overflow-hidden">
            
            <!-- Pestañas de Navegación del Bloque -->
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-6 pt-4">
                <div class="flex gap-6">
                    <button @click="activeTab = 'criticos'"
                            :class="activeTab === 'criticos' 
                                ? 'border-[#465fff] text-[#465fff] dark:text-[#465fff] font-semibold' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' "
                            class="pb-3 border-b-2 text-theme-sm transition-colors flex items-center gap-2">
                        <span>🔴 Indicadores Críticos</span>
                        <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400 text-theme-xs">
                            {{ count($criticalIndicators) }}
                        </span>
                    </button>

                    <button @click="activeTab = 'actividad'"
                            :class="activeTab === 'actividad' 
                                ? 'border-[#465fff] text-[#465fff] dark:text-[#465fff] font-semibold' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' "
                            class="pb-3 border-b-2 text-theme-sm transition-colors flex items-center gap-2">
                        <span>⚡ Actividad y Capturas Recientes</span>
                    </button>
                </div>
            </div>

            <!-- CONTENIDO PESTAÑA 1: INDICADORES CRÍTICOS -->
            <div x-show="activeTab === 'criticos'" class="max-w-full overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    <thead class="bg-gray-50/75 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Código</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Indicador Crítico</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Responsable</th>
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Avance / Meta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                        @forelse($criticalIndicators as $indicator)
                            @php
                                $latestVal = $indicator->latestProgress->value ?? 0;
                                $targetVal = $indicator->goals->last()->target_value ?? 1;
                                $pct = $targetVal > 0 ? min(100, round(($latestVal / $targetVal) * 100)) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-rose-600 dark:text-rose-400 text-theme-xs">
                                        {{ $indicator->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-800 dark:text-gray-200 text-theme-sm block">
                                        {{ $indicator->name }}
                                    </span>
                                    <span class="text-[11px] text-gray-400">
                                        Eje {{ $indicator->theme->axis->axis_number ?? '-' }}: {{ trim($indicator->theme->axis->name ?? '') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-theme-xs text-gray-600 dark:text-gray-300">
                                        {{ $indicator->responsibleUser->name ?? 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                            <div class="bg-rose-500 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="text-theme-xs font-bold text-rose-600">
                                            {{ $latestVal }}/{{ (float)$targetVal }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-theme-xs">
                                    No hay indicadores en estado crítico.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- CONTENIDO PESTAÑA 2: ACTIVIDAD RECIENTE -->
            <div x-show="activeTab === 'actividad'" class="p-6">
                <p class="text-theme-xs text-gray-500 text-center py-4">
                    Sin registros recientes de actividad.
                </p>
            </div>

        </div>

    </div>
</div>
@endsection