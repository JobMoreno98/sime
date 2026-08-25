<div>
    @php
        $totalIndicadores = $indicators->count();
        $enMeta = $indicators->where('estatus', 'En Meta')->count();
        $enRiesgo = $indicators->where('estatus', 'En Riesgo')->count();
        $criticos = $indicators->where('estatus', 'Crítico')->count();

        $ultimaActualizacion = $indicators->max(fn($i) => $i->latestProgress?->captured_at)
            ? \Carbon\Carbon::parse($indicators->max(fn($i) => $i->latestProgress->captured_at))->format('d/m/Y')
            : 'Sin datos';
    @endphp


    <section class="page-top">
        <div class="wrap" style="padding-top:26px;">
            <div class="stats-card">
                <div class="stat">
                    <div class="ico c1"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-5 9 5-9 5-9-5Z" />
                            <path d="M3 15l9 5 9-5M3 9v6M21 9v6" />
                        </svg></div>
                    <div class="num">{{ $totalIndicadores }}</div>
                    <div class="lbl">Resultados</div>
                </div>
                <div class="stat">
                    <div class="ico c2"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M3 9h18M8 2v4M16 2v4" />
                        </svg></div>
                    <div class="num" style="font-size: 20px;">{{ $ultimaActualizacion }}</div>
                    <div class="lbl">Última actualización</div>
                </div>
                <div class="stat">
                    <div class="ico c3"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="8" />
                            <circle cx="12" cy="12" r="3.4" />
                        </svg></div>
                    <div class="num">{{ $enMeta }}</div>
                    <div class="lbl">En meta</div>
                </div>
                <div class="stat">
                    <div class="ico c4"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg></div>
                    <div class="num">{{ $enRiesgo }}</div>
                    <div class="lbl">En proceso / Riesgo</div>
                </div>
                <div class="stat" style="border-right:none;">
                    <div class="ico c5"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg></div>
                    <div class="num">{{ $criticos }}</div>
                    <div class="lbl">Críticos</div>
                </div>
            </div>
        </div>
    </section>

    <main class="wrap">
        <div class="tools-grid">
            <div class="panel">
                <h3>FILTRAR INDICADORES <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16l-6 8v6l-4 2v-8L4 4Z" />
                    </svg></h3>
                <div class="filters-grid">

                    <div class="field">
                        <label>Eje</label>
                        <!-- Usamos wire:model.live (Livewire v3) o wire:model (Livewire v2) para actualizar al instante -->
                        <select wire:model.live="selectedAxis">
                            <option value="Todos">Todos</option>
                            @foreach ($axes as $axis)
                                <option value="{{ $axis->id }}"> {{ $axis->axis_number }}. {{ $axis->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label>Temática</label>
                        <select wire:model.live="selectedTheme">
                            <option value="Todas">Todas</option>
                            @foreach ($themes as $theme)
                                <option value="{{ $theme->code }}">{{ $theme->code }}. {{ $theme->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filters-actions">
                        <!-- El botón aplicar ya no es estrictamente necesario si usas .live, pero lo mantenemos para UX -->
                        <button class="btn-ghost" wire:click="clearFilters" type="button">Limpiar filtros
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.4">
                                <path d="M21 12a9 9 0 1 1-3-6.7" />
                                <path d="M21 3v6h-6" />
                            </svg>
                        </button>

                        <!-- Indicador de carga de Livewire (Opcional pero recomendado) -->
                        <span wire:loading
                            style="font-size: 12px; color: var(--teal-600); margin-left: 10px;">Cargando...</span>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h3>% CUMPLIMIENTO DE META</h3>
                <div class="legend-list">
                    <div class="legend-item riesgo"><span class="legend-dot"></span> Menor a 60%</div>
                    <div class="legend-item proceso"><span class="legend-dot"></span> 60% al 89%</div>
                    <div class="legend-item meta"><span class="legend-dot"></span> 90% o más</div>
                </div>
            </div>
        </div>

        <div class="table-panel">
            <table>
                <thead>
                    <tr>
                        <th>Indicador</th>
                        <th>Estatus</th>
                        <th>Valor actual</th>
                        <th>Meta</th>
                        <th>Cumplimiento</th>
                        <th>Última actualización</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($indicators as $indicator)
                        @php
                            $badgeClass = match ($indicator->estatus) {
                                'En Meta' => 'meta',
                                'En Riesgo' => 'proceso',
                                'Crítico' => 'riesgo',
                                default => 'sin',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="ind-cell">
                                    <div class="ind-ico"
                                        style="background:{{ $indicator->theme?->axis?->color ?? 'var(--navy-900)' }}">
                                        {!! $indicator->icon_svg !!}
                                    </div>
                                    <div class="ind-text">
                                        <a href="#">
                                            <strong>{{ $indicator->name }}</strong>
                                            <span>{{ $indicator->theme?->name ?? 'Sin temática' }}</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    {{ $indicator->estatus }}
                                </span>
                            </td>
                            <td>{{ $indicator->latestProgress?->actual_value !== null ? number_format($indicator->latestProgress->actual_value, 2) : '—' }}
                            </td>
                            <td>{{ $indicator->shortTermGoal?->target_value !== null ? number_format($indicator->shortTermGoal->target_value, 2) : '—' }}
                            </td>
                            <td class="cumpl-cell">
                                @if ($indicator->cumplimiento === null)
                                    <span style="color:var(--ink-400);font-weight:700;">—</span>
                                @else
                                    <div class="cumpl-pct {{ $badgeClass }}">
                                        {{ number_format($indicator->cumplimiento, 2) }}%
                                    </div>
                                    <div class="cumpl-bar {{ $badgeClass }}">
                                        <span style="width: {{ $indicator->cumplimiento }}%"></span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $indicator->latestProgress?->captured_at ? \Carbon\Carbon::parse($indicator->latestProgress->captured_at)->format('d/m/Y') : 'Sin registrar' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--ink-400);">No se
                                encontraron indicadores con los filtros seleccionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
