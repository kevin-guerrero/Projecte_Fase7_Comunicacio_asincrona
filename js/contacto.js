const API = '../API';

function mostrarFecha() {
  const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const hoy = new Date().toLocaleDateString('es-ES', opciones);
  document.getElementById('fecha-actual').textContent =
    hoy.charAt(0).toUpperCase() + hoy.slice(1);
}

function mostrarError(idError, visible) {
  const error = document.getElementById(idError);
  const idCampo = idError.replace('err-', '');
  const campo = document.getElementById(idCampo);
  if (visible) {
    error.classList.add('visible');
    if (campo) campo.classList.add('error');
  } else {
    error.classList.remove('visible');
    if (campo) campo.classList.remove('error');
  }
}

function validarEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function validarNombreCompleto(nombre) {
  // Al menos dos palabras separadas por espacio
  return nombre.trim().split(/\s+/).length >= 2;
}

function validarFormulario() {
  let valido = true;

  const nombre = document.getElementById('nombre').value.trim();
  if (!validarNombreCompleto(nombre)) { mostrarError('err-nombre', true); valido = false; }
  else mostrarError('err-nombre', false);

  const email = document.getElementById('email').value.trim();
  if (!validarEmail(email)) { mostrarError('err-email', true); valido = false; }
  else mostrarError('err-email', false);

  const asunto = document.getElementById('asunto').value.trim();
  if (asunto.length < 5) { mostrarError('err-asunto', true); valido = false; }
  else mostrarError('err-asunto', false);

  const mensaje = document.getElementById('mensaje').value.trim();
  if (mensaje.length < 50) { mostrarError('err-mensaje', true); valido = false; }
  else mostrarError('err-mensaje', false);

  const acepto = document.getElementById('acepto').checked;
  if (!acepto) { mostrarError('err-acepto', true); valido = false; }
  else mostrarError('err-acepto', false);

  return valido;
}

document.getElementById('form-contacto').addEventListener('submit', async (e) => {
  e.preventDefault();
  const resultado = document.getElementById('mensaje-resultado');

  if (!validarFormulario()) {
    resultado.innerHTML = '<div class="error-msg">¡Hay errores en el formulario! Corrígelos antes de enviar.</div>';
    return;
  }

  const datos = {
    nombre: document.getElementById('nombre').value.trim(),
    email: document.getElementById('email').value.trim(),
    asunto: document.getElementById('asunto').value.trim(),
    mensaje: document.getElementById('mensaje').value.trim()
  };

  try {
    const respuesta = await fetch(`${API}/tips`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(datos)
    });

    if (!respuesta.ok) throw new Error('Error al enviar');

    resultado.innerHTML = `
      <div style="background:#e8f5e9; border:1px solid #388e3c; color:#1b5e20; padding:1rem; font-size:13px;">
        <strong>¡Soplo recibido!</strong> Jameson lo revisará... si es suficientemente escandaloso.
      </div>
    `;
    document.getElementById('form-contacto').reset();
  } catch (error) {
    resultado.innerHTML = `<div class="error-msg">Error al enviar: ${error.message}</div>`;
  }
});

// Limpiar errores al escribir
['nombre', 'email', 'asunto', 'mensaje'].forEach(id => {
  document.getElementById(id).addEventListener('input', () => {
    mostrarError(`err-${id}`, false);
  });
});

document.getElementById('acepto').addEventListener('change', () => {
  mostrarError('err-acepto', false);
});

mostrarFecha();