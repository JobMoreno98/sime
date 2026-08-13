@extends('layouts.app')

@section('content')

<div x-data="{
    selectedEje: 'todos',
    tableRowData: [
        {
            codigo: '1.1',
            nombre: 'Educación para todos',
            ejeCodigo: 'EJE 1',
            ejeNombre: 'Formación de calidad',
            ejeColor: '#7c3aed', // Morado
            indicadores: 4
        },
        {
            codigo: '1.2',
            nombre: 'Inclusión y Equidad Educativa',
            ejeCodigo: 'EJE 1',
            ejeNombre: 'Formación de calidad',
            ejeColor: '#7c3aed',
            indicadores: 3
        },
        {
            codigo: '2.1',
            nombre: 'Investigar para transformar',
            ejeCodigo: 'EJE 2',
            ejeNombre: 'Generación de conocimiento',
            ejeColor: '#2563eb', // Azul
            indicadores: 6
        },
        {
            codigo: '2.2',
            nombre: 'Divulgación Científica y Tecnológica',
            ejeCodigo: 'EJE 2',
            ejeNombre: 'Generación de conocimiento',
            ejeColor: '#2563eb',
            indicadores: 5
        },
        {
            codigo: '3.1',
            nombre: 'Impacto Comunitario y Social',
            ejeCodigo: 'EJE 3',
            ejeNombre: 'Vinculación Social',
            ejeColor: '#059669', // Esmeralda
            indicadores: 2
        }
    ],
    // Filtrado automático de filas por Eje
    get filteredRows() {
        if (this.selectedEje === 'todos') {
            return this.tableRowData;
        }
        return this.tableRowData.filter(row => row.ejeCodigo === this.selectedEje);
    },
    verIndicadores(row) { console.log('Ver indicadores de:', row.codigo); },
    editarTematica(row) { console.log('Editar temática:', row.codigo); },
    masAcciones(row) { console.log('Más acciones:', row.codigo); }
}">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 shadow-sm">
        <!-- Encabezado con Filtro Integrado -->
        <div class="flex flex-col gap-4 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Temáticas Transversales
                </h3>
                <p class="text-theme-xs text-gray-500 mt-0.5">
                    Mostrando <span class="font-semibold text-gray-700" x-text="filteredRows.length"></span> temáticas asociadas
                </p>
            </div>

            <!-- Control de Filtro -->
            <div class="flex items-center gap-3">
                <label for="filtroEje" class="text-theme-xs font-medium text-gray-600 whitespace-nowrap">
                    Filtrar por Eje:
                </label>
                <div class="relative">
                    <select id="filtroEje" 
                            x-model="selectedEje"
                            class="appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:border-gray-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                        <option value="todos">Todos los Ejes</option>
                        <option value="EJE 1">Eje 1. Formación de calidad</option>
                        <option value="EJE 2">Eje 2. Generación de conocimiento</option>
                        <option value="EJE 3">Eje 3. Vinculación Social</option>
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full text-start border-collapse">
                <thead class="border-y border-gray-100 bg-gray-50/75">
                    <tr>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Código</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Temática Transversal</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Eje Perteneciente</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-center">Indicadores</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="row in filteredRows" :key="row.codigo">
                        <tr class="hover:bg-gray-50/60 transition-colors"
                            :style="`border-left: 4px solid ${row.ejeColor};`">
                            
                            <!-- 1. Código Temática (Morado Institucional) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-purple-700 text-theme-sm" x-text="row.codigo"></span>
                            </td>

                            <!-- 2. Nombre de la Temática -->
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800 text-theme-sm" x-text="row.nombre"></span>
                            </td>

                            <!-- 3. Eje Perteneciente (Badge con indicador visual del Eje) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-gray-100">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0" :style="`background-color: ${row.ejeColor}`"></span>
                                    <span class="font-semibold text-gray-700 text-theme-xs" x-text="row.ejeCodigo"></span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-600 text-theme-xs" x-text="row.ejeNombre"></span>
                                </div>
                            </td>

                            <!-- 4. Indicadores (KPI Badge Pill) -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 justify-center h-7 px-3 rounded-full bg-purple-50 text-purple-700 text-theme-xs font-semibold">
                                    <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span x-text="`${row.indicadores} KPIs`"></span>
                                </span>
                            </td>

                            <!-- 5. Acciones (Ver Indicadores / Editar / Más) -->
                            <td class="px-6 py-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- Ver Indicadores (Eye) -->
                                    <button @click="verIndicadores(row)" 
                                            title="Ver indicadores"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Editar (Pencil Square) -->
                                    <button @click="editarTematica(row)" 
                                            title="Editar temática"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Más Acciones (Ellipsis) -->
                                    <button @click="masAcciones(row)" 
                                            title="Más acciones"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
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
