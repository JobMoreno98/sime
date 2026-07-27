@extends('layouts.app')

@section('content')

<div x-data="{
    activeTab: 'criticos', // 'criticos' | 'actividad'
    selectedEjeChart: 'todos',

    // Datos resumidos para el dashboard
    kpiStats: {
        avanceGlobal: 68.5,
        totalIndicadores: 85,
        enMeta: 52,
        enRiesgo: 25,
        criticos: 8
    },

    // Indicadores críticos para atención inmediata
    indicadoresCriticos: [
        { codigo: 'IND-08', nombre: 'Proyectos de investigación con financiamiento externo', eje: 'Eje 2', ejeColor: '#2563eb', responsable: 'Coordinación de Investigación', avance: 26, meta: 100, unidad: '%' },
        { codigo: 'IND-14', nombre: 'Programas educativos reacreditados internacionalmente', eje: 'Eje 1', ejeColor: '#7c3aed', responsable: 'Secretaría Académica', avance: 1, meta: 5, unidad: 'progs' },
        { codigo: 'IND-22', nombre: 'Tasa de titulación en posgrados doctorales', eje: 'Eje 1', ejeColor: '#7c3aed', responsable: 'Posgrados CUCSH', avance: 33, meta: 80, unidad: '%' },
        { codigo: 'IND-31', nombre: 'Publicaciones en revistas indexadas Scopus/WoS', eje: 'Eje 2', ejeColor: '#2563eb', responsable: 'Centro de Documentación', avance: 12, meta: 45, unidad: 'arts' },
        { codigo: 'IND-45', nombre: 'Infraestructura tecnológica actualizada en aulas', eje: 'Eje 3', ejeColor: '#059669', responsable: 'CTA / Servicios Computacionales', avance: 40, meta: 100, unidad: '%' }
    ],

    // Registro de actividad reciente / capturas
    actividadReciente: [
        { id: 1, usuario: 'Dra. María Elena Ramos', area: 'Secretaría Académica', accion: 'Actualizó avance en', codigo: 'IND-01', tiempo: 'Hace 2 horas', estado: 'Aprobado' },
        { id: 2, usuario: 'Mtro. Carlos Ruiz', area: 'Coordinación de Investigación', accion: 'Registró captura mensual en', codigo: 'IND-05', tiempo: 'Hace 4 horas', estado: 'Pendiente' },
        { id: 3, usuario: 'Dra. Beatriz Solís', area: 'Vinculación Social', accion: 'Adjuntó evidencia a', codigo: 'IND-12', tiempo: 'Ayer, 18:30 hrs', estado: 'Aprobado' },
        { id: 4, usuario: 'Lic. Jorge Mendoza', area: 'Servicios Escolares', accion: 'Modificó la meta de', codigo: 'IND-02', tiempo: 'Ayer, 11:15 hrs', estado: 'En Revisión' }
    ],

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
                    Centro de Mando Institucional
                </h2>
                <p class="text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Plan de Desarrollo CUCSH (2025–2031) — Monitoreo Ejecutivo en Tiempo Real
                </p>
            </div>

            <!-- Accesos Rápidos del Administrador -->
            <div class="flex items-center gap-2.5">
                <button @click="descargarReporte()" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/60 text-theme-xs font-semibold shadow-theme-xs transition-colors">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Reporte Ejecutivo</span>
                </button>

                <button @click="capturarNuevoAvance()" 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-semibold shadow-theme-xs transition-colors">
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
            <div class="relative overflow-hidden rounded-2xl border border-purple-100 bg-gradient-to-br from-purple-500/5 via-white to-white p-5 dark:border-purple-900/30 dark:from-purple-950/20 dark:via-gray-900 dark:to-gray-900 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-semibold tracking-wider text-purple-700 dark:text-purple-400 uppercase">
                        Avance Global del Plan
                    </span>
                    <span class="p-2 rounded-xl bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-gray-900 dark:text-white" x-text="`${kpiStats.avanceGlobal}%`"></span>
                    <span class="text-theme-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center">
                        ↑ 2.4% este mes
                    </span>
                </div>
                <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-purple-600 h-1.5 rounded-full" :style="`width: ${kpiStats.avanceGlobal}%`"></div>
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

            <!-- Card 3: En Meta (🟢 Verde) -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                        En Meta (Buen ritmo)
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
                          x-text="`${Math.round((kpiStats.enMeta / kpiStats.totalIndicadores)*100)}% del total`"></span>
                </div>
            </div>

            <!-- Card 4: Críticos (🔴 Rojo / Atención Urgente) -->
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
                    <span class="text-theme-xs font-medium text-rose-600 dark:text-rose-400">
                        8 indicadores en rojo
                    </span>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- BLOQUE 2: GRÁFICAS DE SALUD DEL PLAN       -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- Gráfica 1: Avance Promedio por Eje Estratégico (8 Cols) -->
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
                        <span class="text-theme-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/30 px-2.5 py-1 rounded-lg">
                            5 Ejes
                        </span>
                    </div>

                    <!-- Barras Personalizadas por Eje -->
                    <div class="space-y-4 my-2">
                        
                        <!-- Eje 1 -->
                        <div @click="irATablaFiltrada('EJE 1')" class="group cursor-pointer">
                            <div class="flex items-center justify-between text-theme-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-purple-600 transition-colors">
                                    Eje 1. Formación Académica Integral
                                </span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">78%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-3 rounded-full overflow-hidden">
                                <div class="bg-purple-600 h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: 78%"></div>
                            </div>
                        </div>

                        <!-- Eje 2 -->
                        <div @click="irATablaFiltrada('EJE 2')" class="group cursor-pointer">
                            <div class="flex items-center justify-between text-theme-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 transition-colors">
                                    Eje 2. Investigación y Posgrado
                                </span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">62%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-3 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: 62%"></div>
                            </div>
                        </div>

                        <!-- Eje 3 -->
                        <div @click="irATablaFiltrada('EJE 3')" class="group cursor-pointer">
                            <div class="flex items-center justify-between text-theme-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-emerald-600 transition-colors">
                                    Eje 3. Vinculación y Extensión
                                </span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">41%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-3 rounded-full overflow-hidden">
                                <div class="bg-emerald-600 h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: 41%"></div>
                            </div>
                        </div>

                        <!-- Eje 4 -->
                        <div @click="irATablaFiltrada('EJE 4')" class="group cursor-pointer">
                            <div class="flex items-center justify-between text-theme-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-amber-600 transition-colors">
                                    Eje 4. Cultura y Comunidad CUCSH
                                </span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">85%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-3 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: 85%"></div>
                            </div>
                        </div>

                        <!-- Eje 5 -->
                        <div @click="irATablaFiltrada('EJE 5')" class="group cursor-pointer">
                            <div class="flex items-center justify-between text-theme-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-rose-600 transition-colors">
                                    Eje 5. Gestión e Infraestructura
                                </span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">55%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-3 rounded-full overflow-hidden">
                                <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500 group-hover:brightness-110" style="width: 55%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-theme-xs text-gray-500">
                    <span>⚠️ Eje 3 requiere revisión por bajo rendimiento relativo</span>
                    <a href="#" class="text-purple-600 dark:text-purple-400 font-semibold hover:underline">Ver desglose →</a>
                </div>
            </div>

            <!-- Gráfica 2: Distribución del Semáforo (5 Cols) -->
            <div class="lg:col-span-5 rounded-2xl border border-gray-200 bg-white p-6 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-1">
                        Distribución de Estatus
                    </h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400 mb-6">
                        Salud general de los 85 indicadores
                    </p>

                    <!-- Simulación de Gráfica de Dona Visual -->
                    <div class="relative flex items-center justify-center my-4">
                        <div class="w-44 h-44 rounded-full border-[14px] border-emerald-500 border-t-amber-500 border-r-rose-500 flex items-center justify-center">
                            <div class="text-center">
                                <span class="text-2xl font-extrabold text-gray-900 dark:text-white">85</span>
                                <span class="block text-theme-xs text-gray-500 dark:text-gray-400 font-medium">Indicadores</span>
                            </div>
                        </div>
                    </div>

                    <!-- Leyenda del Semáforo -->
                    <div class="grid grid-cols-3 gap-2 text-center pt-4">
                        <div class="p-2.5 rounded-xl bg-emerald-50/60 dark:bg-emerald-500/10">
                            <span class="block text-theme-xs font-semibold text-emerald-700 dark:text-emerald-400">🟢 En Meta</span>
                            <span class="text-base font-bold text-gray-800 dark:text-white">52</span>
                            <span class="block text-[10px] text-gray-500">61.2%</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-amber-50/60 dark:bg-amber-500/10">
                            <span class="block text-theme-xs font-semibold text-amber-700 dark:text-amber-400">🟡 En Riesgo</span>
                            <span class="text-base font-bold text-gray-800 dark:text-white">25</span>
                            <span class="block text-[10px] text-gray-500">29.4%</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-rose-50/60 dark:bg-rose-500/10">
                            <span class="block text-theme-xs font-semibold text-rose-700 dark:text-rose-400">🔴 Críticos</span>
                            <span class="text-base font-bold text-gray-800 dark:text-white">8</span>
                            <span class="block text-[10px] text-gray-500">9.4%</span>
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
                                ? 'border-purple-600 text-purple-700 dark:text-purple-400 font-semibold' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' "
                            class="pb-3 border-b-2 text-theme-sm transition-colors flex items-center gap-2">
                        <span>🔴 Indicadores Críticos</span>
                        <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400 text-theme-xs" x-text="indicadoresCriticos.length"></span>
                    </button>

                    <button @click="activeTab = 'actividad'"
                            :class="activeTab === 'actividad' 
                                ? 'border-purple-600 text-purple-700 dark:text-purple-400 font-semibold' 
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
                            <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Avance Actual</th>
                            <th class="px-6 py-3 text-end text-theme-xs font-medium text-gray-500">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                        <template x-for="item in indicadoresCriticos" :key="item.codigo">
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-rose-600 dark:text-rose-400 text-theme-xs" x-text="item.codigo"></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-800 dark:text-gray-200 text-theme-sm block" x-text="item.nombre"></span>
                                    <span class="text-[11px] text-gray-400" x-text="item.eje"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-theme-xs text-gray-600 dark:text-gray-300" x-text="item.responsable"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                            <div class="bg-rose-500 h-2 rounded-full" :style="`width: ${(item.avance / item.meta)*100}%`"></div>
                                        </div>
                                        <span class="text-theme-xs font-bold text-rose-600" x-text="`${item.avance}/${item.meta}`"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-end whitespace-nowrap">
                                    <button class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 text-theme-xs font-medium transition-colors">
                                        Solicitar Revisión
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- CONTENIDO PESTAÑA 2: ACTIVIDAD RECIENTE -->
            <div x-show="activeTab === 'actividad'" class="p-6">
                <div class="space-y-4">
                    <template x-for="act in actividadReciente" :key="act.id">
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 flex items-center justify-center font-bold text-theme-xs">
                                    <span x-text="act.usuario.substring(0,2).toUpperCase()"></span>
                                </div>
                                <div>
                                    <p class="text-theme-xs text-gray-800 dark:text-gray-200">
                                        <strong x-text="act.usuario"></strong> (<span x-text="act.area"></span>) <span x-text="act.accion"></span> <span class="font-semibold text-purple-600" x-text="act.codigo"></span>
                                    </p>
                                    <span class="text-[11px] text-gray-400" x-text="act.tiempo"></span>
                                </div>
                            </div>

                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                  :class="{
                                      'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400': act.estado === 'Aprobado',
                                      'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400': act.estado === 'Pendiente',
                                      'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400': act.estado === 'En Revisión'
                                  }"
                                  x-text="act.estado">
                            </span>
                        </div>
                    </template>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
