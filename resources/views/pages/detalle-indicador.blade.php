@extends('layouts.landing')

@section('content')

<style>
  :root{
    --navy-950:#0a2530;
    --navy-900:#0d2f3d;
    --teal-800:#0f4a52;
    --teal-600:#1a7a6e;
    --green-acc:#3fb27f;
    --ink-900:#12232a;
    --ink-700:#33474e;
    --ink-600:#4c5f66;
    --ink-400:#7c8c92;
    --line:#e4e9ea;
    --paper:#ffffff;
    --bg-soft:#f3f6f6;

    --status-meta:#1c8a53;
    --status-meta-bg:#e5f6ee;
    --status-proceso:#b6791a;
    --status-proceso-bg:#fdf1de;
    --status-riesgo:#c0392b;
    --status-riesgo-bg:#fbe9e7;

    --radius-lg:16px;
    --radius-md:10px;
    --shadow-card:0 1px 2px rgba(10,37,48,.06), 0 8px 24px -12px rgba(10,37,48,.15);
  }

  *{box-sizing:border-box;}
  body{
    margin:0;font-family:'Segoe UI','Inter',system-ui,-apple-system,Arial,sans-serif;
    color:var(--ink-900);background:var(--bg-soft);-webkit-font-smoothing:antialiased;
  }
  img,svg{display:block;}
  a{color:inherit;text-decoration:none;}
  button,select{font-family:inherit;cursor:pointer;}
  .wrap{max-width:1180px;margin:0 auto;padding:0 28px;}

  /* ---------- Header (shared) ---------- */
  header.site{background:var(--navy-950);color:#fff;position:sticky;top:0;z-index:50;border-bottom:1px solid rgba(255,255,255,.08);}
  .header-inner{display:flex;align-items:center;gap:22px;padding:14px 28px;max-width:1180px;margin:0 auto;}
  .brand{display:flex;align-items:center;gap:12px;flex-shrink:0;}
  .brand .name-block{line-height:1.15;}
  .brand .name-block small{display:block;font-size:10px;letter-spacing:.06em;color:#8fb3ad;font-weight:600;}
  .brand .name-block strong{display:block;font-size:12.5px;font-weight:700;max-width:220px;}
  nav.primary{display:flex;align-items:center;gap:26px;margin-left:8px;flex:1;}
  nav.primary a{font-size:13px;font-weight:600;color:#cfe3e0;padding:6px 2px;border-bottom:2px solid transparent;transition:.15s;white-space:nowrap;}
  nav.primary a.active,nav.primary a:hover{color:#fff;border-color:var(--green-acc);}
  .btn-ingresar{margin-left:auto;color:#fff;padding:10px 18px;border-radius:8px;font-weight:700;font-size:13.5px;border:none;display:flex;align-items:center;gap:8px;transition:.15s;flex-shrink:0;}
  .btn-ingresar:hover{background:#57c491;}
  .nav-toggle{display:none;background:none;border:none;color:#fff;padding:4px;}

  /* ---------- Breadcrumb ---------- */
  .breadcrumb{padding:16px 0;font-size:12.5px;color:var(--ink-400);display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
  .breadcrumb a{font-weight:600;color:var(--ink-600);transition:.15s;}
  .breadcrumb a:hover{color:var(--teal-800);}
  .breadcrumb .sep{color:var(--ink-400);}
  .breadcrumb .current{color:var(--ink-900);font-weight:700;}

  /* ---------- Back link ---------- */
  .back-link{display:inline-flex;align-items:center;gap:7px;font-size:12.8px;font-weight:700;color:var(--ink-600);margin-bottom:14px;transition:.15s;}
  .back-link:hover{color:var(--teal-800);}

  /* ---------- Title header ---------- */
  .title-row{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;flex-wrap:wrap;margin-bottom:24px;}
  .title-row h1{font-size:26px;font-weight:800;margin:0 0 6px;line-height:1.25;max-width:640px;color:var(--navy-950);}
  .id-tag{font-size:12px;color:var(--ink-400);font-weight:600;}
  .title-actions{display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
  .update-chip{display:flex;align-items:center;gap:10px;font-size:11.8px;color:var(--ink-600);}
  .update-chip svg{color:var(--ink-400);}
  .update-chip strong{display:block;color:var(--ink-900);font-size:12.5px;}
  .btn-outline{
    display:flex;align-items:center;gap:8px;border:1px solid var(--line);background:#fff;
    padding:10px 16px;border-radius:8px;font-size:12.5px;font-weight:700;color:var(--ink-700);transition:.15s;
  }
  .btn-outline:hover{border-color:var(--teal-600);color:var(--teal-800);}

  /* ---------- KPI chips row ---------- */
  .kpi-row{
    background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);box-shadow:var(--shadow-card);
    display:grid;grid-template-columns:repeat(5,1fr);margin-bottom:20px;
  }
  .kpi{display:flex;align-items:center;gap:12px;padding:20px 22px;border-right:1px solid var(--line);}
  .kpi:last-child{border-right:none;}
  .kpi .ico{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;}
  .kpi .ico.navy{background:var(--navy-900);}
  .kpi .ico.amber{background:#e0a020;}
  .kpi .ico.green{background:var(--green-acc);}
  .kpi-text{display:flex;flex-direction:column;gap:2px;}
  .kpi-text .lbl{font-size:11.3px;color:var(--ink-400);font-weight:600;}
  .kpi-text .val{font-size:16.5px;font-weight:800;color:var(--ink-900);}
  .kpi-text .val.riesgo{color:var(--status-riesgo);}
  .kpi-text .val.tendencia{color:var(--status-meta);}
  .kpi-text .sub{font-size:10.8px;color:var(--ink-400);}

  /* ---------- Cumplimiento panel ---------- */
  .panel{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);box-shadow:var(--shadow-card);padding:24px 26px;}
  .cumpl-panel{margin-bottom:20px;}
  .cumpl-head{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px;}
  .cumpl-head .left span.title{display:block;font-size:12.5px;font-weight:700;color:var(--ink-600);margin-bottom:6px;}
  .cumpl-head .left .big{font-size:34px;font-weight:800;color:var(--navy-950);}
  .cumpl-head .left .sub{font-size:12px;color:var(--ink-400);margin-top:4px;}
  .cumpl-head .right{text-align:right;font-size:12px;color:var(--ink-600);}
  .cumpl-head .right strong{display:block;color:var(--status-meta);font-size:14px;}
  .cumpl-track{position:relative;height:12px;border-radius:8px;background:var(--line);overflow:visible;}
  .cumpl-fill{height:100%;border-radius:8px;background:linear-gradient(90deg,var(--navy-900),var(--teal-600));}
  .cumpl-marker{
    position:absolute;top:-8px;bottom:-8px;width:2px;background:var(--ink-400);
  }
  .cumpl-marker::after{
    content:"";position:absolute;left:50%;top:-4px;transform:translateX(-50%);
    width:6px;height:6px;border-radius:50%;background:var(--ink-600);
  }

  /* ---------- Two-column info section ---------- */
  .two-col{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;}
  .panel h3{margin:0 0 18px;font-size:14px;font-weight:800;color:var(--navy-950);display:flex;align-items:center;gap:10px;}
  .info-list{display:flex;flex-direction:column;gap:16px;}
  .info-item{display:flex;gap:12px;}
  .info-item .dot-ico{
    width:30px;height:30px;border-radius:8px;background:var(--bg-soft);color:var(--teal-800);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
  }
  .info-item strong{display:block;font-size:12.5px;font-weight:700;color:var(--navy-950);margin-bottom:3px;}
  .info-item span{font-size:12.3px;color:var(--ink-600);line-height:1.5;}

  .pdi-icon{width:40px;height:40px;border-radius:10px;background:#eaf7ef;color:var(--green-acc);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .pdi-head{display:flex;align-items:center;gap:12px;margin-bottom:16px;}
  .pdi-head h3{margin:0;}
  .pdi-meta-line{font-size:12.3px;color:var(--ink-600);margin-bottom:14px;line-height:1.6;}
  .pdi-meta-line b{color:var(--ink-900);}
  .pdi-goals{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
  .pdi-goal{background:var(--bg-soft);border-radius:10px;padding:14px;text-align:left;}
  .pdi-goal .lbl{font-size:11px;color:var(--ink-600);font-weight:700;margin-bottom:6px;}
  .pdi-goal .val{font-size:19px;font-weight:800;color:var(--navy-950);}

  /* ---------- Chart panel ---------- */
  .chart-panel{margin-bottom:20px;}
  .chart-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:12px;}
  .chart-legend{display:flex;align-items:center;gap:18px;font-size:12px;color:var(--ink-600);font-weight:600;}
  .chart-legend .lg{display:flex;align-items:center;gap:6px;}
  .chart-legend .sq{width:11px;height:11px;border-radius:3px;background:#8f6bb0;}
  .chart-legend .ln{width:16px;height:2px;background:#2f5fb0;position:relative;}
  .chart-legend .ln::after{content:"";position:absolute;left:6px;top:-2px;width:6px;height:6px;border-radius:50%;background:#2f5fb0;}
  .chart-controls{display:flex;gap:10px;}
  .chart-controls select, .chart-controls button{
    font-size:12px;font-weight:700;border:1px solid var(--line);border-radius:8px;padding:8px 14px;background:#fff;color:var(--ink-700);
  }
  .chart-controls button{display:flex;align-items:center;gap:6px;}
  canvas#histChart{width:100%;height:280px;}

  /* ---------- Historic values ---------- */
  .hist-values{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;}
  .hv-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-md);box-shadow:var(--shadow-card);padding:18px;text-align:center;}
  .hv-card.active{background:#eaf2fb;border-color:#c9dcf5;}
  .hv-card .yr{font-size:12px;color:var(--ink-600);font-weight:700;margin-bottom:8px;}
  .hv-card .pct{font-size:22px;font-weight:800;color:var(--navy-950);}

  /* ---------- Dependencias / Desagregados ---------- */
  .dep-chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;}
  .dep-chip{font-size:12px;font-weight:700;color:var(--ink-700);background:var(--bg-soft);border:1px solid var(--line);padding:7px 12px;border-radius:8px;}
  .dep-sub{font-size:11.5px;color:var(--ink-400);font-weight:700;margin:16px 0 6px;text-transform:uppercase;letter-spacing:.03em;}
  .dep-main{display:flex;align-items:center;gap:12px;background:var(--bg-soft);border-radius:10px;padding:14px;}
  .dep-main .ico{width:36px;height:36px;border-radius:50%;background:#fff;border:1px solid var(--line);display:flex;align-items:center;justify-content:center;color:var(--teal-800);flex-shrink:0;}
  .dep-main strong{font-size:12.8px;font-weight:700;color:var(--navy-950);line-height:1.4;}

  .desag-select{display:flex;justify-content:flex-end;margin-bottom:14px;}
  .desag-row{display:flex;align-items:center;gap:14px;margin-bottom:16px;}
  .desag-row .name{width:90px;flex-shrink:0;font-size:12.5px;font-weight:700;color:var(--ink-900);}
  .desag-bar{flex:1;height:8px;border-radius:5px;background:var(--line);overflow:hidden;}
  .desag-bar span{display:block;height:100%;border-radius:5px;}
  .desag-row .pct{width:52px;text-align:right;font-size:12.5px;font-weight:700;color:var(--ink-900);}
  .see-all{display:flex;align-items:center;gap:8px;font-size:12.8px;font-weight:700;color:var(--teal-800);margin-top:6px;}

  /* ---------- Metodología ---------- */
  .method-panel{margin-bottom:20px;padding:0;overflow:hidden;}
  .method-panel h3{padding:22px 26px 0;}
  .method-row{border-top:1px solid var(--line);}
  .method-row summary{
    list-style:none;display:flex;align-items:center;gap:14px;padding:16px 26px;cursor:pointer;
  }
  .method-row summary::-webkit-details-marker{display:none;}
  .method-row summary .m-ico{width:30px;height:30px;border-radius:8px;background:var(--bg-soft);color:var(--teal-800);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .method-row summary strong{font-size:12.8px;font-weight:700;width:150px;flex-shrink:0;color:var(--navy-950);}
  .method-row summary .preview{font-size:12.3px;color:var(--ink-600);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
  .method-row summary .chev{margin-left:auto;color:var(--ink-400);transition:.2s;flex-shrink:0;}
  .method-row[open] summary .chev{transform:rotate(180deg);}
  .method-row .content{padding:0 26px 18px 70px;font-size:12.5px;color:var(--ink-600);line-height:1.6;}

  /* ---------- Footer (shared) ---------- */
  footer.site{background:var(--navy-950);color:#c8d8d6;padding:44px 0 20px;margin-top:20px;}
  .footer-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:30px;padding-bottom:28px;border-bottom:1px solid rgba(255,255,255,.1);}
  .footer-brand{display:flex;gap:12px;}
  .footer-brand strong{display:block;font-size:14px;color:#fff;}
  .footer-brand p{margin:6px 0 0;font-size:11.5px;line-height:1.6;color:#93a8a5;max-width:220px;}
  footer h4{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#7fa39c;margin:0 0 14px;}
  footer ul{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;}
  footer ul a{font-size:12.8px;color:#d3e3e1;transition:.15s;}
  footer ul a:hover{color:#fff;}
  .socials{display:flex;gap:10px;margin-top:14px;}
  .socials a{width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;transition:.15s;}
  .socials a:hover{background:var(--green-acc);color:#06251b;}
  .footer-bottom{display:flex;justify-content:space-between;align-items:center;padding-top:18px;font-size:11.5px;color:#7fa39c;flex-wrap:wrap;gap:10px;}
  .footer-bottom .links{display:flex;gap:18px;flex-wrap:wrap;}

  main.wrap{padding-bottom:20px;}

  /* ---------- Responsive ---------- */
  @media (max-width:1024px){
    .kpi-row{grid-template-columns:repeat(3,1fr);}
    .kpi:nth-child(3){border-right:none;}
    .two-col{grid-template-columns:1fr;}
    .hist-values{grid-template-columns:repeat(2,1fr);}
    .footer-grid{grid-template-columns:1fr 1fr;}
  }
  @media (max-width:860px){
    nav.primary{display:none;}
    .nav-toggle{display:block;}
  }
  @media (max-width:640px){
    .kpi-row{grid-template-columns:repeat(2,1fr);}
    .kpi{border-right:none;border-bottom:1px solid var(--line);}
    .pdi-goals{grid-template-columns:1fr;}
    .method-row summary{flex-wrap:wrap;}
    .method-row summary strong{width:auto;}
    .method-row .content{padding-left:26px;}
    .wrap{padding:0 16px;}
    .footer-grid{grid-template-columns:1fr;}
  }
  :focus-visible{outline:2px solid var(--green-acc);outline-offset:2px;}
  @media (prefers-reduced-motion:reduce){*{transition:none !important;}}
</style>

<main class="wrap">

  <nav class="breadcrumb" aria-label="Ruta de navegación">
    <a href="#">Inicio</a><span class="sep">›</span>
    <a href="#">Indicadores</a><span class="sep">›</span>
    <a href="#">1. Formación de calidad para la vida</a><span class="sep">›</span>
    <span class="current">Porcentaje acumulado de programas educativos actualizados</span>
  </nav>

  <a href="#" class="back-link">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    Volver a indicadores
  </a>

  <div class="title-row">
    <div>
      <h1>Porcentaje acumulado de programas educativos actualizados</h1>
      <span class="id-tag">ID 1.1.1.15</span>
    </div>
    <div class="title-actions">
      <div class="update-chip">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
        <span>Última actualización<strong>31 de diciembre de 2025</strong></span>
      </div>
      <button class="btn-outline">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg>
        Descargar PDF
      </button>
      <button class="btn-outline">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="2.6"/><circle cx="6" cy="12" r="2.6"/><circle cx="18" cy="19" r="2.6"/><path d="M8.4 10.7 15.6 6.6M8.4 13.3l7.2 4.1"/></svg>
        Compartir
      </button>
    </div>
  </div>

  <div class="kpi-row">
    <div class="kpi">
      <div class="ico navy"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/></svg></div>
      <div class="kpi-text"><span class="lbl">Valor actual</span><span class="val">21.85%</span><span class="sub">31/12/2025</span></div>
    </div>
    <div class="kpi">
      <div class="ico navy"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3.2"/></svg></div>
      <div class="kpi-text"><span class="lbl">Meta 2025</span><span class="val">38.87%</span></div>
    </div>
    <div class="kpi">
      <div class="ico amber"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 1.8 18.5a1.8 1.8 0 0 0 1.6 2.7h17.2a1.8 1.8 0 0 0 1.6-2.7L13.7 3.9a1.8 1.8 0 0 0-3.4 0Z"/></svg></div>
      <div class="kpi-text"><span class="lbl">Estado</span><span class="val riesgo">En riesgo</span></div>
    </div>
    <div class="kpi">
      <div class="ico green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l5-5 4 3 7-9"/><path d="M14 6h6v6"/></svg></div>
      <div class="kpi-text"><span class="lbl">Tendencia</span><span class="val tendencia">Ascendente</span></div>
    </div>
    <div class="kpi">
      <div class="ico navy"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg></div>
      <div class="kpi-text"><span class="lbl">Última actualización</span><span class="val" style="font-size:14px;">31/12/2025</span></div>
    </div>
  </div>

  <div class="panel cumpl-panel">
    <div class="cumpl-head">
      <div class="left">
        <span class="title">Cumplimiento de meta 2025</span>
        <span class="big">21.85%</span>
        <span class="sub">Meta anual: 38.87%</span>
      </div>
      <div class="right">
        <span>Meta 2025</span>
        <strong>38.87%</strong>
      </div>
    </div>
    <div class="cumpl-track">
      <div class="cumpl-fill" style="width:56%"></div>
      <div class="cumpl-marker" style="left:100%"></div>
    </div>
  </div>

  <div class="two-col">
    <div class="panel">
      <h3>Información general</h3>
      <div class="info-list">
        <div class="info-item">
          <div class="dot-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 2"/></svg></div>
          <div><strong>Objetivo</strong><span>Garantizar el acceso equitativo y la permanencia educativa de la comunidad estudiantil.</span></div>
        </div>
        <div class="info-item">
          <div class="dot-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5a2 2 0 0 1 2-2h12l2 2v14l-2-2H6a2 2 0 0 0-2 2Z"/></svg></div>
          <div><strong>Temática</strong><span>1. Educación para todos</span></div>
        </div>
        <div class="info-item">
          <div class="dot-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 3v18M5 8l7-5 7 5M5 8v10M19 8v10M5 18h14"/></svg></div>
          <div><strong>Unidad de medida</strong><span>Porcentaje</span></div>
        </div>
        <div class="info-item">
          <div class="dot-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 17l6-6 4 4 8-8M15 7h6v6"/></svg></div>
          <div><strong>Tipo de indicador</strong><span>Estratégico</span></div>
        </div>
        <div class="info-item">
          <div class="dot-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 17l5-5 4 3 7-9M14 6h6v6"/></svg></div>
          <div><strong>Sentido del indicador</strong><span>Ascendente</span></div>
        </div>
        <div class="info-item">
          <div class="dot-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg></div>
          <div><strong>Periodicidad</strong><span>Anual</span></div>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="pdi-head">
        <div class="pdi-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 1 5 5c0 3-5 5-5 5s-5-2-5-5a5 5 0 0 1 5-5Z"/><path d="M12 12v10M8 22h8"/></svg></div>
        <h3 style="margin:0;">Alineación con el PDI</h3>
      </div>
      <div class="pdi-meta-line">
        <b>Temática:</b> 1. Educación para todos<br>
        <b>Objetivo:</b> Garantizar el acceso equitativo y la permanencia educativa de la comunidad estudiantil.
      </div>
      <div class="pdi-goals">
        <div class="pdi-goal"><div class="lbl">Meta 2025</div><div class="val">38.87%</div></div>
        <div class="pdi-goal"><div class="lbl">Meta PDI 2028</div><div class="val">64.29%</div></div>
        <div class="pdi-goal"><div class="lbl">Meta PDI 2031</div><div class="val">76.53%</div></div>
      </div>
    </div>
  </div>

  <div class="panel chart-panel">
    <div class="chart-head">
      <h3 style="margin:0;">Comportamiento histórico</h3>
      <div class="chart-legend">
        <span class="lg"><span class="sq"></span>Meta</span>
        <span class="lg"><span class="ln"></span>Valor</span>
      </div>
      <div class="chart-controls">
        <select><option>Todos los años</option></select>
        <button><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg>Descargar gráfica</button>
      </div>
    </div>
    <canvas id="histChart"></canvas>
  </div>

  <div class="panel" style="margin-bottom:20px;">
    <h3>Valores históricos</h3>
    <div class="hist-values">
      <div class="hv-card"><div class="yr">2022</div><div class="pct">45.06%</div></div>
      <div class="hv-card"><div class="yr">2023</div><div class="pct">12.93%</div></div>
      <div class="hv-card"><div class="yr">2024</div><div class="pct">17.70%</div></div>
      <div class="hv-card active"><div class="yr">2025</div><div class="pct">21.85%</div></div>
    </div>
  </div>

  
  <div class="panel" style="margin-bottom:20px;">
    <h3>Dependencias responsables</h3>
    <div class="dep-sub">Dependencia responsable del seguimiento</div>
    <div class="dep-main">
      <div class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 2"/></svg></div>
      <strong>Coordinación de planeación</strong>
    </div>
    <div class="dep-sub">Dependencias generadoras de información</div>
    <div class="dep-chips">
      <span class="dep-chip">Coordinación de tecnologías para el aprendizaje</span>
      <span class="dep-chip">Coordinación de personal</span>
      <span class="dep-chip">División de Estudios de Estado y Sociedad</span>
    </div>
  </div>

  

  <div class="panel method-panel">
    <h3>Metodología de cálculo</h3>
    <details class="method-row" open>
      <summary>
        <span class="m-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="7" height="7" rx="1"/><rect x="14" y="4" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span>
        <strong>Variables</strong>
        <span class="preview">PEA - Programas educativos actualizados, PEO - Programas educativos ofertados</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
      </summary>
      <div class="content">PEA — Programas educativos actualizados: total de programas educativos que han sido revisados y actualizados en el periodo. PEO — Programas educativos ofertados: total de programas educativos vigentes ofertados por la institución.</div>
    </details>
    <details class="method-row">
      <summary>
        <span class="m-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h6"/></svg></span>
        <strong>Algoritmo de cálculo</strong>
        <span class="preview">(PEA / PEO) * 100</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
      </summary>
      <div class="content">El indicador se calcula dividiendo el número de programas educativos actualizados (PEA) entre el total de programas educativos ofertados (PEO), multiplicado por 100 para expresarlo como porcentaje.</div>
    </details>
    <details class="method-row">
      <summary>
        <span class="m-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 3v5h5"/><path d="M6 3h8l5 5v13H6z"/></svg></span>
        <strong>Fuentes de información</strong>
        <span class="preview">Dictámenes de programas educativos del Consejo General Universitario (CGU), Minutas de los Colegios Departamentales…</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
      </summary>
      <div class="content">Dictámenes de programas educativos del Consejo General Universitario (CGU); Minutas de los Colegios Departamentales; Registros administrativos de la Coordinación General Académica y de Innovación.</div>
    </details>
    <details class="method-row">
      <summary>
        <span class="m-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg></span>
        <strong>Fecha de corte</strong>
        <span class="preview">31 de diciembre de 2025</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
      </summary>
      <div class="content">Los datos reportados corresponden al corte del 31 de diciembre de 2025 y serán actualizados en el siguiente ciclo de reporte anual.</div>
    </details>
  </div>

</main>

<script>
  /* ---------------- Historic chart (bar = meta, line = valor) ---------------- */
  (function drawHistChart(){
    const canvas = document.getElementById('histChart');
    const dpr = window.devicePixelRatio || 1;
    const cssW = canvas.parentElement.clientWidth;
    const cssH = 280;
    canvas.width = cssW * dpr;
    canvas.height = cssH * dpr;
    canvas.style.width = cssW + 'px';
    canvas.style.height = cssH + 'px';
    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);

    const years = [2022,2023,2024,2025,2026,2027,2028,2029,2030,2031];
    const meta  = [42, 48, 59, 20, 50, 55, 62, 66, 70, 76];
    const valor = [42, 13, 15, 21.85, null, null, null, null, null, null];

    const padL = 40, padR = 16, padT = 10, padB = 34;
    const chartW = cssW - padL - padR;
    const chartH = cssH - padT - padB;
    const maxY = 100;

    // gridlines + y labels
    ctx.font = '11px Segoe UI, sans-serif';
    ctx.fillStyle = '#7c8c92';
    ctx.strokeStyle = '#e4e9ea';
    ctx.lineWidth = 1;
    for(let v=0; v<=100; v+=20){
      const y = padT + chartH - (v/maxY)*chartH;
      ctx.beginPath();
      ctx.moveTo(padL, y);
      ctx.lineTo(padL+chartW, y);
      ctx.stroke();
      ctx.textAlign = 'right';
      ctx.fillText(v, padL-8, y+4);
    }

    // bars (meta)
    const n = years.length;
    const slot = chartW / n;
    const barW = slot * 0.42;
    ctx.fillStyle = '#8f6bb0';
    years.forEach((yr,i)=>{
      const bh = (meta[i]/maxY) * chartH;
      const x = padL + i*slot + slot/2 - barW/2;
      const y = padT + chartH - bh;
      ctx.fillRect(x, y, barW, bh);
    });

    // x labels
    ctx.fillStyle = '#4c5f66';
    ctx.textAlign = 'center';
    years.forEach((yr,i)=>{
      const x = padL + i*slot + slot/2;
      ctx.fillText(yr, x, cssH - 12);
    });

    // line (valor) - only where not null
    ctx.beginPath();
    let started = false;
    const points = [];
    years.forEach((yr,i)=>{
      if(valor[i]===null) return;
      const x = padL + i*slot + slot/2;
      const y = padT + chartH - (valor[i]/maxY)*chartH;
      points.push([x,y]);
    });
    points.forEach((p,i)=>{
      i===0 ? ctx.moveTo(p[0],p[1]) : ctx.lineTo(p[0],p[1]);
    });
    ctx.strokeStyle = '#2f5fb0';
    ctx.lineWidth = 2.4;
    ctx.lineJoin = 'round';
    ctx.stroke();
    points.forEach(p=>{
      ctx.beginPath();
      ctx.arc(p[0],p[1],3.6,0,Math.PI*2);
      ctx.fillStyle = '#2f5fb0';
      ctx.fill();
      ctx.strokeStyle = '#fff';
      ctx.lineWidth = 1.4;
      ctx.stroke();
    });

    // y axis label
    ctx.save();
    ctx.translate(12, padT + chartH/2);
    ctx.rotate(-Math.PI/2);
    ctx.textAlign = 'center';
    ctx.fillStyle = '#7c8c92';
    ctx.font = '11px Segoe UI, sans-serif';
    ctx.fillText('Porcentaje (%)', 0, 0);
    ctx.restore();
  })();

  /* ---------------- Desagregados ---------------- */
  const DESAG = [
    {name:'CUCEA', pct:89.21, color:'#1c8a53'},
    {name:'CUCSH', pct:78.45, color:'#274a7a'},
    {name:'CUAltos', pct:68.13, color:'#e0a020'},
    {name:'CUCosta Sur', pct:64.87, color:'#8f6bb0'},
    {name:'CUCiencia', pct:92.34, color:'#1c8a53'},
  ];
  const desagList = document.getElementById('desagList');
  DESAG.forEach(d=>{
    const row = document.createElement('div');
    row.className = 'desag-row';
    row.innerHTML = `
      <span class="name">${d.name}</span>
      <div class="desag-bar"><span style="width:${d.pct}%;background:${d.color}"></span></div>
      <span class="pct">${d.pct}%</span>
    `;
    desagList.appendChild(row);
  });

  /* ---------------- Mobile nav ---------------- */
  const navToggle = document.getElementById('navToggle');
  const primaryNav = document.querySelector('nav.primary');
  navToggle.addEventListener('click', ()=>{
    const isOpen = primaryNav.style.display === 'flex';
    primaryNav.style.display = isOpen ? 'none' : 'flex';
    primaryNav.style.cssText += isOpen ? '' : `
      position:absolute;top:64px;left:0;right:0;background:var(--navy-950);
      flex-direction:column;align-items:flex-start;padding:16px 28px;gap:14px;
      border-bottom:1px solid rgba(255,255,255,.1);
    `;
  });
  document.getElementById('btnIngresar').addEventListener('click', ()=>{
    alert('Acceso al panel administrativo de SIME (demo).');
  });

  window.addEventListener('resize', ()=>{ location.reload(); });
</script>

@endsection
