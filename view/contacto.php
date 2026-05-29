<?php
  include_once '../includes/head.html';
  include_once '../includes/header.html';
?>

  <nav class="navbar" aria-label="Navegación principal">
    <ul>
      <li><a href="../index.php">Inicio</a></li>
      <li><a href="noticias.php">Noticias</a></li>
      <li><a href="articulo.php">Artículo</a></li>
      <li><a href="redaccion.php">Redacción</a></li>
      <li><a href="archivo.php">Archivo</a></li>
      <li><a href="contacto.php" class="activo" aria-current="page">Contacto</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </nav>

  <main class="contenedor">
    <section style="max-width:600px; margin:2rem auto;">

      <h2 class="etiqueta-seccion roja">Envía un soplo a la redacción</h2>
      <hr class="separador-doble">
      <p style="font-size:14px; font-style:italic; color:var(--tinta-suave); margin-bottom:1.5rem;">
        ¿Has visto a Spider-Man? ¿Tienes información comprometedora sobre el enmascarado?
        Escríbenos. Jameson te lo agradecerá... a su manera.
      </p>

      <form id="form-contacto" novalidate>

        <div class="form-grupo">
          <label for="nombre">Nombre completo <span style="color:var(--rojo);">*</span></label>
          <input type="text" id="nombre" name="nombre" placeholder="Tu nombre y apellido">
          <span class="error-texto" id="err-nombre">Introduce tu nombre completo (nombre y apellido).</span>
        </div>

        <div class="form-grupo">
          <label for="email">Correo electrónico <span style="color:var(--rojo);">*</span></label>
          <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com">
          <span class="error-texto" id="err-email">Introduce un correo electrónico válido.</span>
        </div>

        <div class="form-grupo">
          <label for="asunto">Asunto <span style="color:var(--rojo);">*</span></label>
          <input type="text" id="asunto" name="asunto" placeholder="Ej: Avistamiento en Queens">
          <span class="error-texto" id="err-asunto">El asunto es obligatorio (mínimo 5 caracteres).</span>
        </div>

        <div class="form-grupo">
          <label for="mensaje">Mensaje <span style="color:var(--rojo);">*</span></label>
          <textarea id="mensaje" name="mensaje" rows="6" placeholder="Cuéntanos todo lo que sabes... (mínimo 50 caracteres)"></textarea>
          <span class="error-texto" id="err-mensaje">El mensaje es obligatorio (mínimo 50 caracteres).</span>
        </div>

        <div class="form-grupo" style="display:flex; align-items:flex-start; gap:10px;">
          <input type="checkbox" id="acepto" name="acepto" style="width:auto; margin-top:3px;">
          <label for="acepto" style="margin:0; text-transform:none; font-size:13px; letter-spacing:0; line-height:1.4;">
            Acepto que el Daily Bugle puede publicar mi información de forma anónima si es de interés público.
          </label>
        </div>
        <span class="error-texto" id="err-acepto" style="display:none;">Debes aceptar las condiciones para enviar el soplo.</span>

        <div style="margin-top:1.5rem; display:flex; gap:12px; flex-wrap:wrap;">
          <button type="submit" class="btn btn-primario">Enviar soplo</button>
          <button type="reset" class="btn btn-secundario">Limpiar</button>
        </div>

        <div id="mensaje-resultado" style="margin-top:1rem;"></div>

      </form>
    </section>
  </main>

  <?php
    include_once '../includes/footer.html';
  ?>

  <script src="../js/contacto.js"></script>

</body>
</html>