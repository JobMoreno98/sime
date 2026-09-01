@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ openModal: false }">

    <!-- BREADCRUMB Y ACCIONES -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <nav class="flex items-center gap-2 text-theme-xs text-gray-500 overflow-x-auto whitespace-nowrap">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="/indicadores" class="hover:text-teal-600 transition-colors">Indicadores</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Ficha de Indicador {{ $indicador->code }}</span>
        </nav>

        <div class="flex items-center gap-2.5 self-end sm:self-auto">
            <a href="javascript:history.back()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-theme-xs font-semibold shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Volver</span>
            </a>

            @auth
                <button @click="openModal = true" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-theme-xs font-semibold shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Registrar Avance</span>
                </button>
            @endauth
        </div>
    </div>

    <!-- ENCABEZADO Y CONTEXTO -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                Eje {{ $indicador->theme->axis->code ?? $indicador->theme->axis->axis_number ?? '-' }}: {{ $indicador->theme->axis->name ?? 'Sin Eje' }}
            </span>
            <a href="{{ route('tematicas.show', $indicador->theme->id ?? 0) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200/60 hover:bg-teal-100 transition-colors">
                Temática: {{ $indicador->theme->name ?? 'Sin Temática' }}
            </a>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-teal-600 uppercase tracking-widest block">Código: {{ $indicador->code }}</span>
                <h1 class="text-2xl font-extrabold text-gray-900 mt-0.5">
                    {{ $indicador->name }}
                </h1>
            </div>

            <!-- Badge de Estatus de Cumplimiento -->
            @php
                $cumplimiento = $indicador->cumplimiento ?? 0;
                if ($cumplimiento >= 90) {
                    $statusBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    $statusDot = 'bg-emerald-500';
                    $statusLabel = 'En Meta';
                } elseif ($cumplimiento >= 60) {
                    $statusBg = 'bg-amber-50 text-amber-700 border-amber-200';
                    $statusDot = 'bg-amber-500';
                    $statusLabel = 'En Riesgo';
                } else {
                    $statusBg = 'bg-rose-50 text-rose-700 border-rose-200';
                    $statusDot = 'bg-rose-500';
                    $statusLabel = 'Atención Crítica';
                }
            @endphp
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-xl border {{ $statusBg }} self-start lg:self-auto">
                <span class="w-3 h-3 rounded-full {{ $statusDot }} animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-wider">{{ $statusLabel }} ({{ number_format($cumplimiento, 1) }}%)</span>
            </div>
        </div>
    </div>

    <!-- TARJETAS DE KPIs DEL INDICADOR -->
    @php
        $latestValue = $indicador->latestProgress->value ?? 0;
        $targetValue = $indicador->shortTermGoal->target_value ?? $indicador->target_value ?? 0;
        $baseValue = $indicador->baseline ?? 0;
    @endphp
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <span class="text-theme-xs font-medium text-gray-500">Línea Base</span>
            <div class="mt-2 text-2xl font-extrabold text-gray-900">{{ number_format($baseValue, 2) }}</div>
            <p class="text-theme-xs text-gray-400 mt-1">Valor inicial registrado</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <span class="text-theme-xs font-medium text-teal-600">Último Valor Capturado</span>
            <div class="mt-2 text-2xl font-extrabold text-teal-700">{{ number_format($latestValue, 2) }}</div>
            <p class="text-theme-xs text-gray-400 mt-1">Fecha: {{ optional($indicador->latestProgress)->created_at ? $indicador->latestProgress->created_at->format('d/m/Y') : 'Sin registros' }}</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <span class="text-theme-xs font-medium text-gray-500">Meta Programada</span>
            <div class="mt-2 text-2xl font-extrabold text-gray-900">{{ number_format($targetValue, 2) }}</div>
            <p class="text-theme-xs text-gray-400 mt-1">Unidad: {{ $indicador->unit ?? 'Unidades' }}</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <span class="text-theme-xs font-medium text-gray-500">Avance de Meta</span>
            <div class="mt-2 text-2xl font-extrabold text-gray-900">{{ number_format($cumplimiento, 1) }}%</div>
            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden mt-2">
                <div class="bg-teal-600 h-2 rounded-full" style="width: {{ min(100, $cumplimiento) }}%"></div>
            </div>
        </div>

    </div>

    <!-- DETALLES TÉCNICOS Y HISTORIAL -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        <!-- COLUMNA IZQUIERDA: FICHA TÉCNICA E HISTORIAL -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Ficha Técnica -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
                <h3 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-3">Ficha Técnica del Indicador</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-theme-xs font-medium text-gray-400">Descripción / Definición</span>
                        <p class="text-theme-sm text-gray-700 mt-1 leading-relaxed">
                            {{ $indicador->description ?? 'Sin descripción disponible.' }}
                        </p>
                    </div>

                    <div>
                        <span class="block text-theme-xs font-medium text-gray-400">Fórmula de Cálculo</span>
                        <p class="text-theme-sm text-gray-700 mt-1 font-mono bg-slate-50 p-2.5 rounded-xl border border-slate-200/80">
                            {{ $indicador->formula ?? 'No especificada' }}
                        </p>
                    </div>

                    <div>
                        <span class="block text-theme-xs font-medium text-gray-400">Unidad de Medida</span>
                        <p class="text-theme-sm text-gray-800 font-semibold mt-1">{{ $indicador->unit ?? 'No especificada' }}</p>
                    </div>

                    <div>
                        <span class="block text-theme-xs font-medium text-gray-400">Frecuencia de Medición</span>
                        <p class="text-theme-sm text-gray-800 font-semibold mt-1">{{ $indicador->frequency ?? 'Anual' }}</p>
                    </div>
                </div>
            </div>

            <!-- Historial de Capturas -->
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Historial de Avances Registrados</h3>
                        <p class="text-theme-xs text-gray-500">Bitácora de capturas y observaciones</p>
                    </div>
                </div>

                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-start border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Fecha</th>
                                <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Valor Capturado</th>
                                <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Capturado por</th>
                                <th class="px-6 py-3 text-start text-theme-xs font-medium text-gray-500">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($indicador->progressLogs ?? $indicador->progresses ?? [] as $log)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-theme-xs text-gray-600 font-medium">
                                        {{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-teal-700 text-theme-sm">
                                            {{ number_format($log->value, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-theme-xs text-gray-600">
                                        {{ $log->user->name ?? 'Sistema' }}
                                    </td>
                                    <td class="px-6 py-4 text-theme-xs text-gray-500">
                                        {{ $log->notes ?? $log->observation ?? 'Sin observaciones' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-theme-xs">
                                        No se han registrado capturas de avance para este indicador.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- COLUMNA DERECHA: RESPONSABLE Y METAS -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Responsable de Medición -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-3">
                <h3 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-2">Unidad Responsable</h3>
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 font-bold text-sm">
                        {{ strtoupper(substr($indicador->responsibleUser->name ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <strong class="block text-theme-sm text-gray-800">{{ $indicador->responsibleUser->name ?? 'Sin responsable asignado' }}</strong>
                        <span class="text-theme-xs text-gray-400">{{ $indicador->responsibleUser->email ?? 'cucsh@udg.mx' }}</span>
                    </div>
                </div>
            </div>

            <!-- Desglose de Metas -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
                <h3 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-2">Programación de Metas</h3>

                <div class="space-y-3">
                    @forelse($indicador->goals ?? [] as $goal)
                        <div class="flex items-center justify-between text-theme-xs p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="font-medium text-gray-600">Meta {{ $goal->year ?? 'Quinquenal' }}</span>
                            <span class="font-bold text-gray-900">{{ number_format($goal->target_value, 2) }} {{ $indicador->unit }}</span>
                        </div>
                    @empty
                        <div class="flex items-center justify-between text-theme-xs p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="font-medium text-gray-600">Meta Quinquenal</span>
                            <span class="font-bold text-gray-900">{{ number_format($targetValue, 2) }}</span>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection