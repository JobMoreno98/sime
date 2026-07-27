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
    --status-sin:#5b6b70;
    --status-sin-bg:#eef2f2;

    --radius-lg:16px;
    --radius-md:10px;
    --shadow-card:0 1px 2px rgba(10,37,48,.06), 0 8px 24px -12px rgba(10,37,48,.15);
  }

  *{box-sizing:border-box;}
  body{
    margin:0;
    font-family:'Montserrat';
    color:var(--ink-900);
    background:var(--bg-soft);
    -webkit-font-smoothing:antialiased;
  }
  img,svg{display:block;}
  a{color:inherit;text-decoration:none;}
  button,select{font-family:inherit;cursor:pointer;}

  .wrap{max-width:1180px;margin:0 auto;padding:0 28px;}

  /* ---------- Header (shared) ---------- */
  header.site{
    background:var(--navy-950);color:#fff;position:sticky;top:0;z-index:50;
    border-bottom:1px solid rgba(255,255,255,.08);
  }
  .header-inner{
    display:flex;align-items:center;gap:22px;padding:14px 28px;max-width:1180px;margin:0 auto;
  }
  .brand{display:flex;align-items:center;gap:12px;flex-shrink:0;}

  .brand .name-block{line-height:1.15;}
  .brand .name-block small{display:block;font-size:10px;letter-spacing:.06em;color:#8fb3ad;font-weight:600;}
  .brand .name-block strong{display:block;font-size:12.5px;font-weight:700;max-width:220px;}

  nav.primary{display:flex;align-items:center;gap:26px;margin-left:8px;flex:1;}
  nav.primary a{
    font-size:13px;font-weight:600;color:#cfe3e0;padding:6px 2px;
    border-bottom:2px solid transparent;transition:.15s;white-space:nowrap;
  }
  nav.primary a.active,nav.primary a:hover{color:#fff;border-color:var(--green-acc);}


  .nav-toggle{display:none;background:none;border:none;color:#fff;padding:4px;}

  /* ---------- Page intro / stats strip ---------- */
  .page-top{background:var(--navy-950);padding-bottom:34px;}
  .stats-card{
    background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-card);
    display:grid;grid-template-columns:repeat(5,1fr) auto;align-items:center;
    padding:26px 30px;gap:10px;
  }
  .stat{display:flex;flex-direction:column;align-items:center;gap:10px;text-align:center;
    border-right:1px solid var(--line);padding:0 14px;}
  .stat:last-of-type{border-right:none;}
  .stat .ico{
    width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;
    color:#fff;
  }
  .stat .ico.c1{background:var(--navy-900);}
  .stat .ico.c2{background:var(--teal-600);}
  .stat .ico.c3{background:var(--green-acc);}
  .stat .ico.c4{background:#b6791a;}
  .stat .ico.c5{background:#c1552c;}
  .stat .num{font-size:26px;font-weight:800;color:var(--ink-900);}
  .stat .lbl{font-size:12px;color:var(--ink-600);line-height:1.35;}
  .illus{display:flex;align-items:center;justify-content:center;padding-left:10px;}

  /* ---------- Layout below ---------- */
  main.wrap{padding-top:28px;padding-bottom:44px;}

  .tools-grid{display:grid;grid-template-columns:4fr 1fr;gap:16px;margin-bottom:20px;}
  .panel{
    background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);
    box-shadow:var(--shadow-card);padding:22px 24px;
  }
  .panel h3{
    margin:0 0 18px;font-size:13px;font-weight:800;letter-spacing:.03em;
    color:var(--ink-900);display:flex;align-items:center;justify-content:space-between;
  }
  .panel h3 svg{color:var(--ink-400);}

  .filters-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px 16px;}
  .field{display:flex;flex-direction:column;gap:6px;}
  .field label{font-size:11.5px;font-weight:700;color:var(--ink-600);}
  .field select{
    appearance:none;-webkit-appearance:none;
    border:1px solid var(--line);border-radius:8px;padding:10px 32px 10px 12px;font-size:12.8px;
    color:var(--ink-900);background:#fff url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%234c5f66" stroke-width="2.4"><path d="M6 9l6 6 6-6"/></svg>') no-repeat right 10px center;
    background-size:12px;transition:.15s;
  }
  .field select:hover{border-color:var(--teal-600);}

  .filters-actions{display:flex;align-items:center;gap:18px;margin-top:18px;}
  .btn-primary{
    background:var(--navy-900);color:#fff;border:none;padding:11px 20px;border-radius:8px;
    font-weight:700;font-size:12.8px;transition:.15s;
  }
  .btn-primary:hover{background:var(--teal-800);}
  .btn-ghost{
    background:none;border:none;color:var(--ink-600);font-weight:700;font-size:12.8px;
    display:flex;align-items:center;gap:6px;
  }
  .btn-ghost:hover{color:var(--navy-900);}

  .legend-list{display:flex;flex-direction:column;gap:14px;}
  .legend-item{display:flex;align-items:center;gap:10px;font-size:13px;font-weight:600;color:var(--ink-700);}
  .legend-dot{width:11px;height:11px;border-radius:3px;flex-shrink:0;}
  .legend-item.riesgo .legend-dot{background:var(--status-riesgo);}
  .legend-item.proceso .legend-dot{background:var(--status-proceso);}
  .legend-item.meta .legend-dot{background:var(--status-meta);}

  .info-panel p{font-size:12.5px;color:var(--ink-600);line-height:1.6;margin:0 0 16px;}
  .link-btn{
    display:inline-flex;align-items:center;gap:8px;background:var(--bg-soft);
    border:1px solid var(--line);padding:10px 16px;border-radius:8px;font-size:12.5px;
    font-weight:700;color:var(--navy-900);transition:.15s;
  }
  .link-btn:hover{background:var(--navy-900);color:#fff;}

  /* ---------- View toggle ---------- */
  .view-toggle{display:flex;align-items:center;gap:22px;margin-bottom:14px;}
  .view-toggle button{
    background:none;border:none;display:flex;align-items:center;gap:7px;
    font-size:13px;font-weight:700;color:var(--ink-400);padding-bottom:10px;border-bottom:2px solid transparent;
    transition:.15s;
  }
  .view-toggle button.active{color:var(--navy-900);border-color:var(--green-acc);}

  /* ---------- Table ---------- */
  .table-panel{
    background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);
    box-shadow:var(--shadow-card);overflow:hidden;
  }
  table{width:100%;border-collapse:collapse;}
  thead tr{background:var(--navy-950);}
  thead th{
    color:#cfe3e0;font-size:11.3px;font-weight:700;letter-spacing:.03em;text-transform:none;
    text-align:left;padding:14px 16px;white-space:nowrap;
  }
  thead th:first-child{padding-left:20px;}
  tbody tr{border-bottom:1px solid var(--line);transition:.15s;}
  tbody tr:hover{background:var(--bg-soft);}
  tbody tr:last-child{border-bottom:none;}
  tbody td{padding:16px;font-size:12.8px;vertical-align:middle;color:var(--ink-700);}
  tbody td:first-child{padding-left:20px;}

  .ind-cell{display:flex;align-items:flex-start;gap:12px;max-width:320px;}
  .ind-ico{
    width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;
    flex-shrink:0;color:#fff;
  }
  .ind-text strong{display:block;font-size:12.8px;font-weight:700;color:var(--ink-900);line-height:1.4;}
  .ind-text span{font-size:11.3px;color:var(--ink-400);}

  .badge{
    display:inline-block;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;
    white-space:nowrap;
  }
  .badge.meta{background:var(--status-meta-bg);color:var(--status-meta);}
  .badge.proceso{background:var(--status-proceso-bg);color:var(--status-proceso);}
  .badge.riesgo{background:var(--status-riesgo-bg);color:var(--status-riesgo);}
  .badge.sin{background:var(--status-sin-bg);color:var(--status-sin);}

  .cumpl-cell{min-width:130px;}
  .cumpl-pct{font-weight:800;font-size:13px;margin-bottom:6px;}
  .cumpl-bar{height:6px;border-radius:4px;background:var(--line);overflow:hidden;}
  .cumpl-bar span{display:block;height:100%;border-radius:4px;}
  .cumpl-pct.meta{color:var(--status-meta);} .cumpl-bar.meta span{background:var(--status-meta);}
  .cumpl-pct.proceso{color:var(--status-proceso);} .cumpl-bar.proceso span{background:var(--status-proceso);}
  .cumpl-pct.riesgo{color:var(--status-riesgo);} .cumpl-bar.riesgo span{background:var(--status-riesgo);}

  .actions-btn{background:none;border:none;color:var(--ink-400);padding:6px;border-radius:6px;}
  .actions-btn:hover{background:var(--bg-soft);color:var(--ink-900);}

  /* ---------- Pagination ---------- */
  .pagination{
    display:flex;align-items:center;justify-content:center;gap:8px;padding:22px 16px;
  }
  .pagination button{
    width:32px;height:32px;border-radius:8px;border:1px solid var(--line);background:#fff;
    display:flex;align-items:center;justify-content:center;font-size:12.5px;font-weight:700;
    color:var(--ink-600);transition:.15s;
  }
  .pagination button:hover{border-color:var(--teal-600);color:var(--teal-800);}
  .pagination button.active{background:var(--navy-900);border-color:var(--navy-900);color:#fff;}
  .pagination .dots{color:var(--ink-400);font-size:13px;padding:0 4px;}

  /* ---------- Footer (shared) ---------- */
  footer.site{background:var(--navy-950);color:#c8d8d6;padding:44px 0 20px;margin-top:20px;}
  .footer-grid{
    display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:30px;padding-bottom:28px;
    border-bottom:1px solid rgba(255,255,255,.1);
  }
  .footer-brand{display:flex;gap:12px;}

  .footer-brand strong{display:block;font-size:14px;color:#fff;}
  .footer-brand p{margin:6px 0 0;font-size:11.5px;line-height:1.6;color:#93a8a5;max-width:220px;}
  footer h4{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#7fa39c;margin:0 0 14px;}
  footer ul{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;}
  footer ul a{font-size:12.8px;color:#d3e3e1;transition:.15s;}
  footer ul a:hover{color:#fff;}
  .socials{display:flex;gap:10px;margin-top:14px;}
  .socials a{
    width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.08);
    display:flex;align-items:center;justify-content:center;transition:.15s;
  }
  .socials a:hover{background:var(--green-acc);color:#06251b;}
  .footer-bottom{
    display:flex;justify-content:space-between;align-items:center;padding-top:18px;
    font-size:11.5px;color:#7fa39c;flex-wrap:wrap;gap:10px;
  }
  .footer-bottom .links{display:flex;gap:18px;flex-wrap:wrap;}

  /* ---------- Responsive ---------- */
  @media (max-width:1024px){
    .tools-grid{grid-template-columns:1fr;}
    .stats-card{grid-template-columns:repeat(2,1fr);}
    .illus{display:none;}
    .filters-grid{grid-template-columns:repeat(2,1fr);}
    .footer-grid{grid-template-columns:1fr 1fr;}
  }
  @media (max-width:860px){
    nav.primary{display:none;}
    .nav-toggle{display:block;}
  }
  @media (max-width:640px){
    .stats-card{grid-template-columns:1fr 1fr;padding:20px;}
    .stat{border-right:none;border-bottom:1px solid var(--line);padding-bottom:14px;}
    .filters-grid{grid-template-columns:1fr;}
    .wrap{padding:0 16px;}
    table{display:block;overflow-x:auto;}
    .footer-grid{grid-template-columns:1fr;}
  }
  :focus-visible{outline:2px solid var(--green-acc);outline-offset:2px;}
  @media (prefers-reduced-motion:reduce){*{transition:none !important;}}
</style>

<section class="page-top">
  <div class="wrap" style="padding-top:26px;">
    <div class="stats-card">
      <div class="stat">
        <div class="ico c1"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5 9 5-9 5-9-5Z"/><path d="M3 15l9 5 9-5M3 9v6M21 9v6"/></svg></div>
        <div class="num" id="statResultados">53</div>
        <div class="lbl">Resultados</div>
      </div>
      <div class="stat">
        <div class="ico c2"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg></div>
        <div class="num">31/12/2025</div>
        <div class="lbl">Última actualización<br>de datos</div>
      </div>
      <div class="stat">
        <div class="ico c3"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3.4"/></svg></div>
        <div class="num" id="statMeta">7</div>
        <div class="lbl">En meta</div>
      </div>
      <div class="stat" >
        <div class="ico c4"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <div class="num" id="statProceso">28</div>
        <div class="lbl">En proceso</div>
      </div>
      <div class="stat" style="border-right:none;">
        <div class="ico c5"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <div class="num" id="statProceso">18</div>
        <div class="lbl">En riesgo</div>
      </div>
    </div>
  </div>
</section>

<main class="wrap">

  <div class="tools-grid">
    <div class="panel">
      <h3>FILTRAR INDICADORES <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16l-6 8v6l-4 2v-8L4 4Z"/></svg></h3>
      <div class="filters-grid">
        <div class="field">
          <label>Eje</label>
          <select><option>1. Formación de calidad para la vida</option><option>2. Generar conocimiento</option><option>3. Vínculo social</option></select>
        </div>
        <div class="field">
          <label>Temática</label>
          <select><option>Todas</option></select>
        </div>
        <div class="field">
          <label>Tipo</label>
          <select><option>Todos</option></select>
        </div>
        <div class="field">
          <label>Periodicidad</label>
          <select><option>Todas</option></select>
        </div>
        <div class="field">
          <label>Nivel Jerárquico</label>
          <select><option>Todos</option></select>
        </div>
        <div class="field">
          <label>ODS</label>
          <select><option>Todos</option></select>
        </div>
        <div class="field">
          <label>Orden</label>
          <select><option>Más recientes</option></select>
        </div>
      </div>
      <div class="filters-actions">
        <button class="btn-primary" id="btnAplicar">Aplicar filtros</button>
        <button class="btn-ghost" id="btnLimpiar">Limpiar filtros
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M21 12a9 9 0 1 1-3-6.7"/><path d="M21 3v6h-6"/></svg>
        </button>
      </div>
    </div>

    <div class="panel">
      <h3>PORCENTAJE DE CUMPLIMIENTO DE META</h3>
      <div class="legend-list">
        <div class="legend-item riesgo"><span class="legend-dot"></span> Menor a 80%</div>
        <div class="legend-item proceso"><span class="legend-dot"></span> 80% al 99%</div>
        <div class="legend-item meta"><span class="legend-dot"></span> 100% o más</div>
      </div>
    </div>
  </div>

  <div class="view-toggle">
    <button class="active" id="viewList">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
      Vista de lista
    </button>
    <button id="viewCard">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Vista de tarjeta
    </button>
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
          <th>Tendencia</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tableBody"></tbody>
    </table>
  </div>

  <div class="pagination" id="pagination">
    <button aria-label="Anterior">‹</button>
    <button class="active">1</button>
    <button>2</button>
    <button>3</button>
    <button>4</button>
    <span class="dots">…</span>
    <button>5</button>
    <button aria-label="Siguiente">›</button>
  </div>

</main>

<script>
/* ---------------- Data ---------------- */
const INDICATORS = [
  {icon:'grupo', color:'var(--navy-900)', title:'Matrícula total de la Universidad de Guadalajara', sub:'Estudiantes', status:'proceso', valor:'344,540', meta:'400,000', cumpl:86.13, updated:'31/12/2025', trend:[4,6,5,7,6,8,7,9], trendColor:'#274a7a'},
  {icon:'persona', color:'var(--teal-600)', title:'Personal académico', sub:'', status:'sin', valor:'0', meta:'—', cumpl:null, updated:'31/12/2025', trend:[3,4,4,5,6,6,7,8], trendColor:'#1a7a6e'},
  {icon:'grad', color:'#7a1f3d', title:'Porcentaje acumulado de programas educativos actualizados', sub:'', status:'riesgo', valor:'21.85%', meta:'100%', cumpl:21.85, updated:'31/12/2025', trend:[6,5,6,4,5,4,3,4], trendColor:'#7a1f3d'},
  {icon:'grupo', color:'var(--navy-900)', title:'Porcentaje de alumnos de educación media superior que se mantienen activos un año después de haber ingresado', sub:'', status:'proceso', valor:'87.18%', meta:'100%', cumpl:87.18, updated:'31/12/2025', trend:[4,5,7,6,8,7,9,8], trendColor:'#274a7a'},
  {icon:'libro', color:'var(--green-acc)', title:'Porcentaje de alumnos de posgrado que se mantienen activos un año después de haber ingresado', sub:'', status:'meta', valor:'88.67%', meta:'85%', cumpl:104.32, updated:'31/12/2025', trend:[5,6,6,7,8,8,9,9], trendColor:'#1c8a53'},
  {icon:'pc', color:'var(--teal-800)', title:'Porcentaje de alumnos de pregrado que se mantienen activos un año después de haber ingresado', sub:'', status:'proceso', valor:'80.34%', meta:'85%', cumpl:94.52, updated:'31/12/2025', trend:[6,5,6,7,6,7,8,7], trendColor:'#274a7a'},
  {icon:'globo', color:'var(--teal-600)', title:'Porcentaje de alumnos que se mantienen activos un año después de haber egresado respecto al total de admitidos en la cohorte (global)', sub:'', status:'proceso', valor:'84.93%', meta:'90%', cumpl:94.37, updated:'31/12/2025', trend:[5,6,7,6,7,8,7,8], trendColor:'#1a7a6e'},
  {icon:'medalla', color:'var(--green-acc)', title:'Porcentaje de aspirantes a nivel licenciatura admitidos respecto al total de personas que aspiran ingresar a la Universidad', sub:'', status:'meta', valor:'31.93%', meta:'30%', cumpl:106.43, updated:'30/04/2026', trend:[3,5,4,6,5,7,6,8], trendColor:'#274a7a'},
  {icon:'edificio', color:'#c1552c', title:'Porcentaje de aspirantes a nivel media superior admitidos respecto al total de personas que aspiran ingresar a la Universidad', sub:'', status:'proceso', valor:'59.32%', meta:'60%', cumpl:98.87, updated:'31/12/2025', trend:[6,6,7,6,7,7,8,8], trendColor:'#c1552c'},
  {icon:'persona2', color:'#7a1f3d', title:'Porcentaje de aspirantes a nivel posgrado admitidos respecto al total de personas que aspiran ingresar a la Universidad', sub:'', status:'riesgo', valor:'40.38%', meta:'60%', cumpl:67.30, updated:'31/12/2025', trend:[6,5,7,5,6,4,5,4], trendColor:'#7a1f3d'},
];

const ICONS = {
  grupo:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M2 20c0-3.3 3-6 7-6s7 2.7 7 6"/><circle cx="17" cy="8" r="2.4"/><path d="M16 14.2c2.7.4 5 2.7 5 5.8"/></svg>',
  persona:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>',
  grad:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/></svg>',
  libro:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5c3 0 6 1 8 3 2-2 5-3 8-3v14c-3 0-6 1-8 3-2-2-5-3-8-3Z"/></svg>',
  pc:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 21h8M12 16v5"/></svg>',
  globo:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 4 6 4 9s-1.5 6.4-4 9c-2.5-2.6-4-6-4-9s1.5-6.4 4-9Z"/></svg>',
  medalla:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5"/><path d="M8 13.5 6 21l6-3 6 3-2-7.5"/></svg>',
  edificio:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V9l7-4 7 4v12M9 21v-6h6v6"/></svg>',
  persona2:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5 21v-1a7 7 0 0 1 14 0v1"/></svg>',
};

const STATUS_LABEL = {meta:'En meta', proceso:'En proceso', riesgo:'En riesgo', sin:'Sin meta'};

function cumplClass(status){
  if(status==='meta') return 'meta';
  if(status==='riesgo') return 'riesgo';
  if(status==='proceso') return 'proceso';
  return '';
}

/* ---------------- Render table ---------------- */
const tbody = document.getElementById('tableBody');
INDICATORS.forEach((row,idx)=>{
  const tr = document.createElement('tr');
  const cls = cumplClass(row.status);
  const barWidth = row.cumpl===null ? 0 : Math.min(row.cumpl,100);
  tr.innerHTML = `
    <td>
      <div class="ind-cell">
        <div class="ind-ico" style="background:${row.color}">${ICONS[row.icon]}</div>
        <div class="ind-text">
          <a href="/detalle-indicador/1/1">
          <strong>${row.title}</strong>
          ${row.sub ? `<span>${row.sub}</span>` : ''}
          </a>
        </div>
      </div>
    </td>
    <td><span class="badge ${row.status}">${STATUS_LABEL[row.status]}</span></td>
    <td>${row.valor}</td>
    <td>${row.meta}</td>
    <td class="cumpl-cell">
      ${row.cumpl===null ? '<span style="color:var(--ink-400);font-weight:700;">—</span>' : `
        <div class="cumpl-pct ${cls}">${row.cumpl}%</div>
        <div class="cumpl-bar ${cls}"><span style="width:${barWidth}%"></span></div>
      `}
    </td>
    <td>${row.updated}</td>
    <td><canvas class="trend-canvas" width="70" height="28" data-trend="${row.trend.join(',')}" data-color="${row.trendColor}"></canvas></td>
    <td><button class="actions-btn" aria-label="Más acciones">⋮</button></td>
  `;
  tbody.appendChild(tr);
});

/* draw trend sparklines */
document.querySelectorAll('.trend-canvas').forEach(cv=>{
  const trend = cv.dataset.trend.split(',').map(Number);
  const color = cv.dataset.color;
  const ctx = cv.getContext('2d');
  const w = cv.width, h = cv.height, pad = 4;
  const min = Math.min(...trend), max = Math.max(...trend);
  const range = (max-min) || 1;
  ctx.beginPath();
  trend.forEach((v,i)=>{
    const x = pad + (i/(trend.length-1)) * (w-pad*2);
    const y = h - pad - ((v-min)/range) * (h-pad*2);
    i===0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
  });
  ctx.strokeStyle = color;
  ctx.lineWidth = 1.6;
  ctx.lineJoin = 'round';
  ctx.stroke();
  trend.forEach((v,i)=>{
    const x = pad + (i/(trend.length-1)) * (w-pad*2);
    const y = h - pad - ((v-min)/range) * (h-pad*2);
    ctx.beginPath();
    ctx.arc(x,y,1.6,0,Math.PI*2);
    ctx.fillStyle = color;
    ctx.fill();
  });
});

/* ---------------- Stats counters ---------------- */
document.getElementById('statResultados').textContent = INDICATORS.length + ' resultados'.length ? '53' : '';
document.getElementById('statResultados').textContent = '53';
document.getElementById('statMeta').textContent = INDICATORS.filter(r=>r.status==='meta').length ? '7' : '0';
document.getElementById('statProceso').textContent = '28';

/* ---------------- View toggle ---------------- */
const viewList = document.getElementById('viewList');
const viewCard = document.getElementById('viewCard');
viewList.addEventListener('click', ()=>{ viewList.classList.add('active'); viewCard.classList.remove('active'); });
viewCard.addEventListener('click', ()=>{ viewCard.classList.add('active'); viewList.classList.remove('active'); alert('Vista de tarjeta (demo).'); });

/* ---------------- Filters demo ---------------- */
document.getElementById('btnAplicar').addEventListener('click', ()=>{
  document.querySelector('.table-panel').scrollIntoView({behavior:'smooth', block:'start'});
});
document.getElementById('btnLimpiar').addEventListener('click', ()=>{
  document.querySelectorAll('.field select').forEach(s=> s.selectedIndex = 0);
});

/* ---------------- Pagination demo ---------------- */
document.querySelectorAll('.pagination button').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    if(!/^[0-9]+$/.test(btn.textContent.trim())) return;
    document.querySelectorAll('.pagination button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
  });
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
</script>

@endsection
