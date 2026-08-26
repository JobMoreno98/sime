<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIME · Sistema Inteligente de Datos para la Decisión</title>
    <link rel="stylesheet" href="style.css">
    <!-- Lucide Icons para iconografía moderna y limpia -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        * {
            font-family: 'Montserrat' !important;
        }

        :root {
            --navy-950: #0a2530;
            --navy-900: #0d2f3d;
            --teal-800: #0f4a52;
            --teal-600: #1a7a6e;
            --green-acc: #3fb27f;
            --ink-900: #12232a;
            --ink-600: #4c5f66;
            --ink-400: #7c8c92;
            --line: #e4e9ea;
            --paper: #ffffff;
            --bg-soft: #f3f6f6;

            --c-formacion: #2f6b4f;
            --c-conocimiento: #274a7a;
            --c-vinculo: #b8860b;
            --c-cultura: #7a1f3d;
            --c-gestion: #c1552c;

            --radius-lg: 16px;
            --radius-md: 10px;
            --shadow-card: 0 1px 2px rgba(10, 37, 48, .06), 0 8px 24px -12px rgba(10, 37, 48, .15);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', 'Inter', system-ui, -apple-system, Arial, sans-serif;
            color: var(--ink-900);
            background: var(--bg-soft);
            -webkit-font-smoothing: antialiased;
        }

        img,
        svg {
            display: block;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        .wrap {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 28px;
        }

        /* ---------- Header ---------- */
        header.site {
            background: var(--navy-950);
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .header-inner {
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 14px 28px;
            max-width: 1180px;
            margin: 0 auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand .name-block {
            line-height: 1.15;
        }

        .brand .name-block small {
            display: block;
            font-size: 10px;
            letter-spacing: .06em;
            color: #8fb3ad;
            font-weight: 600;
        }

        .brand .name-block strong {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: .01em;
            max-width: 220px;
        }

        nav.primary {
            display: flex;
            align-items: center;
            gap: 26px;
            margin-left: 8px;
            flex: 1;
        }

        nav.primary a {
            font-size: 13px;
            font-weight: 600;
            color: #cfe3e0;
            letter-spacing: .02em;
            padding: 6px 2px;
            border-bottom: 2px solid transparent;
            transition: .15s;
            white-space: nowrap;
        }

        nav.primary a:hover {
            color: #fff;
            border-color: var(--green-acc);
        }

        .btn-ingresar {
            margin-left: auto;
            border: 1px #fff solid !important;
            background-color: #0a2530;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13.5px;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: .15s;
            flex-shrink: 0;
        }

        .btn-ingresar:hover {
            background: #57c491;
        }

        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
            padding: 4px;
        }

        /* ---------- Hero ---------- */
        .hero {
            background:
                radial-gradient(1100px 420px at 78% -10%, rgba(63, 178, 127, .28), transparent 60%),
                linear-gradient(120deg, var(--teal-600) 0%, var(--teal-800) 45%, var(--navy-900) 100%);
            color: #fff;
            padding: 56px 0 40px;
            position: relative;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            gap: 40px;
            align-items: center;
        }

        .hero h1 {
            font-size: 38px;
            line-height: 1.15;
            margin: 0 0 14px;
            font-weight: 800;
            letter-spacing: -.01em;
        }

        .hero p {
            font-size: 15.5px;
            line-height: 1.6;
            color: #cfe6e2;
            max-width: 480px;
            margin: 0;
        }

        .donut-card {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 20px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(6px);
            justify-self: center;
        }

        .donut-card .label {
            font-size: 13px;
            color: #cfe6e2;
            font-weight: 600;
        }

        .donut-wrap {
            position: relative;
            width: 190px;
            height: 190px;
        }

        .donut-wrap canvas {
            width: 100%;
            height: 100%;
        }

        .donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .donut-center .pct {
            font-size: 30px;
            font-weight: 800;
        }

        .donut-center .yr {
            font-size: 11.5px;
            color: #a9c9c4;
            margin-top: 2px;
        }

        .search-panel {
            margin-top: 34px;
        }

        .search-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 8px 8px 18px;
        }

        .search-box svg {
            flex-shrink: 0;
            color: var(--ink-400);
        }

        .search-box input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 14.5px;
            padding: 10px 0;
            color: var(--ink-900);
            background: transparent;
        }

        .search-box input::placeholder {
            color: var(--ink-400);
        }

        .search-box button {
            background: var(--navy-900);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: .03em;
            transition: .15s;
        }

        .search-box button:hover {
            background: var(--teal-800);
        }

        /* ---------- Section heading ---------- */
        .section {
            padding: 44px 0;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-head h2 {
            font-size: 19px;
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-head h2::before {
            content: "";
            width: 4px;
            height: 18px;
            background: var(--green-acc);
            border-radius: 2px;
        }

        .link-mini {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink-600);
            background: #fff;
            border: 1px solid var(--line);
            padding: 8px 14px;
            border-radius: 8px;
            transition: .15s;
        }

        .link-mini:hover {
            border-color: var(--teal-600);
            color: var(--teal-800);
        }

        /* ---------- Eje cards ---------- */
        .eje-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        .eje-card {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--line);
            transition: transform .18s, box-shadow .18s;
        }

        .eje-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(10, 37, 48, .08), 0 16px 32px -14px rgba(10, 37, 48, .22);
        }

        .eje-head {
            padding: 16px 16px 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .eje-head .icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eje-head span {
            font-size: 12.5px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: .01em;
        }

        .eje-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }

        .eje-count {
            font-size: 12.5px;
            color: var(--ink-600);
            font-weight: 600;
        }

        .eje-pct {
            font-size: 29px;
            font-weight: 800;
            color: var(--ink-900);
            line-height: 1;
        }

        .eje-delta {
            font-size: 11.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .eje-delta.up {
            color: #1c8a53;
        }

        .eje-delta.down {
            color: #c0392b;
        }

        .eje-list {
            list-style: none;
            margin: 6px 0 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .eje-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            font-size: 11.8px;
            color: var(--ink-700, #33474e);
        }

        .eje-list li .code {
            font-weight: 700;
            color: var(--ink-900);
        }

        .eje-list li .lbl {
            flex: 1;
            margin: 0 6px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: var(--ink-600);
        }

        .eje-list li canvas {
            width: 46px;
            height: 20px;
            flex-shrink: 0;
        }

        .eje-cta {
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px dashed var(--line);
        }

        .eje-cta a {
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* eje color themes */
        .eje-card[data-c="formacion"] .eje-head {
            background: var(--c-formacion);
        }

        .eje-card[data-c="formacion"] .eje-cta a {
            color: var(--c-formacion);
        }

        .eje-card[data-c="conocimiento"] .eje-head {
            background: var(--c-conocimiento);
        }

        .eje-card[data-c="conocimiento"] .eje-cta a {
            color: var(--c-conocimiento);
        }

        .eje-card[data-c="vinculo"] .eje-head {
            background: var(--c-vinculo);
        }

        .eje-card[data-c="vinculo"] .eje-cta a {
            color: var(--c-vinculo);
        }

        .eje-card[data-c="cultura"] .eje-head {
            background: var(--c-cultura);
        }

        .eje-card[data-c="cultura"] .eje-cta a {
            color: var(--c-cultura);
        }

        .eje-card[data-c="gestion"] .eje-head {
            background: var(--c-gestion);
        }

        .eje-card[data-c="gestion"] .eje-cta a {
            color: var(--c-gestion);
        }

        /* ---------- Stats strip ---------- */
        .stats-strip {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            display: grid;
            grid-template-columns: 1fr 1fr;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 22px 26px;
        }

        .stat-item:first-child {
            border-right: 1px solid var(--line);
        }

        .stat-item .target {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            flex-shrink: 0;
            border: 3px solid #6b2fb2;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .stat-item .target::before {
            content: "";
            position: absolute;
            inset: 9px;
            border-radius: 50%;
            border: 3px solid #6b2fb2;
        }

        .stat-item .target::after {
            content: "";
            position: absolute;
            inset: 19px;
            border-radius: 50%;
            background: #6b2fb2;
        }

        .stat-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .stat-text .num-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-text .num {
            font-size: 26px;
            font-weight: 800;
        }

        .badge-estr {
            background: #e9f7ef;
            color: #1c8a53;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 5px;
            letter-spacing: .04em;
        }

        .stat-text p {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--ink-600);
            max-width: 320px;
            line-height: 1.4;
        }

        /* ---------- ODS ---------- */
        .ods-panel {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 24px 26px;
            box-shadow: var(--shadow-card);
        }

        .ods-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .ods-item {
            border-radius: 10px;
            padding: 14px 10px;
            color: #fff;
            font-size: 10.5px;
            font-weight: 800;
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: space-between;
            min-height: 96px;
            line-height: 1.2;
            letter-spacing: .01em;
            transition: transform .15s;
        }

        .ods-item:hover {
            transform: translateY(-2px);
        }

        .ods-item .num {
            font-size: 17px;
            font-weight: 800;
        }

        .ods-item svg {
            width: 22px;
            height: 22px;
            align-self: flex-end;
            opacity: .9;
        }

        .ods-more {
            background: var(--bg-soft);
            color: var(--ink-600);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed var(--line);
        }

        /* ---------- CTA panels ---------- */
        .cta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .cta-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 26px;
            display: flex;
            gap: 18px;
            box-shadow: var(--shadow-card);
        }

        .cta-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #f1e8fb;
            color: #6b2fb2;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cta-body h3 {
            margin: 0 0 6px;
            font-size: 15.5px;
            font-weight: 800;
        }

        .cta-body p {
            margin: 0 0 14px;
            font-size: 12.8px;
            color: var(--ink-600);
            line-height: 1.5;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 700;
            border: 1px solid var(--navy-900);
            color: var(--navy-900);
            padding: 9px 16px;
            border-radius: 8px;
            transition: .15s;
        }

        .cta-btn:hover {
            background: var(--navy-900);
            color: #fff;
        }

        .format-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .format-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink-600);
            border: 1px solid var(--line);
            padding: 8px 12px;
            border-radius: 8px;
            transition: .15s;
        }

        .format-chip:hover {
            border-color: var(--teal-600);
            color: var(--teal-800);
        }

        /* ---------- Footer ---------- */
        footer.site {
            background: var(--navy-950);
            color: #c8d8d6;
            padding: 44px 0 20px;
            margin-top: 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 30px;
            padding-bottom: 28px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .footer-brand {
            display: flex;
            gap: 12px;
        }

        .footer-brand strong {
            display: block;
            font-size: 14px;
            color: #fff;
        }

        .footer-brand p {
            margin: 6px 0 0;
            font-size: 11.5px;
            line-height: 1.6;
            color: #93a8a5;
            max-width: 220px;
        }

        footer h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #7fa39c;
            margin: 0 0 14px;
        }

        footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        footer ul a {
            font-size: 12.8px;
            color: #d3e3e1;
            transition: .15s;
        }

        footer ul a:hover {
            color: #fff;
        }

        .socials {
            display: flex;
            gap: 10px;
            margin-top: 14px;
        }

        .socials a {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .15s;
        }

        .socials a:hover {
            background: var(--green-acc);
            color: #06251b;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 18px;
            font-size: 11.5px;
            color: #7fa39c;
            flex-wrap: wrap;
            gap: 10px;
        }

        .footer-bottom .links {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
        }

        /* ---------- Responsive ---------- */
        @media (max-width:1024px) {
            .eje-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .ods-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width:860px) {
            nav.primary {
                display: none;
            }

            .nav-toggle {
                display: block;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }

            .donut-card {
                justify-self: start;
            }

            .cta-grid {
                grid-template-columns: 1fr;
            }

            .stats-strip {
                grid-template-columns: 1fr;
            }

            .stat-item:first-child {
                border-right: none;
                border-bottom: 1px solid var(--line);
            }
        }

        @media (max-width:640px) {
            .eje-grid {
                grid-template-columns: 1fr 1fr;
            }

            .ods-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .hero h1 {
                font-size: 29px;
            }

            .wrap {
                padding: 0 18px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
        }

        :focus-visible {
            outline: 2px solid var(--green-acc);
            outline-offset: 2px;
        }
    </style>
</head>

<body>

    <header class="site">
        <div class="header-inner">
            <a class="brand" href="/">
                <div class="mark"><img src="/images/logo/logo-cucsh-blanco.png" width="100"></div>
                <div class="name-block">
                    <strong>Sistema Inteligente de Datos para la Decisión (SIME)</strong>
                </div>
            </a>
            <nav class="primary" aria-label="Navegación principal">
                <a href="/storage/pdfs/CUCSH - PDCUyS 2025-2031.pdf" target="_blank" style="margin-left: auto;">PDI</a>
                <a href="/indicadores">Explora indicadores</a>
            </nav>
            <a class="btn-ingresar" id="btnIngresar" href="/signin">
                Ingresar
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.4" stroke-linecap="round">
                    <path d="M5 12h14M13 6l6 6-6 6" />
                </svg>
            </a>
            <button class="nav-toggle" id="navToggle" aria-label="Abrir menú">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 6h18M3 12h18M3 18h18" />
                </svg>
            </button>
        </div>
    </header>


    @yield('content')



    <footer class="site" id="contacto">
        <div class="wrap">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="/images/logo/logo-cucsh-blanco.png" width="100" style="height: min-content;">
                    <div>
                        <strong>CUCSH</strong>
                        <p>Centro Universitario de Ciencias Sociales y Humanidades — Universidad de Guadalajara.</p>
                    </div>
                </div>
                <div>
                    <h4>Enlaces rápidos</h4>
                    <ul>
                        <li><a href="#">Portal CUCSH</a></li>
                        <li><a href="#">Acerca del CUCSH</a></li>
                        <li><a href="#">Investigación</a></li>
                        <li><a href="#">Servicios universitarios</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Mapa del sitio</h4>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Indicadores</a></li>
                        <li><a href="#">PDI</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Síguenos</h4>
                    <div class="socials">
                        <a href="#" aria-label="Facebook"><svg width="15" height="15" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M13.5 21v-8h2.7l.4-3.3h-3.1V7.6c0-.9.3-1.6 1.7-1.6h1.5V3.1C15.9 3 14.9 3 13.7 3 11.2 3 9.5 4.5 9.5 7.3v2.4H6.8V13h2.7v8h4z" />
                            </svg></a>
                        <a href="#" aria-label="Twitter"><svg width="15" height="15" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.4-1.3 1.7-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.6 0-1.3-.2-1.8-.5v.1c0 2 1.4 3.6 3.3 4a4.2 4.2 0 0 1-1.8.1 4.1 4.1 0 0 0 3.9 2.9A8.3 8.3 0 0 1 2 18.4a11.6 11.6 0 0 0 6.3 1.9c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.2z" />
                            </svg></a>
                        <a href="#" aria-label="YouTube"><svg width="15" height="15" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M22 12s0-3.2-.4-4.6c-.3-.9-1-1.6-1.9-1.8C18 5.2 12 5.2 12 5.2s-6 0-7.7.4c-.9.2-1.6.9-1.9 1.8C2 8.8 2 12 2 12s0 3.2.4 4.6c.3.9 1 1.6 1.9 1.8 1.7.4 7.7.4 7.7.4s6 0 7.7-.4c.9-.2 1.6-.9 1.9-1.8.4-1.4.4-4.6.4-4.6zM10 15V9l5.2 3z" />
                            </svg></a>
                        <a href="#" aria-label="Instagram"><svg width="15" height="15" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2 0 1.9.3 2.3.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1.1.4 2.3.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c0 1.2-.3 1.9-.4 2.3-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1.1.4-2.3.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2 0-1.9-.3-2.3-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1.1-.4-2.3-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c0-1.2.3-1.9.4-2.3.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1.1-.4 2.3-.4 1.3-.1 1.7-.1 4.9-.1zM12 0C8.7 0 8.3 0 7 .1 5.7.1 4.8.3 4 .7c-.8.3-1.5.7-2.2 1.4C1.1 2.8.7 3.5.4 4.3c-.3.8-.5 1.7-.6 3C-.2 8.7-.2 9.1-.2 12.3s0 3.6.1 4.9c.1 1.3.3 2.2.6 3 .3.8.7 1.5 1.4 2.2.7.7 1.4 1.1 2.2 1.4.8.3 1.7.5 3 .6 1.3.1 1.7.1 4.9.1s3.6 0 4.9-.1c1.3-.1 2.2-.3 3-.6.8-.3 1.5-.7 2.2-1.4.7-.7 1.1-1.4 1.4-2.2.3-.8.5-1.7.6-3 .1-1.3.1-1.7.1-4.9s0-3.6-.1-4.9c-.1-1.3-.3-2.2-.6-3-.3-.8-.7-1.5-1.4-2.2C21.2 1.1 20.5.7 19.7.4c-.8-.3-1.7-.5-3-.6C15.4 0 15 0 12 0z" />
                                <circle cx="12" cy="12" r="3.2" />
                            </svg></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© 2026 Universidad de Guadalajara. Todos los derechos reservados. CUCSH.</span>
                <div class="links">
                    <a href="#">Aviso de privacidad</a>
                    <a href="#">Créditos del sitio</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts

</body>
@stack('name')
</html>
