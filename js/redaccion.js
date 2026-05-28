const API = '../API';
let modoEdicion = false;
let idEdicion = null;

function mostrarFecha() {
  const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const hoy = new Date().toLocaleDateString('es-ES', opciones);
  document.getElementById('fecha-actual').textContent =
    hoy.charAt(0).toUpperCase() + hoy.slice(1);
}

async function cargarAutores() {
  try {
    const respuesta = await fetch(`${API}/article.php`);
    const articulos = await respuesta.json();

    const select = document.getElementById('autor');

    const autoresUnicos = [...new Set(articulos.map(a => a.autor))];

    autoresUnicos.forEach(nombre => {
      const option = document.createElement('option');
      option.value = nombre;
      option.textContent = nombre;
      select.appendChild(option);
    });

  } catch (error) {
    console.error('Error al cargar autores:', error);
  }
}

async function cargarCategorias() {
  try {
    const respuesta = await fetch(`${API}/category.php`);
    const categorias = await respuesta.json();

    const select = document.getElementById('categoria');

    categorias.forEach(cat => {
      const option = document.createElement('option');

      option.value = cat.nom;
      option.textContent =
        cat.nom.charAt(0).toUpperCase() + cat.nom.slice(1);

      select.appendChild(option);
    });

  } catch (error) {
    console.error('Error al cargar categorías:', error);
  }
}

// Si hay ?id en la URL, cargar datos para editar
async function cargarParaEditar(id) {
  try {
    const respuesta = await fetch(`${API}/article.php?id=${id}`);
    if (!respuesta.ok) throw new Error('Artículo no encontrado');
    const articulo = await respuesta.json();

    document.getElementById('titular').value = articulo.titular;
    document.getElementById('subtitular').value = articulo.subtitular;
    document.getElementById('cuerpo').value = articulo.cuerpo;
    document.getElementById('fecha').value = articulo.fecha;
    document.getElementById('destacado').checked = articulo.destacado;

    // Esperar a que los selects estén poblados
    document.getElementById('autor').value = articulo.autor;
    document.getElementById('categoria').value = articulo.categoria;

    document.getElementById('titulo-formulario').textContent = 'Editar noticia';
    document.getElementById('btn-submit').textContent = 'Guardar cambios';
  } catch (error) {
    document.getElementById('mensaje-resultado').innerHTML =
      `<div class="error-msg">Error al cargar el artículo: ${error.message}</div>`;
  }
}

// Validaciones
function mostrarError(id, visible) {
  const campo = document.getElementById(id.replace('err-', ''));
  const error = document.getElementById(id);
  if (visible) {
    campo.classList.add('error');
    error.classList.add('visible');
  } else {
    campo.classList.remove('error');
    error.classList.remove('visible');
  }
}

function validarFormulario() {
  let valido = true;

  const titular = document.getElementById('titular').value.trim();
  if (titular.length < 5) { mostrarError('err-titular', true); valido = false; }
  else mostrarError('err-titular', false);

  const subtitular = document.getElementById('subtitular').value.trim();
  if (subtitular.length < 10) { mostrarError('err-subtitular', true); valido = false; }
  else mostrarError('err-subtitular', false);

  const cuerpo = document.getElementById('cuerpo').value.trim();
  if (cuerpo.length < 50) { mostrarError('err-cuerpo', true); valido = false; }
  else mostrarError('err-cuerpo', false);

  const autor = document.getElementById('autor').value;
  if (!autor) { mostrarError('err-autor', true); valido = false; }
  else mostrarError('err-autor', false);

  const categoria = document.getElementById('categoria').value;
  if (!categoria) { mostrarError('err-categoria', true); valido = false; }
  else mostrarError('err-categoria', false);

  const fecha = document.getElementById('fecha').value;
  if (!fecha) { mostrarError('err-fecha', true); valido = false; }
  else mostrarError('err-fecha', false);

  return valido;
}

// Envío del formulario
document.getElementById('form-redaccion').addEventListener('submit', async (e) => {
  e.preventDefault();
  const mensaje = document.getElementById('mensaje-resultado');

  if (!validarFormulario()) {
    mensaje.innerHTML = '<div class="error-msg">¡Inaceptable! Corrige los errores antes de publicar.</div>';
    return;
  }

  const datos = {
    titular: document.getElementById('titular').value.trim(),
    subtitular: document.getElementById('subtitular').value.trim(),
    cuerpo: document.getElementById('cuerpo').value.trim(),
    autor: document.getElementById('autor').value,
    categoria: document.getElementById('categoria').value,
    fecha: document.getElementById('fecha').value,
    destacado: document.getElementById('destacado').checked
  };

  try {
    let respuesta;
    if (modoEdicion) {
      respuesta = await fetch(`${API}/article.php?id=${idEdicion}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
      });
    } else {
      respuesta = await fetch(`${API}/article.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
      });
    }

    if (!respuesta.ok) throw new Error('Error al guardar');

    mensaje.innerHTML = `
      <div style="background:#e8f5e9; border:1px solid #388e3c; color:#1b5e20; padding:1rem; font-size:13px;">
        <strong>¡Noticia ${modoEdicion ? 'actualizada' : 'publicada'} con éxito!</strong>
        Jameson lo aprueba (a regañadientes).<br>
        <a href="noticias.php" style="color:#1b5e20; font-weight:700;">← Ver todas las noticias</a>
      </div>
    `;

    if (!modoEdicion) {
      document.getElementById('form-redaccion').reset();
    }
  } catch (error) {
    mensaje.innerHTML = `<div class="error-msg">Error al guardar: ${error.message}</div>`;
  }
});

// Limpiar errores al escribir
['titular', 'subtitular', 'cuerpo', 'autor', 'categoria', 'fecha'].forEach(id => {
  document.getElementById(id).addEventListener('input', () => {
    mostrarError(`err-${id}`, false);
  });
});

// Inicialización
async function init() {
  mostrarFecha();
  await cargarAutores();
  await cargarCategorias();

  const params = new URLSearchParams(window.location.search);
  const id = parseInt(params.get('id'));
  if (id) {
    modoEdicion = true;
    idEdicion = id;
    await cargarParaEditar(id);
  } else {
    // Fecha de hoy por defecto
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
  }
}

init();