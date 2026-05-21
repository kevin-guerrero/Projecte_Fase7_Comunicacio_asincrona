const API = 'http://localhost:3000';
let todosLosArticulos = [];
let categoriaActiva = 'todas';
let idParaBorrar = null;

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

function renderizarArticulos(articulos) {
  const contenedor = document.getElementById('lista-articulos');

  if (articulos.length === 0) {
    contenedor.innerHTML = '<p class="cargando">No se encontraron noticias.</p>';
    return;
  }

  contenedor.innerHTML = '';
  articulos.forEach(a => {
    const article = document.createElement('article');
    article.classList.add('articulo-lista');
    article.innerHTML = `
      <div class="articulo-lista-info">
        <span class="categoria-badge">${a.categoria}</span>
        <a href="articulo.html?id=${a.id}" class="titular">${a.titular}</a>
        <p class="subtitular">${a.subtitular}</p>
        <p class="meta">
          <span>${a.autor}</span>
          <span>${formatearFecha(a.fecha)}</span>
          <span>👁 ${a.vistas.toLocaleString()}</span>
        </p>
      </div>
      <div class="articulo-lista-acciones">
        <a href="redaccion.html?id=${a.id}" class="btn btn-secundario">Editar</a>
        <button class="btn btn-peligro btn-borrar" data-id="${a.id}">Eliminar</button>
      </div>
    `;
    contenedor.appendChild(article);
  });

  // Eventos de borrar
  document.querySelectorAll('.btn-borrar').forEach(btn => {
    btn.addEventListener('click', (e) => {
      idParaBorrar = parseInt(e.currentTarget.dataset.id);
      document.getElementById('modal-borrar').classList.add('visible');
    });
  });
}

function filtrarYRenderizar() {
  const textoBusqueda = document.getElementById('buscador').value.toLowerCase();
  let resultado = todosLosArticulos;

  if (categoriaActiva !== 'todas') {
    resultado = resultado.filter(a => a.categoria === categoriaActiva);
  }

  if (textoBusqueda) {
    resultado = resultado.filter(a =>
      a.titular.toLowerCase().includes(textoBusqueda) ||
      a.subtitular.toLowerCase().includes(textoBusqueda) ||
      a.autor.toLowerCase().includes(textoBusqueda)
    );
  }

  renderizarArticulos(resultado);
}

async function cargarCategorias() {
  try {
    const respuesta = await fetch(`${API}/categorias`);
    const categorias = await respuesta.json();
    const contenedor = document.getElementById('filtros');

    categorias.forEach(cat => {
      const btn = document.createElement('button');
      btn.classList.add('filtro-btn');
      btn.dataset.categoria = cat;
      btn.textContent = cat.charAt(0).toUpperCase() + cat.slice(1);
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
        btn.classList.add('activo');
        categoriaActiva = cat;
        filtrarYRenderizar();
      });
      contenedor.appendChild(btn);
    });
  } catch (error) {
    console.error('Error al cargar categorías:', error);
  }
}

async function cargarArticulos() {
  const contenedor = document.getElementById('lista-articulos');
  try {
    const respuesta = await fetch(`${API}/articulos`);
    if (!respuesta.ok) throw new Error('Error al conectar con el servidor');
    todosLosArticulos = await respuesta.json();
    renderizarArticulos(todosLosArticulos);
  } catch (error) {
    contenedor.innerHTML = `<div class="error-msg">Error al cargar: ${error.message}</div>`;
  }
}

async function eliminarArticulo(id) {
  try {
    const respuesta = await fetch(`${API}/articulos/${id}`, { method: 'DELETE' });
    if (!respuesta.ok) throw new Error('Error al eliminar');
    todosLosArticulos = todosLosArticulos.filter(a => a.id !== id);
    filtrarYRenderizar();
  } catch (error) {
    alert('Error al eliminar el artículo: ' + error.message);
  }
}

// Filtro "todas"
document.querySelector('.filtro-btn').addEventListener('click', (e) => {
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  e.currentTarget.classList.add('activo');
  categoriaActiva = 'todas';
  filtrarYRenderizar();
});

// Buscador en tiempo real
document.getElementById('buscador').addEventListener('input', filtrarYRenderizar);

// Modal
document.getElementById('btn-confirmar-borrar').addEventListener('click', () => {
  document.getElementById('modal-borrar').classList.remove('visible');
  if (idParaBorrar !== null) {
    eliminarArticulo(idParaBorrar);
    idParaBorrar = null;
  }
});

document.getElementById('btn-cancelar-borrar').addEventListener('click', () => {
  document.getElementById('modal-borrar').classList.remove('visible');
  idParaBorrar = null;
});

mostrarFecha();
cargarCategorias();
cargarArticulos();