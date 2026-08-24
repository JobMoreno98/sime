@extends('layouts.app')

@section('content')

<div x-data="tematicasController">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 shadow-sm">

        <div class="flex flex-col gap-4 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Temáticas Transversales</h3>
                <p class="text-theme-xs text-gray-500 mt-0.5">
                    Mostrando <span class="font-semibold text-gray-700" x-text="filteredRows.length"></span> temáticas asociadas
                </p>
            </div>

            <div class="flex items-center gap-3">
                <label for="filtroEje" class="text-theme-xs font-medium text-gray-600 whitespace-nowrap">
                    Filtrar por Eje:
                </label>
                <div class="relative">
                    <select id="filtroEje" x-model="selectedEje"
                        class="appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:border-gray-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                        <option value="todos">Todos los Ejes</option>
                        @foreach ($ejes as $eje)
                            <option value="{{ $eje->id }}">{{ $eje->code ?? 'EJE ' . $eje->axis_number }}. {{ $eje->name }}</option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>

                <button @click="crearNuevaTematica()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-semibold shadow-theme-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Nueva Temática</span>
                </button>
            </div>
        </div>

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
                    <template x-for="row in filteredRows" :key="row.id">
                        <tr class="hover:bg-gray-50/60 transition-colors"
                            :style="`border-left: 4px solid ${row.axis?.color ?? '#a855f7'};`">

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-purple-700 text-theme-sm" x-text="row.code"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800 text-theme-sm" x-text="row.name"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-gray-100">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0"
                                        :style="`background-color: ${row.axis?.color ?? '#a855f7'}`"></span>
                                    <span class="font-semibold text-gray-700 text-theme-xs"
                                        x-text="row.axis?.code ?? ('EJE ' + row.axis?.axis_number)"></span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-600 text-theme-xs" x-text="row.axis?.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 justify-center h-7 px-3 rounded-full bg-purple-50 text-purple-700 text-theme-xs font-semibold">
                                    <span x-text="`${row.indicators_count ?? 0} KPIs`"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <button @click="verIndicadores(row)" title="Ver indicadores"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="editarTematica(row)" title="Editar temática"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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

    <x-tematicas.modal :ejes="$ejes" />

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tematicasController', () => ({
                selectedEje: 'todos',
                tableRowData: @json($tematicas),
                showModal: false,
                isEditing: false,
                form: {
                    id: null,
                    code: '',
                    name: '',
                    axis_id: ''
                },

                get filteredRows() {
                    if (this.selectedEje === 'todos') return this.tableRowData;
                    return this.tableRowData.filter(row => String(row.axis_id) === String(this.selectedEje));
                },

                get editUrl() {
                    return this.form.id
                        ? '{{ route('tematicas.update', ':id') }}'.replace(':id', this.form.id)
                        : '';
                },

                crearNuevaTematica() {
                    this.isEditing = false;
                    this.form = { id: null, code: '', name: '', axis_id: '' };
                    this.showModal = true;
                },

                editarTematica(row) {
                    this.isEditing = true;
                    this.form = {
                        id: row.id,
                        code: row.code || '',
                        name: row.name || '',
                        axis_id: row.axis_id || ''
                    };
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                },

                verIndicadores(row) {
                    window.location.href = `/admin/tematicas/${row.id}`;
                }
            }));
        });
    </script>
</div>
@endsection