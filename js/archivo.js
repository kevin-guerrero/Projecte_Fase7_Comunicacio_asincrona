const API = 'http://localhost:3000';
let todosLosArticulos = [];

function mostrarFecha() {
  const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const hoy = new Date().toLocaleDateString('es-ES', opciones);
  document.getElementById('fecha-actual').textContent =
    hoy.charAt(0).toUpperCase() + hoy.slice(1);
}

function formatearFecha(fechaStr) {
  const [anio, mes, dia] = fechaStr.split('-');
  return new Date(anio, mes - 1, dia)
    .toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
}

function renderizarTabla(articulos) {
  const contenedor = document.getElementById('tabla-archivo');
  const contador = document.getElementById('contador');
  contador.textContent = `${articulos.length} artículo${articulos.length !== 1 ? 's' : ''} encontrado${articulos.length !== 1 ? 's' : ''}`;

  if (articulos.length === 0) {
    contenedor.innerHTML = '<p class="cargando">No hay artículos que coincidan con los filtros.</p>';
    return;
  }

  const tabla = document.createElement('table');
  tabla.classList.add('tabla-archivo');
  tabla.innerHTML = `
    <thead>
      <tr>
        <th>Titular</th>
        <th>Categoría</th>
        <th>Autor</th>
        <th>Fecha</th>
        <th>Lecturas</th>
        <th>Acción</th>
      </tr>
    </thead>
  `;

  const tbody = document.createElement('tbody');
  articulos.forEach(a => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><a href="articulo.html?id=${a.id}" class="tabla-link">${a.titular}</a></td>
      <td><span class="categoria-badge">${a.categoria}</span></td>
      <td>${a.autor}</td>
      <td>${formatearFecha(a.fecha)}</td>
      <td>${a.vistas.toLocaleString()}</td>
      <td><a href="articulo.html?id=${a.id}" class="btn btn-secundario" style="padding:4px 12px;font-size:10px;">Leer</a></td>
    `;
    tbody.appendChild(tr);
  });

  tabla.appendChild(tbody);
  contenedor.innerHTML = '';
  contenedor.appendChild(tabla);
}

function aplicarFiltros() {
  const autorSeleccionado = document.getElementById('filtro-autor').value;
  const fechaDesde = document.getElementById('filtro-fecha-desde').value;
  const fechaHasta = document.getElementById('filtro-fecha-hasta').value;
  const orden = document.getElementById('orden').value;

  let resultado = [...todosLosArticulos];

  if (autorSeleccionado) {
    resultado = resultado.filter(a => a.autor === autorSeleccionado);
  }

  if (fechaDesde) {
    resultado = resultado.filter(a => a.fecha >= fechaDesde);
  }

  if (fechaHasta) {
    resultado = resultado.filter(a => a.fecha <= fechaHasta);
  }

  resultado.sort((a, b) => {
    if (orden === 'asc') return a.fecha.localeCompare(b.fecha);
    return b.fecha.localeCompare(a.fecha);
  });

  renderizarTabla(resultado);
}

async function cargarAutores() {
  try {
    const respuesta = await fetch(`${API}/autores`);
    const autores = await respuesta.json();
    const select = document.getElementById('filtro-autor');
    autores.forEach(a => {
      const option = document.createElement('option');
      option.value = a.nombre;
      option.textContent = a.nombre;
      select.appendChild(option);
    });
  } catch (error) {
    console.error('Error al cargar autores:', error);
  }
}

async function cargarArticulos() {
  const contenedor = document.getElementById('tabla-archivo');
  try {
    const respuesta = await fetch(`${API}/articulos`);
    if (!respuesta.ok) throw new Error('Error al conectar con el servidor');
    todosLosArticulos = await respuesta.json();
    aplicarFiltros();
  } catch (error) {
    contenedor.innerHTML = `<div class="error-msg">Error al cargar el archivo: ${error.message}</div>`;
  }
}

// Eventos de filtros
document.getElementById('filtro-autor').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-fecha-desde').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-fecha-hasta').addEventListener('change', aplicarFiltros);
document.getElementById('orden').addEventListener('change', aplicarFiltros);

mostrarFecha();
cargarAutores();
cargarArticulos();