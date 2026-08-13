import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
// FullCalendar
import { Calendar } from '@fullcalendar/core';



window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Chart imports
    if (document.querySelector('#chartOne')) {
        import('./components/chart/chart-1').then(module => module.initChartOne());
    }
    if (document.querySelector('#chartTwo')) {
        import('./components/chart/chart-2').then(module => module.initChartTwo());
    }
    if (document.querySelector('#chartThree')) {
        import('./components/chart/chart-3').then(module => module.initChartThree());
    }
    if (document.querySelector('#chartSix')) {
        import('./components/chart/chart-6').then(module => module.initChartSix());
    }
    if (document.querySelector('#chartEight')) {
        import('./components/chart/chart-8').then(module => module.initChartEight());
    }
    if (document.querySelector('#chartThirteen')) {
        import('./components/chart/chart-13').then(module => module.initChartThirteen());
    }

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }
});



// Dataset interactivo basado en la estructura institucional
const indicadores = [
  {
    id: 1,
    eje: 1,
    nombre: "Matrícula total de la Universidad",
    valor: "344,540",
    unidad: "Estudiantes",
    estado: "En proceso",
    periodicidad: "Anual",
    tipo: "Estratégico"
  },
  {
    id: 2,
    eje: 1,
    nombre: "Porcentaje acumulado de programas actualizados",
    valor: "21.85%",
    unidad: "Porcentaje",
    estado: "En riesgo",
    periodicidad: "Anual",
    tipo: "Estratégico"
  },
  {
    id: 3,
    eje: 1,
    nombre: "Retención de alumnos de posgrado",
    valor: "88.67%",
    unidad: "Porcentaje",
    estado: "En meta",
    periodicidad: "Semestral",
    tipo: "Estratégico"
  },
  {
    id: 4,
    eje: 2,
    nombre: "Profesores en el Sistema Nacional de Investigadores (SNII)",
    valor: "1,240",
    unidad: "Docentes",
    estado: "En meta",
    periodicidad: "Anual",
    tipo: "Estratégico"
  },
  {
    id: 5,
    eje: 3,
    nombre: "Aspirantes admitidos a Nivel Superior",
    valor: "31.93%",
    unidad: "Porcentaje",
    estado: "En meta",
    periodicidad: "Semestral",
    tipo: "Estratégico"
  },
  {
    id: 6,
    eje: 4,
    nombre: "Participación en eventos de vinculación cultural",
    valor: "59.32%",
    unidad: "Porcentaje",
    estado: "En proceso",
    periodicidad: "Semestral",
    tipo: "Complementario"
  }
];

// Elementos del DOM
const cardsGrid = document.getElementById('cardsGrid');
const searchInput = document.getElementById('searchInput');
const filterEje = document.getElementById('filterEje');
const filterPeriod = document.getElementById('filterPeriod');
const filterStatusBoxes = document.querySelectorAll('.filterStatus');
const resetBtn = document.getElementById('resetFilters');

// Renderizar tarjetas dinámicamente
function renderCards(items) {
  cardsGrid.innerHTML = '';

  if (items.length === 0) {
    cardsGrid.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #64748B; padding: 2rem;">No se encontraron indicadores que coincidan con los filtros.</p>`;
    return;
  }

  items.forEach(item => {
    const statusClass = item.estado === 'En meta' ? 'meta' : item.estado === 'En proceso' ? 'proceso' : 'riesgo';
    
    const cardHTML = `
      <div class="indicator-card">
        <div>
          <div class="card-top">
            <span class="card-title">${item.nombre}</span>
            <span class="status-badge ${statusClass}">${item.estado}</span>
          </div>
          <div class="metric-value">${item.valor}</div>
          <div class="metric-sub">${item.unidad}</div>
          <div class="mini-graph"></div>
        </div>
        <div class="card-meta">
          <span>Eje ${item.eje}</span>
          <span>${item.periodicidad}</span>
        </div>
      </div>
    `;
    cardsGrid.insertAdjacentHTML('beforeend', cardHTML);
  });

  // Re-inicializar iconos visuales Lucide
  lucide.createIcons();
}

// Función de Filtrado Combinado
function applyFilters() {
  const query = searchInput.value.toLowerCase();
  const ejeValue = filterEje.value;
  const periodValue = filterPeriod.value;
  
  const selectedStatuses = Array.from(filterStatusBoxes)
    .filter(cb => cb.checked)
    .map(cb => cb.value);

  const filtered = indicadores.filter(item => {
    const matchesSearch = item.nombre.toLowerCase().includes(query);
    const matchesEje = ejeValue === 'todos' || item.eje.toString() === ejeValue;
    const matchesPeriod = periodValue === 'todos' || item.periodicidad === periodValue;
    const matchesStatus = selectedStatuses.includes(item.estado);

    return matchesSearch && matchesEje && matchesPeriod && matchesStatus;
  });

  renderCards(filtered);
}

// Event Listeners dinámicos

searchInput?.addEventListener('input', applyFilters);
filterEje?.addEventListener('change', applyFilters);
filterPeriod?.addEventListener('change', applyFilters);
filterStatusBoxes?.forEach(box => box.addEventListener('change', applyFilters));

resetBtn?.addEventListener('click', () => {
  if (searchInput) searchInput.value = '';
  if (filterEje) filterEje.value = 'todos';
  if (filterPeriod) filterPeriod.value = 'todos';
  filterStatusBoxes?.forEach(cb => cb.checked = true);
  
  if (typeof renderCards === 'function' && typeof indicadores !== 'undefined') {
      renderCards(indicadores);
  }
});

// Inicialización inicial
document.addEventListener('DOMContentLoaded', () => {
  if (typeof renderCards === 'function' && typeof indicadores !== 'undefined') {
      renderCards(indicadores);
  }
});