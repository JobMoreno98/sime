@extends('layouts.app')

@section('content')
<div x-data="{
    tableRowData: [
        {
            codigo: 'EJE 1',
            nombre: 'Formación de calidad',
            responsable: 'Secretaría Académica',
            tipoResponsable: 'user', // 'user' o 'building'
            tematicas: 5,
            indicadores: 18,
            porcentaje: 85,
            colorEje: '#7c3aed' // Color institucional para el border-left (ej. Violeta)
        },
        {
            codigo: 'EJE 2',
            nombre: 'Generación de conocimiento',
            responsable: 'Secretaría de Investigación',
            tipoResponsable: 'building',
            tematicas: 3,
            indicadores: 12,
            porcentaje: 65,
            colorEje: '#2563eb' // Azul
        },
        {
            codigo: 'EJE 3',
            nombre: 'Vinculación Social',
            responsable: 'Dirección de Extensión',
            tipoResponsable: 'building',
            tematicas: 4,
            indicadores: 10,
            porcentaje: 45,
            colorEje: '#059669' // Esmeralda
        },
        {
            codigo: 'EJE 4',
            nombre: 'Gestión Institucional',
            responsable: 'Coordinación General',
            tipoResponsable: 'user',
            tematicas: 2,
            indicadores: 8,
            porcentaje: 30,
            colorEje: '#dc2626' // Rojo
        }
    ],
    // Lógica dinámica para el color de la barra de progreso
    getProgressBarColor(pct) {
        if (pct >= 80) return 'bg-emerald-500'; // 🟢 Verde (80-100%)
        if (pct >= 60) return 'bg-blue-600';    // 🔵 Azul (60-79%)
        if (pct >= 40) return 'bg-amber-500';   // 🟡 Amarillo (40-59%)
        return 'bg-rose-500';                   // 🔴 Rojo (<40%)
    },
    verTematicas(row) { console.log('Ver temáticas:', row.codigo); },
    editarEje(row) { console.log('Editar eje:', row.codigo); },
    masAcciones(row) { console.log('Más acciones:', row.codigo); }
}">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-white/[0.05] dark:bg-white/[0.03] shadow-sm">
        <!-- Encabezado -->
        <div class="flex flex-col gap-4 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Ejes Estratégicos SIME
                </h3>
            </div>
        </div>

        <!-- Tabla -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full text-start border-collapse">
                <thead class="border-y border-gray-100 bg-gray-50/75 dark:border-white/[0.05] dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-start">Código</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-start">Nombre del Eje</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-start">Responsable Principal</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-center">Temáticas</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-center">Indicadores</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-start">Estado General</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    <template x-for="row in tableRowData" :key="row.codigo">
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors"
                            :style="`border-left: 4px solid ${row.colorEje};`">
                            
                            <!-- 1. Código con morado institucional -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-purple-700 dark:text-purple-400 text-theme-sm" x-text="row.codigo"></span>
                            </td>

                            <!-- 2. Nombre del Eje -->
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800 text-theme-sm dark:text-gray-200" x-text="row.nombre"></span>
                            </td>

                            <!-- 3. Responsable con Ícono SVG -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 text-theme-sm">
                                    <!-- Ícono Usuario -->
                                    <template x-if="row.tipoResponsable === 'user'">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </template>
                                    <!-- Ícono Edificio / Organización -->
                                    <template x-if="row.tipoResponsable === 'building'">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m0 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-14 0v-2a1 1 0 011-1h2a1 1 0 011 1v2" />
                                        </svg>
                                    </template>
                                    <span x-text="row.responsable"></span>
                                </div>
                            </td>

                            <!-- 4. Temáticas (Badge Pill Gris) -->
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-theme-xs font-semibold"
                                      x-text="row.tematicas"></span>
                            </td>

                            <!-- 5. Indicadores (Badge Pill Gris) -->
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-theme-xs font-semibold"
                                      x-text="row.indicadores"></span>
                            </td>

                            <!-- 6. Estado General con barra inteligente -->
                            <td class="px-6 py-4 min-w-[170px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700 overflow-hidden">
                                        <div class="h-2 rounded-full transition-all duration-300"
                                             :class="getProgressBarColor(row.porcentaje)"
                                             :style="`width: ${row.porcentaje}%`">
                                        </div>
                                    </div>
                                    <span class="text-theme-xs font-semibold text-gray-700 dark:text-gray-300 min-w-[36px]" x-text="`${row.porcentaje}%`"></span>
                                </div>
                            </td>

                            <!-- 7. Botones de Acción con Íconos UI -->
                            <td class="px-6 py-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- Ver Temáticas (Eye) -->
                                    <button @click="verTematicas(row)" 
                                            title="Ver temáticas"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-500/10 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Editar (Pencil Square) -->
                                    <button @click="editarEje(row)" 
                                            title="Editar eje"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 dark:text-gray-400 dark:hover:text-amber-400 dark:hover:bg-amber-500/10 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Más Acciones (Ellipsis Horizontal) -->
                                    <button @click="masAcciones(row)" 
                                            title="Más acciones"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
