@extends('layouts.app')

@section('content')

<div x-data="{
    // Búsqueda y Filtros
    search: '',
    
    // Acciones rápidas AlpineJS
    verDetalle(ejeId) {
        console.log('Navegando al detalle del Eje:', ejeId);
        window.location.href = `/ejes/${ejeId}`;
    },

    editarEje(ejeId) {
        console.log('Editando Eje:', ejeId);
    },

    crearNuevoEje() {
        console.log('Abriendo modal para nuevo Eje Estratégico...');
    }
}">

    <div class="space-y-6">

        <!-- ========================================== -->
        <!-- HEADER DE LA SECCIÓN                      -->
        <!-- ========================================== -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    Ejes Estratégicos SIME
                </h2>
                <p class="text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Plan de Desarrollo 2025–2031 — Desglose de Ejes, Responsables y Progreso General
                </p>
            </div>

            <!-- Botón de acción rápido opcional -->
            <div class="flex items-center gap-2.5">
                <button @click="crearNuevoEje()" 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-semibold shadow-theme-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nuevo Eje</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TABLA PRINCIPAL DE EJES ESTRATÉGICOS       -->
        <!-- ========================================== -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm overflow-hidden">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    
                    <!-- ENCABEZADO DE TABLA -->
                    <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500 dark:text-gray-400">Código</th>
                            <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nombre del Eje</th>
                            <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500 dark:text-gray-400">Responsable Principal</th>
                            <th class="px-6 py-4 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Temáticas</th>
                            <th class="px-6 py-4 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Indicadores</th>
                            <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500 dark:text-gray-400">Estado General</th>
                            <th class="px-6 py-4 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Acciones</th>
                        </tr>
                    </thead>

                    <!-- CUERPO DE TABLA DINÁMICO -->
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                        @forelse($axes as $axis)
                            @php
                                $percentage = $axis->progress_percentage ?? 0;
                                
                                // Determinar color de barra/borde dinámicamente según avance
                                if ($percentage >= 75) {
                                    $colorClass = 'bg-emerald-500';
                                    $borderClass = 'border-l-purple-600'; // Color distintivo lateral de la fila
                                } elseif ($percentage >= 50) {
                                    $colorClass = 'bg-blue-600';
                                    $borderClass = 'border-l-blue-600';
                                } elseif ($percentage >= 35) {
                                    $colorClass = 'bg-amber-500';
                                    $borderClass = 'border-l-amber-500';
                                } else {
                                    $colorClass = 'bg-rose-500';
                                    $borderClass = 'border-l-rose-500';
                                }
                            @endphp

                            <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors border-l-4 {{ $borderClass }}">
                                
                                <!-- Código (EJE 1, EJE 2, etc.) -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="font-bold text-purple-600 dark:text-purple-400 text-theme-xs tracking-wider uppercase">
                                        {{ $axis->code ?? 'EJE ' . $axis->axis_number }}
                                    </span>
                                </td>

                                <!-- Nombre del Eje -->
                                <td class="px-6 py-5 max-w-xs">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200 text-theme-sm block leading-snug">
                                        {{ $axis->name }}
                                    </span>
                                </td>

                                <!-- Responsable Principal -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5 text-gray-600 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-theme-xs font-medium">
                                            {{ $axis->responsible_unit ?? $axis->responsibleUser->name ?? 'Sin Asignar' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Temáticas (Contador redondeado) -->
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-theme-xs font-bold">
                                        {{ $axis->themes_count ?? $axis->themes->count() ?? 0 }}
                                    </span>
                                </td>

                                <!-- Indicadores (Contador redondeado) -->
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-7 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-theme-xs font-bold">
                                        {{ $axis->indicators_count ?? 0 }}
                                    </span>
                                </td>

                                <!-- Estado General (Barra + Porcentaje) -->
                                <td class="px-6 py-5 whitespace-nowrap min-w-[180px]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-28 bg-gray-100 dark:bg-gray-800 h-2.5 rounded-full overflow-hidden">
                                            <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-theme-xs font-bold text-gray-700 dark:text-gray-300">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                </td>

                                <!-- Acciones (Ver, Editar, Opciones) -->
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2 text-gray-500">
                                        <!-- Ver Detalle -->
                                        <button @click="verDetalle({{ $axis->id }})" 
                                                title="Ver Detalle" 
                                                class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-purple-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>

                                        <!-- Editar -->
                                        <button @click="editarEje({{ $axis->id }})" 
                                                title="Editar Eje" 
                                                class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-purple-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>

                                        <!-- Menú opciones extras -->
                                        <button title="Más opciones" 
                                                class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-purple-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-theme-sm">
                                    No se encontraron ejes estratégicos registrados.
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