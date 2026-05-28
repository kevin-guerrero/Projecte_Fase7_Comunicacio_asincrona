const API = '../API';

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

async function incrementarVistas(id) { 
    try {
        await fetch(`${API}/article.php?id=${id}`, { 
            method: 'PATCH'
        });
    } catch (error) { 
        console.error('Error al actualizar vistas:', error); 
    }
}

async function cargarArticulosRelacionados(categoriaActual, idActual) {
  try {
    const respuesta = await fetch(`${API}/article.php?categoria=${categoriaActual}`);
    const articulos = await respuesta.json();
    const relacionados = articulos
      .filter(a => a.categoria === categoriaActual && a.id !== idActual)
      .slice(0, 3);

    if (relacionados.length === 0) return '';

    const items = relacionados.map(a => `
      <article class="articulo-card" style="margin-bottom:0.5rem;" onclick="window.location.href='articulo.php?id=${a.id}'">
        <span class="categoria-badge">${a.categoria}</span>
        <a href="articulo.php?id=${a.id}" class="titular">${a.titular}</a>
        <p class="meta"><span>${a.autor}</span><span>${formatearFecha(a.fecha)}</span></p>
      </article>
    `).join('');

    return `
      <aside aria-label="Artículos relacionados" style="margin-top:2rem;">
        <h3 class="etiqueta-seccion">También te puede interesar</h3>
        <hr class="separador-doble">
        ${items}
      </aside>
    `;
  } catch {
    return '';
  }
}

async function cargarArticulo() {
  const contenedor = document.getElementById('contenido-articulo');
  const params = new URLSearchParams(window.location.search);
  const id = parseInt(params.get('id'));

  if (!id) {
    contenedor.innerHTML = `
      <div style="margin-top:2rem;">
        <p class="error-msg">No se ha especificado ningún artículo.<br>
        Selecciona uno desde la sección de <a href="noticias.html">Noticias</a>.</p>
      </div>
    `;
    return;
  }

  try {
    const respuesta = await fetch(`${API}/article.php?id=${id}`);
    if (!respuesta.ok) throw new Error('Artículo no encontrado');
    const articulo = await respuesta.json();

    // Actualizar título de la página
    document.title = `${articulo.titular} — The Daily Bugle`;

    // Incrementar vistas
    const clave = `vista-articulo-${id}`;

    if (!sessionStorage.getItem(clave)) {
        incrementarVistas(id, articulo.vistas);
        sessionStorage.setItem(clave, 'true');
    }

    // Cargar relacionados
    const relacionadosHTML = await cargarArticulosRelacionados(articulo.categoria, id);

    contenedor.innerHTML = `
      <article style="margin-top:1.5rem; background:var(--papel); padding:2rem; border:1px solid var(--gris-linea);">
        <header>
          <span class="etiqueta-seccion roja">${articulo.categoria}</span>
          <h2 class="titular-grande" style="margin-top:0.5rem;">${articulo.titular}</h2>
          <p class="subtitular-grande">${articulo.subtitular}</p>
          <p class="meta-destacado" style="margin-top:0.5rem; font-size:12px; color:var(--gris-linea); text-transform:uppercase; letter-spacing:0.05em;">
            Por <strong style="color:var(--tinta-suave);">${articulo.autor}</strong>
            &nbsp;·&nbsp; ${formatearFecha(articulo.fecha)}
            &nbsp;·&nbsp; 👁 ${(articulo.vistas).toLocaleString()} lecturas
          </p>
        </header>

        <hr class="separador-doble">

        <p style="font-size:15px; line-height:1.9; color:var(--tinta); margin-top:1rem;">${articulo.cuerpo}</p>

        <footer style="margin-top:2rem; display:flex; gap:12px; flex-wrap:wrap;">
          <a href="noticias.php" class="btn btn-secundario">← Volver a Noticias</a>
          <a href="redaccion.php?id=${articulo.id}" class="btn btn-primario">Editar artículo</a>
        </footer>
      </article>

      ${relacionadosHTML}
    `;
  } catch (error) {
    contenedor.innerHTML = `
      <div class="error-msg" style="margin-top:1.5rem;">
        <strong>Error al cargar el artículo</strong><br>
        <em>${error.message}</em><br>
        <a href="noticias.php">← Volver a noticias</a>
      </div>
    `;
  }
}

mostrarFecha();
cargarArticulo();