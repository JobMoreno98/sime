@extends('layouts.app')

@section('content')

<div x-data="{
    searchQuery: '',
    selectedEje: 'todos',
    selectedTematica: 'todas',
    selectedEstatus: 'todos',
    
    tableRowData: [
        {
            codigo: 'IND-01',
            nombre: 'Eficiencia terminal en Licenciatura',
            tematicaCodigo: '1.1',
            ejeCodigo: 'EJE 1',
            ejeColor: '#7c3aed', // Morado
            meta: 85,
            avance: 72,
            unidad: '%',
            estatus: 'En Meta', // 'En Meta', 'En Riesgo', 'Crítico'
            tipoResponsable: 'user'
        },
        {
            codigo: 'IND-02',
            nombre: 'Matrícula de nuevo ingreso en Posgrados',
            tematicaCodigo: '1.2',
            ejeCodigo: 'EJE 1',
            ejeColor: '#7c3aed',
            meta: 450,
            avance: 420,
            unidad: 'alumnos',
            estatus: 'En Meta',
            tipoResponsable: 'building'
        },
        {
            codigo: 'IND-05',
            nombre: 'Profesores pertenecientes al SNII',
            tematicaCodigo: '2.1',
            ejeCodigo: 'EJE 2',
            ejeColor: '#2563eb', // Azul
            meta: 120,
            avance: 95,
            unidad: 'profesores',
            estatus: 'En Riesgo',
            tipoResponsable: 'user'
        },
        {
            codigo: 'IND-08',
            nombre: 'Proyectos de investigación con financiamiento externo',
            tematicaCodigo: '2.2',
            ejeCodigo: 'EJE 2',
            ejeColor: '#2563eb',
            meta: 15,
            avance: 4,
            unidad: 'proyectos',
            estatus: 'Crítico',
            tipoResponsable: 'building'
        },
        {
            codigo: 'IND-12',
            nombre: 'Convenios activos de vinculación comunitaria',
            tematicaCodigo: '3.1',
            ejeCodigo: 'EJE 3',
            ejeColor: '#059669', // Esmeralda
            meta: 30,
            avance: 28,
            unidad: 'convenios',
            estatus: 'En Meta',
            tipoResponsable: 'building'
        }
    ],

    // Cálculo del porcentaje de cumplimiento respecto a la meta
    getCumplimiento(avance, meta) {
        if (!meta || meta === 0) return 0;
        const pct = Math.round((avance / meta) * 100);
        return pct > 100 ? 100 : pct;
    },

    // Color del semáforo visual según estatus
    getSemaforoBadge(estatus) {
        switch(estatus) {
            case 'En Meta':
                return 'bg-emerald-50 text-emerald-700 border-emerald-200';
            case 'En Riesgo':
                return 'bg-amber-50 text-amber-700 border-amber-200';
            case 'Crítico':
                return 'bg-rose-50 text-rose-700 border-rose-200';
            default:
                return 'bg-gray-50 text-gray-700';
        }
    },

    getProgressBarColor(estatus) {
        switch(estatus) {
            case 'En Meta': return 'bg-emerald-500';
            case 'En Riesgo': return 'bg-amber-500';
            case 'Crítico': return 'bg-rose-500';
            default: return 'bg-blue-600';
        }
    },

    // Filtrado combinado en tiempo real (Buscador + Eje + Temática + Estatus)
    get filteredRows() {
        return this.tableRowData.filter(row => {
            const matchesSearch = row.codigo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                  row.nombre.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesEje = this.selectedEje === 'todos' || row.ejeCodigo === this.selectedEje;
            const matchesTematica = this.selectedTematica === 'todas' || row.tematicaCodigo === this.selectedTematica;
            const matchesEstatus = this.selectedEstatus === 'todos' || row.estatus === this.selectedEstatus;

            return matchesSearch && matchesEje && matchesTematica && matchesEstatus;
        });
    },

    capturarAvance(row) { console.log('Capturar avance en:', row.codigo); },
    editarIndicador(row) { console.log('Editar indicador:', row.codigo); },
    masAcciones(row) { console.log('Más acciones:', row.codigo); }
}">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 shadow-sm">
        
        <!-- Header con Buscador y Filtros Multinivel -->
        <div class="flex flex-col gap-4 px-6 mb-5">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Indicadores de Gestión (KPIs)
                    </h3>
                    <p class="text-theme-xs text-gray-500">
                        Centro de capturas y seguimiento operativo. Mostrando <span class="font-semibold text-gray-700" x-text="filteredRows.length"></span> indicadores.
                    </p>
                </div>
            </div>

            <!-- Barra de Herramientas: Buscador + Selectores -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-2">
                
                <!-- Buscador -->
                <div class="relative">
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" 
                           x-model="searchQuery"
                           placeholder="Buscar por código o nombre..." 
                           class="w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 py-2 text-theme-xs text-gray-700 placeholder-gray-400 shadow-theme-xs focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                </div>

                <!-- Filtro por Eje -->
                <div class="relative">
                    <select x-model="selectedEje" 
                            class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 shadow-theme-xs focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                        <option value="todos">Todos los Ejes</option>
                        <option value="EJE 1">Eje 1. Formación de calidad</option>
                        <option value="EJE 2">Eje 2. Generación de conocimiento</option>
                        <option value="EJE 3">Eje 3. Vinculación Social</option>
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </div>

                <!-- Filtro por Temática -->
                <div class="relative">
                    <select x-model="selectedTematica" 
                            class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 shadow-theme-xs focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                        <option value="todas">Todas las Temáticas</option>
                        <option value="1.1">1.1 Educación para todos</option>
                        <option value="1.2">1.2 Inclusión y Equidad</option>
                        <option value="2.1">2.1 Investigar para transformar</option>
                        <option value="2.2">2.2 Divulgación Científica</option>
                        <option value="3.1">3.1 Impacto Comunitario</option>
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </div>

                <!-- Filtro por Semáforo/Estatus -->
                <div class="relative">
                    <select x-model="selectedEstatus" 
                            class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 shadow-theme-xs focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                        <option value="todos">Todos los Estatus</option>
                        <option value="En Meta">🟢 En Meta</option>
                        <option value="En Riesgo">🟡 En Riesgo</option>
                        <option value="Crítico">🔴 Crítico</option>
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
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
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Nombre del Indicador</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-center">Temática</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-end">Meta</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Avance / Cumplimiento</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-center">Estatus</th>
                        <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="row in filteredRows" :key="row.codigo">
                        <tr class="hover:bg-gray-50/60 transition-colors"
                            :style="`border-left: 4px solid ${row.ejeColor};`">
                            
                            <!-- 1. Código del Indicador (Morado Institucional) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-purple-700 text-theme-sm" x-text="row.codigo"></span>
                            </td>

                            <!-- 2. Nombre del Indicador -->
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800 text-theme-sm block" x-text="row.nombre"></span>
                            </td>

                            <!-- 3. Temática (Badge Pill) -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center justify-center h-7 px-3 rounded-full bg-gray-100 text-gray-700 text-theme-xs font-semibold"
                                      x-text="row.tematicaCodigo"></span>
                            </td>

                            <!-- 4. Meta -->
                            <td class="px-6 py-4 text-end whitespace-nowrap">
                                <span class="font-semibold text-gray-800 text-theme-sm" x-text="`${row.meta} ${row.unidad}`"></span>
                            </td>

                            <!-- 5. Avance y Barra de Cumplimiento -->
                            <td class="px-6 py-4 min-w-[200px]">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center justify-between text-theme-xs">
                                        <span class="font-medium text-gray-700" x-text="`${row.avance} ${row.unidad}`"></span>
                                        <span class="font-semibold text-gray-500" x-text="`${getCumplimiento(row.avance, row.meta)}%`"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full transition-all duration-300"
                                             :class="getProgressBarColor(row.estatus)"
                                             :style="`width: ${getCumplimiento(row.avance, row.meta)}%`">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- 6. Estatus / Semáforo -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-theme-xs font-semibold border"
                                      :class="getSemaforoBadge(row.estatus)">
                                    <span class="w-1.5 h-1.5 rounded-full" 
                                          :class="{
                                              'bg-emerald-500': row.estatus === 'En Meta',
                                              'bg-amber-500': row.estatus === 'En Riesgo',
                                              'bg-rose-500': row.estatus === 'Crítico'
                                          }"></span>
                                    <span x-text="row.estatus"></span>
                                </span>
                            </td>

                            <!-- 7. Acciones Operativas -->
                            <td class="px-6 py-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Botón Principal: Capturar Avance -->
                                    <button @click="capturarAvance(row)" 
                                            title="Capturar avance"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-medium transition-colors shadow-theme-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Capturar</span>
                                    </button>

                                    <!-- Editar Configuración (Pencil) -->
                                    <button @click="editarIndicador(row)" 
                                            title="Editar indicador"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </button>

                                    <!-- Más Opciones -->
                                    <button @click="masAcciones(row)" 
                                            title="Más acciones"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
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
