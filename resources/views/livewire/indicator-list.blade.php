<div>
    @php
        $totalIndicadores = $indicators->count();
        $enMeta = $indicators->where('estatus', 'En Meta')->count();
        $enRiesgo = $indicators->where('estatus', 'En Riesgo')->count();
        $criticos = $indicators->where('estatus', 'Crítico')->count();

        $maxFecha = $indicators->max(fn($i) => $i->latestProgress?->captured_at ?? $i->latestProgress?->updated_at);

        $ultimaActualizacion = $maxFecha ? \Carbon\Carbon::parse($maxFecha)->format('d/m/Y') : 'Sin datos';

    @endphp

    <!-- Sección de Estadísticas Superiores -->
    <section class="pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 overflow-hidden">

                <div class="p-5 flex items-center space-x-4">
                    <div class="w-11 h-11 rounded-xl bg-teal-600 flex items-center justify-center shrink-0 shadow-sm">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-5 9 5-9 5-9-5Z" />
                            <path d="M3 15l9 5 9-5M3 9v6M21 9v6" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-800">{{ $totalIndicadores }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Resultados</div>
                    </div>
                </div>

                <div class="p-5 flex items-center space-x-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-600 flex items-center justify-center shrink-0 shadow-sm">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M3 9h18M8 2v4M16 2v4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-extrabold text-slate-800">{{ $ultimaActualizacion }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Última actualización
                        </div>
                    </div>
                </div>

                <div class="p-5 flex items-center space-x-4">
                    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center shrink-0 shadow-sm">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="8" />
                            <circle cx="12" cy="12" r="3.4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-800">{{ $enMeta }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">En meta</div>
                    </div>
                </div>

                <div class="p-5 flex items-center space-x-4">
                    <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center shrink-0 shadow-sm">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-800">{{ $enRiesgo }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">En proceso / Riesgo
                        </div>
                    </div>
                </div>

                <div class="p-5 flex items-center space-x-4">
                    <div class="w-11 h-11 rounded-xl bg-rose-600 flex items-center justify-center shrink-0 shadow-sm">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-800">{{ $criticos }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Críticos</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8 space-y-6">

        <!-- Herramientas y Filtros -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Panel de Filtros -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                    FILTRAR INDICADORES
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M4 4h16l-6 8v6l-4 2v-8L4 4Z" />
                    </svg>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-600">Eje</label>
                        <select wire:model.live="selectedAxis"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm px-3 py-2 font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="Todos">Todos</option>
                            @foreach ($axes as $axis)
                                <option value="{{ $axis->id }}">{{ $axis->axis_number }}. {{ $axis->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-600">Temática</label>
                        <select wire:model.live="selectedTheme"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm px-3 py-2 font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="Todas">Todas</option>
                            @foreach ($themes as $theme)
                                <option value="{{ $theme->code }}">{{ $theme->code }}. {{ $theme->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex items-center justify-between pt-2">
                        <button wire:click="clearFilters" type="button"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-lg transition-colors">
                            Limpiar filtros
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.4">
                                <path d="M21 12a9 9 0 1 1-3-6.7" />
                                <path d="M21 3v6h-6" />
                            </svg>
                        </button>

                        <span wire:loading class="text-xs font-medium text-teal-600 animate-pulse">Cargando...</span>
                    </div>
                </div>
            </div>

            <!-- Panel Leyenda -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4">% CUMPLIMIENTO DE META</h3>
                <div class="space-y-3 my-auto">
                    <div class="flex items-center text-xs font-semibold text-slate-600 gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Menor a 60%
                    </div>
                    <div class="flex items-center text-xs font-semibold text-slate-600 gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> 60% al 89%
                    </div>
                    <div class="flex items-center text-xs font-semibold text-slate-600 gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> 90% o más
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabla de Resultados -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Indicador
                            </th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Estatus
                            </th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Valor
                                actual</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Meta</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Cumplimiento</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Última
                                actualización</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($indicators as $indicator)
                            @php
                                $badgeStyle = match ($indicator->estatus) {
                                    'En Meta' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                    'En Riesgo' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                    'Crítico' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200',
                                };

                                $barStyle = match ($indicator->estatus) {
                                    'En Meta' => 'bg-emerald-500',
                                    'En Riesgo' => 'bg-amber-500',
                                    'Crítico' => 'bg-rose-500',
                                    default => 'bg-slate-400',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white shrink-0 shadow-sm"
                                            style="background: {{ $indicator->theme?->axis?->color ?? '#0d2f3d' }}">
                                            <img class="p-1" src="{{ asset('images/logos/' . $indicator->theme?->axis?->id . '.png') }}"
                                                alt="">
                                        </div>
                                        <div class="flex flex-col">
                                            <a href="{{ route('indicatores.show', $indicator) }}"
                                                class="font-semibold text-slate-900 hover:text-teal-600 transition-colors">
                                                {{ $indicator->name }}
                                            </a>
                                            <span
                                                class="text-xs text-slate-500">{{ $indicator->theme?->name ?? 'Sin temática' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                                        {{ $indicator->estatus }}

                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700 whitespace-nowrap">
                                    {{ $indicator->latestProgress?->actual_value !== null ? number_format($indicator->latestProgress->actual_value, 2) : '—' }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700 whitespace-nowrap">
                                    {{ $indicator->shortTermGoal?->target_value !== null ? number_format($indicator->shortTermGoal->target_value, 2) : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[140px]">
                                    @if ($indicator->latestProgress === null)
                                        <span class="text-slate-400 font-bold">Sin registro actual</span>
                                    @else
                                        <div class="text-xs font-bold text-slate-700 mb-1">
                                            {{ number_format($indicator->cumplimiento, 2) }}%
                                        </div>
                                        <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full {{ $barStyle }} rounded-full"
                                                style="width: {{ min($indicator->cumplimiento, 100) }}%">
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $indicator->latestProgress?->captured_at ? \Carbon\Carbon::parse($indicator->latestProgress->captured_at)->format('d/m/Y') : 'Sin registrar' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400 font-medium">
                                    No se encontraron indicadores con los filtros seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
