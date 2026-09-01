@extends('layouts.app')

@php
    $title = 'Ejes Estratégicos ';
@endphp

@section('content')
    <div x-data="ejesController">

        <div class="space-y-6">
            <!-- HEADER DE LA PÁGINA -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Ejes Estratégicos SIME</h2>
                    <p class="text-theme-xs text-gray-500 mt-0.5">Plan de Desarrollo 2025–2031 — Desglose de Ejes,
                        Responsables y Progreso General</p>
                </div>

                <div class="flex items-center gap-2.5">
                    <button @click="crearNuevoEje()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-theme-xs font-semibold shadow-theme-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nuevo Eje</span>
                    </button>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- TABLA -->
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-start border-collapse">

                        <thead class="border-b border-gray-100 bg-gray-50/50">

                            <tr>

                                <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500">Código</th>

                                <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500">Nombre del Eje</th>

                                <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500">Responsable
                                    Principal</th>

                                <th class="px-6 py-4 text-center text-theme-xs font-medium text-gray-500">Temáticas</th>

                                <th class="px-6 py-4 text-center text-theme-xs font-medium text-gray-500">Indicadores</th>

                                <th class="px-6 py-4 text-start text-theme-xs font-medium text-gray-500">Estado General</th>

                                <th class="px-6 py-4 text-center text-theme-xs font-medium text-gray-500">Acciones</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($axes as $axis)
                                @php
                                    $percentage = $axis->progress_percentage ?? 0;
                                    if ($percentage >= 75) {
                                        $colorClass = 'bg-emerald-500';
                                        $borderClass = 'border-l-purple-600';
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
                                <!-- ... Cálculo de porcentajes igual al tuyo ... -->
                                <!-- Asegúrate de pasar los parámetros correctos al botón de editar -->
                                <tr class="hover:bg-gray-50/60 transition-colors border-l-4 {{ $borderClass }}">
                                    <!-- Código (EJE 1, EJE 2, etc.) -->
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="font-bold text-purple-600 text-theme-xs tracking-wider uppercase">
                                            {{ $axis->code ?? 'EJE ' . $axis->axis_number }}
                                        </span>
                                    </td>
                                    <!-- Nombre del Eje -->
                                    <td class="px-6 py-5 max-w-xs">
                                        <span class="font-semibold text-gray-800 text-theme-sm block leading-snug">
                                            {{ $axis->name }}
                                        </span>
                                    </td>
                                    <!-- Responsable Principal -->
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5 text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="text-theme-xs font-medium">
                                                {{ $axis->responsible_unit ?? ($axis->responsibleUser->name ?? 'Sin Asignar') }}
                                            </span>
                                        </div>
                                    </td>
                                    <!-- Temáticas (Contador redondeado) -->
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-700 text-theme-xs font-bold">
                                            {{ $axis->themes_count ?? ($axis->themes->count() ?? 0) }}
                                        </span>
                                    </td>
                                    <!-- Indicadores (Contador redondeado) -->
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-7 rounded-full bg-gray-100 text-gray-700 text-theme-xs font-bold">
                                            {{ $axis->indicators_count ?? 0 }}
                                        </span>
                                    </td>
                                    <!-- ... Demás TDs ... -->
                                    <td class="px-6 py-5 whitespace-nowrap min-w-[180px]">
                                        <div class="flex items-center gap-3">
                                            <div class="w-28 bg-gray-100 h-2.5 rounded-full overflow-hidden">
                                                <!-- Usamos el accesor para el color de la barra -->
                                                <div class="{{ $axis->progress_styles['color'] }} h-2.5 rounded-full transition-all duration-500"
                                                    style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-theme-xs font-bold text-gray-700">
                                                {{ $percentage }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2 text-gray-500">
                                            <button type="button" @click="editarEje(@js($axis))"
                                                title="Editar Eje"
                                                class="p-1.5 rounded-lg hover:bg-gray-100 hover:text-purple-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <!-- Empty state -->
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- INCLUIR EL COMPONENTE DEL MODAL -->
        <x-ejes.modal />
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('ejesController', () => ({
                    search: '',
                    showModal: false,
                    isEditing: false,
                    form: {
                        id: null,
                        axis_number: '',
                        name: '',
                        description: '',
                    },

                    get editUrl() {
                        return this.form.id ?
                            '{{ route('ejes.update', ':id') }}'.replace(':id', this.form.id) :
                            '';
                    },

                    verDetalle(ejeId) {
                        window.location.href = `/ejes/${ejeId}`;
                    },

                    crearNuevoEje() {
                        this.isEditing = false;
                        this.form = {
                            id: null,
                            axis_number: '',
                            name: '',
                            description: '',
                            color: '#4f46e5'
                        };
                        this.showModal = true;
                    },

                    editarEje(eje) {
                        console.log('Objeto recibido:', eje);
                        this.isEditing = true;
                        this.form = {
                            id: eje.id,
                            axis_number: eje.axis_number || '',
                            name: eje.name || '',
                            description: eje.description || '',
                            color: eje.color || '#000000'
                        };
                        this.showModal = true;
                    },

                    closeModal() {
                        this.showModal = false;
                    },

                    submitForm() {
                        const url = this.isEditing ? `admin/ejes/${this.form.id}` : 'admin/ejes';
                        const method = this.isEditing ? 'PUT' : 'POST';

                        fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')
                                    .content
                            },
                            body: JSON.stringify(this.form)
                        }).then(response => {
                            if (response.ok) {
                                window.location.reload();
                            } else {
                                console.error('Error al guardar el eje:', response.status);
                            }
                        }).catch(error => {
                            console.error('Error de red al guardar el eje:', error);
                        });

                        this.closeModal();
                    }
                }));
            });
        </script>
    </div>
@endsection
