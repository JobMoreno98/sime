@extends('layouts.app')


@php
    $title = 'Indicadores de Gestión ';
@endphp

@section('content')
    <div x-data="indicadoresController">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 shadow-sm">

            <div class="flex flex-col gap-4 px-6 mb-5">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Indicadores de Gestión (KPIs)</h3>
                        <p class="text-theme-xs text-gray-500">
                            Mostrando <span class="font-semibold text-gray-700" x-text="filteredRows.length"></span>
                            indicadores.
                        </p>
                    </div>
                    <button @click="crearNuevoIndicador()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-semibold shadow-theme-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nuevo Indicador</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-2">
                    <div class="relative">
                        <input type="text" x-model="searchQuery" placeholder="Buscar por código o nombre..."
                            class="w-full rounded-lg border border-gray-300 bg-white pl-4 pr-4 py-2 text-theme-xs text-gray-700 placeholder-gray-400 shadow-theme-xs focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                    </div>

                    <div class="relative">
                        <select x-model="selectedTematica"
                            class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 shadow-theme-xs focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                            <option value="todas">Todas las Temáticas</option>
                            @foreach ($tematicas as $tematica)
                                <option value="{{ $tematica->code }}">{{ $tematica->code }} {{ $tematica->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="max-w-full overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    <thead class="border-y border-gray-100 bg-gray-50/75">
                        <tr>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Código</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Nombre del Indicador
                            </th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-center">Temática</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Responsable</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-end">Meta (Corto Plazo)</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-end">Acciones</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-start">Avance / Cumplimiento
                            </th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-theme-xs text-center">Estatus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="row in filteredRows" :key="row.code">
                            <tr class="hover:bg-gray-50/60 transition-colors"
                                :style="`border-left: 5px solid ${row.theme?.axis?.color ?? '#a855f7'};`">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-purple-700 text-theme-sm" x-text="row.code" :style="`color:${row.theme?.axis?.color ?? '#a855f7'};`"></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-800 text-theme-sm block" x-text="row.name"></span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center justify-center h-7 px-3 rounded-full bg-gray-100 text-gray-700 text-theme-xs font-semibold"
                                        x-text="row.theme_code"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-theme-xs text-gray-600"
                                        x-text="row.responsible_user?.name ?? 'Sin asignar'"></span>
                                </td>
                                <td class="px-6 py-4 text-end whitespace-nowrap">
                                    <span class="font-semibold text-gray-800 text-theme-sm"
                                        x-text="`${row.short_term_goal?.target_value ?? '—'} ${row.measurement_unit ?? ''}`"></span>
                                </td>
                                <td class="px-6 py-4 text-end whitespace-nowrap">

                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Botón Ver Indicador -->
                                        <a :href="'{{ route('indicadores.show', ':indicador') }}'.replace(':indicador', row.code)"
                                            title="Ver detalle del indicador"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-teal-600 hover:bg-teal-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Botón Capturar Avance -->
                                        <button type="button" @click="capturarAvance(row)" title="Capturar avance"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-medium transition-colors shadow-theme-xs">
                                            <span>Capturar</span>
                                        </button>

                                        <!-- Botón Editar -->
                                        <button type="button" @click="editarIndicador(row)" title="Editar indicador"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <button type="button" @click="eliminarIndicador(row)" title="Eliminar indicador"
                                            class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 min-w-[200px]">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between text-theme-xs">
                                            <span class="font-semibold text-gray-500"
                                                x-text="row.cumplimiento !== null ? `${Number(row.cumplimiento).toFixed(2)}%` : '—'"></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div class="h-2 rounded-full transition-all duration-300"
                                                :class="getProgressBarColor(row.estatus)"
                                                :style="`width: ${row.cumplimiento ?? 0}%`"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-theme-xs font-semibold border"
                                        :class="getSemaforoBadge(row.estatus)">
                                        <span x-text="row.estatus"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <x-indicadores.modal :tematicas="$tematicas" :usuarios="$usuarios" />

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('indicadoresController', () => ({
                    searchQuery: '',
                    selectedTematica: 'todas',
                    tableRowData: @json($indicadores),
                    showModal: false,
                    isEditing: false,
                    modalMode: 'config',
                    form: {
                        id: '',
                        code: '',
                        name: '',
                        theme_code: '',
                        measurement_unit: '',
                        measurement_frequency: '',
                        responsible_user_id: '',
                        short_term_goal: ''
                    },
                    progressForm: {
                        year: new Date().getFullYear(),
                        period_sub: '',
                        actual_value: '',
                        notes: ''
                    },

                    get filteredRows() {
                        return this.tableRowData.filter(row => {
                            const q = this.searchQuery.toLowerCase();
                            const matchesSearch = row.code.toLowerCase().includes(q) || row.name
                                .toLowerCase().includes(q);
                            const matchesTematica = this.selectedTematica === 'todas' || row
                                .theme_code === this.selectedTematica;
                            return matchesSearch && matchesTematica;
                        });
                    },

                    get editUrl() {
                        return this.form.id ?
                            '{{ route('indicadores.update', ':id') }}'.replace(':id', this.form
                                .id) :
                            '';
                    },

                    get progressUrl() {
                        return this.form.code ?
                            '{{ route('indicadores.avance', ':code') }}'.replace(':code', this.form
                                .code) :
                            '';
                    },

                    getSemaforoBadge(estatus) {
                        switch (estatus) {
                            case 'En Meta':
                                return 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            case 'En Riesgo':
                                return 'bg-amber-50 text-amber-700 border-amber-200';
                            case 'Crítico':
                                return 'bg-rose-50 text-rose-700 border-rose-200';
                            default:
                                return 'bg-gray-50 text-gray-700 border-gray-200';
                        }
                    },

                    getProgressBarColor(estatus) {
                        switch (estatus) {
                            case 'En Meta':
                                return 'bg-emerald-500';
                            case 'En Riesgo':
                                return 'bg-amber-500';
                            case 'Crítico':
                                return 'bg-rose-500';
                            default:
                                return 'bg-gray-300';
                        }
                    },

                    crearNuevoIndicador() {
                        this.modalMode = 'config';
                        this.isEditing = false;
                        this.form = {
                            code: '',
                            name: '',
                            theme_code: '',
                            measurement_unit: '',
                            measurement_frequency: '',
                            responsible_user_id: '',
                            short_term_goal: ''
                        };
                        this.showModal = true;
                    },

                    editarIndicador(row) {
                        this.modalMode = 'config';
                        this.isEditing = true;
                        this.form = {
                            id: row.id,
                            code: row.code,
                            name: row.name || '',
                            theme_code: row.theme_code || '',
                            measurement_unit: row.measurement_unit || '',
                            measurement_frequency: row.measurement_frequency || '',
                            responsible_user_id: row.responsible_user_id || '',
                            short_term_goal: row.short_term_goal?.target_value ?? ''
                        };
                        this.showModal = true;
                    },

                    capturarAvance(row) {
                        this.modalMode = 'progress';
                        this.form = {
                            code: row.code,
                            name: row.name,
                            short_term_goal: row.short_term_goal?.target_value ?? '—',
                            measurement_unit: row.measurement_unit
                        };
                        this.progressForm = {
                            year: new Date().getFullYear(),
                            period_sub: '',
                            actual_value: '',
                            notes: ''
                        };
                        this.showModal = true;
                    },

                    eliminarIndicador(indicador) {
                        if (!confirm(
                                `¿Estás seguro de que deseas eliminar el indicador "${indicador.code} - ${indicador.name}"?`
                            )) {
                            return;
                        }

                        const form = document.createElement('form');
                        form.method = 'POST';
                        // Usa el comodín ':indicador' asignado por la ruta resource
                        form.action = '{{ route('indicadores.destroy', ':indicador') }}'.replace(
                            ':indicador', indicador.code);

                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    },

                    closeModal() {
                        this.showModal = false;
                    }
                }));
            });
        </script>
    </div>
@endsection
