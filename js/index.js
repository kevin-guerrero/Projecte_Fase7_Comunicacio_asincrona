const API = 'http://localhost:3000';

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

async function cargarDestacada() {
  const seccion = document.getElementById('noticia-destacada');
  try {
    const respuesta = await fetch(`${API}/articulos`);
    if (!respuesta.ok) throw new Error('Error al conectar con el servidor');
    const articulos = await respuesta.json();
    const destacado = articulos.find(a => a.destacado) || articulos[0];

    if (!destacado) {
      seccion.innerHTML = '<p class="error-msg">No hay noticias disponibles.</p>';
      return;
    }

    seccion.innerHTML = `
      <div class="noticia-principal">
        <span class="etiqueta-seccion roja">${destacado.categoria}</span>
        <a href="view/articulo.html?id=${destacado.id}" class="titular-grande">${destacado.titular}</a>
        <p class="subtitular-grande">${destacado.subtitular}</p>
        <p class="meta-destacado">
          Por <strong>${destacado.autor}</strong> · ${formatearFecha(destacado.fecha)} · ${destacado.vistas.toLocaleString()} lecturas
        </p>
        <p class="cuerpo-preview">${destacado.cuerpo.substring(0, 300)}...</p>
        <a href="view/articulo.html?id=${destacado.id}" class="btn btn-primario" style="margin-top:1rem;display:inline-block;">Leer artículo completo</a>
      </div>
    `;
  } catch (error) {
    seccion.innerHTML = `
      <div class="error-msg">
        <strong>¡Imposible cargar la portada!</strong><br>
        Asegúrate de que el servidor está activo: <code>npm run dev</code><br>
        <em>${error.message}</em>
      </div>
    `;
  }
}

async function cargarNoticias() {
  const seccion = document.getElementById('lista-noticias');
  try {
    const respuesta = await fetch(`${API}/articulos`);
    if (!respuesta.ok) throw new Error('Error al conectar con el servidor');
    const articulos = await respuesta.json();

    const ultimas = articulos.filter(a => !a.destacado).slice(-3).reverse();

    if (ultimas.length === 0) {
      seccion.innerHTML = '<p style="font-style:italic;color:var(--tinta-suave);">No hay más noticias.</p>';
      return;
    }

    const grid = document.createElement('div');
    grid.classList.add('grid-portada');

    ultimas.forEach(a => {
      const article = document.createElement('article');
      article.classList.add('articulo-card');
      article.addEventListener('click', () => {
        window.location.href = `view/articulo.html?id=${a.id}`;
      });
      article.innerHTML = `
        <span class="categoria-badge">${a.categoria}</span>
        <a href="view/articulo.html?id=${a.id}" class="titular">${a.titular}</a>
        <p class="subtitular">${a.subtitular}</p>
        <p class="meta">
          <span>${a.autor}</span>
          <span>${formatearFecha(a.fecha)}</span>
        </p>
      `;
      grid.appendChild(article);
    });

    seccion.innerHTML = '';
    seccion.appendChild(grid);
  } catch (error) {
    seccion.innerHTML = `<div class="error-msg">Error al cargar las noticias: ${error.message}</div>`;
  }
}

mostrarFecha();
cargarDestacada();
cargarNoticias();