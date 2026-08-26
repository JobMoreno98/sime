@extends('layouts.landing')

@section('content')

    <section class="hero">
        <div class="wrap hero-grid">
            <div>
                <h1>SIME: Inteligencia de<br>Datos para la Decisión<br>Institucional</h1>
                <p>Visualiza el progreso de los objetivos estratégicos de la universidad para una gestión ágil y basada en
                    evidencia.</p>
            </div>
            <div class="donut-card">
                <span class="label">Cumplimiento Global</span>
                <div class="donut-wrap">
                    <canvas id="donutChart" width="220" height="220"></canvas>
                    <div class="donut-center">
                        <!-- Texto impreso dinámicamente desde Laravel -->
                        <span class="pct">{{ number_format($globalAverage ?? 0, 2) }}%</span>
                        <span class="yr">2025–2026</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap search-panel">
            <div class="search-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" id="searchInput"
                    placeholder="Buscar indicador, meta o departamento por palabra clave..." aria-label="Buscar indicador">
                <button id="btnFiltrar">FILTRAR</button>
            </div>
        </div>
    </section>

    <main class="wrap">
        <section class="section" id="indicadores">
            <div class="section-head">
                <h2>Indicadores de Eje</h2>
                <a href="#metodologia" class="link-mini">
                    Ver metodología
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.4">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 16v-5M12 8h.01"></path>
                    </svg>
                </a>
            </div>

            <div class="eje-grid" id="ejeGrid">
                @forelse($axes as $axis)
                    <div class="eje-card" data-c="{{ $axis->{'data-c'} }}">
                        <div class="eje-head">
                            <span>{{ $axis->name }}</span>
                        </div>
                        <div class="eje-body">
                            <span class="eje-count">{{ $axis->total_indicators }} Indicadores</span>
                            <span class="eje-pct">{{ $axis->average_percentage }}%</span>
                            <ul class="eje-list">
                                @forelse($axis->themes as $theme)
                                    <li>
                                        <span class="code">{{ $theme->code }}</span>
                                        <span class="lbl">{{ $theme->name }}</span>
                                        <canvas style="display: none;" class="spark" data-trend="3,5,4,6,7,6,8"
                                            data-color="{{ $axis->color }}" width="46" height="20"></canvas>
                                    </li>
                                @empty
                                    <li>Este eje no tiene temáticas registradas aún.</li>
                                @endforelse
                            </ul>
                            <div class="eje-cta">
                                <a href="/indicadores?axis={{ $axis->axis_number }}">Ver todos los indicadores →</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No hay indicadores registrados aún.</p>
                @endforelse
            </div>
        </section>

        <section class="section" style="padding-top:0">
            <div class="stats-strip">
                <div class="stat-item">
                    <div class="target"></div>
                    <div class="stat-text">
                        <div class="num-row">
                            <span class="num">{{ $countAllIndicators }}</span>
                            <span>Indicadores estratégicos</span>
                            <span class="badge-estr">ESTRATÉGICO</span>
                        </div>
                        <p>Miden los resultados en el logro de los objetivos del PDI a nivel prioritario y temático.</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="target"></div>
                    <div class="stat-text">
                        <div class="num-row">
                            <span class="num">0</span>
                            <span>Indicadores complementarios</span>
                        </div>
                        <p>Muestran información adicional que facilita entender el logro de los objetivos del PDI.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="reporte" style="padding-top:0">
            <div class="cta-grid">
                <div class="cta-card">
                    <div class="cta-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18" />
                            <path d="M7 15l4-5 3 3 5-7" />
                        </svg>
                    </div>
                    <div class="cta-body">
                        <h3>Consulta la evolución de los indicadores</h3>
                        <p>Explora gráficas interactivas y analiza el comportamiento histórico.</p>
                        <a href="#" class="cta-btn">
                            Ir a la consulta
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.4" stroke-linecap="round">
                                <path d="M5 12h14M13 6l6 6-6 6" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="cta-card">
                    <div class="cta-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v12" />
                            <path d="m7 10 5 5 5-5" />
                            <path d="M5 21h14" />
                        </svg>
                    </div>
                    <div class="cta-body">
                        <h3>Descarga las bases de datos de los indicadores</h3>
                        <p>Disponibles en múltiples formatos para tu análisis y consulta.</p>
                        <div class="format-row">
                            <a href="#" class="format-chip">🌐 Web</a>
                            <a href="#" class="format-chip">📊 Excel</a>
                            <a href="#" class="format-chip">📄 CSV</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@push('js')
    <script>
        (function drawDonut() {
            const canvas = document.getElementById('donutChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            const size = 220;
            canvas.width = size * dpr;
            canvas.height = size * dpr;
            ctx.scale(dpr, dpr);

            const cx = size / 2,
                cy = size / 2,
                radius = 86,
                lineWidth = 20;

            // Inyección dinámica de la variable de Laravel
            const pctTarget = {{ number_format($globalAverage ?? 0, 2, '.', '') }};
            const startAngle = -Math.PI / 2;

            let progress = 0;

            function frame() {
                progress += 0.02;
                if (progress > 1) progress = 1;
                const pct = pctTarget * progress;
                ctx.clearRect(0, 0, size, size);

                // Track (Fondo del anillo)
                ctx.beginPath();
                ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(255,255,255,.15)';
                ctx.lineWidth = lineWidth;
                ctx.stroke();

                // Progress arc (Anillo de progreso)
                if (pct > 0) {
                    // Topamos el ángulo en 100% (Math.PI * 2) para evitar desbordamiento gráfico
                    const endAngle = startAngle + (Math.min(pct, 100) / 100) * Math.PI * 2;

                    ctx.beginPath();
                    ctx.arc(cx, cy, radius, startAngle, endAngle);

                    const grad = ctx.createLinearGradient(0, 0, size, size);

                    // Asignación dinámica de color según el porcentaje global
                    if (pctTarget < 60) {
                        grad.addColorStop(0, '#f43f5e'); // Rojo / Crítico
                        grad.addColorStop(1, '#fb7185');
                    } else if (pctTarget < 90) {
                        grad.addColorStop(0, '#f59e0b'); // Amarillo / En Riesgo
                        grad.addColorStop(1, '#fbbf24');
                    } else {
                        grad.addColorStop(0, '#3fb27f'); // Verde / En Meta
                        grad.addColorStop(1, '#7fd9b6');
                    }

                    ctx.strokeStyle = grad;
                    ctx.lineWidth = lineWidth;
                    ctx.lineCap = 'round';
                    ctx.stroke();
                }

                if (progress < 1) requestAnimationFrame(frame);
            }
            requestAnimationFrame(frame);
        })();
    </script>
@endpush
