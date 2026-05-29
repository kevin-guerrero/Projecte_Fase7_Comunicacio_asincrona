<?php
  include_once '../includes/head.html';
  include_once '../includes/header.html';
?>

  <nav class="navbar" aria-label="Navegación principal">
    <ul>
      <li><a href="../index.php">Inicio</a></li>
      <li><a href="noticias.php">Noticias</a></li>
      <li><a href="articulo.php">Artículo</a></li>
      <li><a href="redaccion.php" class="activo" aria-current="page">Redacción</a></li>
      <li><a href="archivo.php">Archivo</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </nav>

  <main class="contenedor">
    <section style="max-width:700px; margin:2rem auto;">

      <h2 id="titulo-formulario" class="etiqueta-seccion">Nueva noticia</h2>
      <hr class="separador-doble">

      <form id="form-redaccion" novalidate>

        <div class="form-grupo">
          <label for="titular">Titular <span style="color:var(--rojo);">*</span></label>
          <input type="text" id="titular" name="titular" placeholder="El titular más impactante..." maxlength="150">
          <span class="error-texto" id="err-titular">El titular es obligatorio (mínimo 5 caracteres).</span>
        </div>

        <div class="form-grupo">
          <label for="subtitular">Subtitular <span style="color:var(--rojo);">*</span></label>
          <input type="text" id="subtitular" name="subtitular" placeholder="Un subtítulo que enganche al lector..." maxlength="200">
          <span class="error-texto" id="err-subtitular">El subtitular es obligatorio (mínimo 10 caracteres).</span>
        </div>

        <div class="form-grupo">
          <label for="cuerpo">Cuerpo del artículo <span style="color:var(--rojo);">*</span></label>
          <textarea id="cuerpo" name="cuerpo" rows="8" placeholder="Redacta aquí la noticia completa... (mínimo 50 caracteres)"></textarea>
          <span class="error-texto" id="err-cuerpo">El cuerpo es obligatorio (mínimo 50 caracteres).</span>
        </div>

        <div class="form-grupo">
          <label for="autor">Autor <span style="color:var(--rojo);">*</span></label>
          <select id="autor" name="autor">
            <option value="">— Selecciona un autor —</option>
          </select>
          <span class="error-texto" id="err-autor">Debes seleccionar un autor.</span>
        </div>

        <div class="form-grupo">
          <label for="categoria">Categoría <span style="color:var(--rojo);">*</span></label>
          <select id="categoria" name="categoria">
            <option value="">— Selecciona una categoría —</option>
          </select>
          <span class="error-texto" id="err-categoria">Debes seleccionar una categoría.</span>
        </div>

        <div class="form-grupo">
          <label for="fecha">Fecha de publicación <span style="color:var(--rojo);">*</span></label>
          <input type="date" id="fecha" name="fecha">
          <span class="error-texto" id="err-fecha">La fecha es obligatoria.</span>
        </div>

        <div class="form-grupo" style="display:flex; align-items:center; gap:10px;">
          <input type="checkbox" id="destacado" name="destacado" style="width:auto; margin:0;">
          <label for="destacado" style="margin:0; text-transform:none; font-size:13px; letter-spacing:0;">Marcar como noticia destacada en portada</label>
        </div>

        <div style="display:flex; gap:12px; margin-top:1.5rem; flex-wrap:wrap;">
          <button type="submit" class="btn btn-primario" id="btn-submit">Publicar noticia</button>
          <a href="noticias.php" class="btn btn-secundario">Cancelar</a>
        </div>

        <div id="mensaje-resultado" style="margin-top:1rem;"></div>

      </form>
    </section>
  </main>

  <?php
    include_once '../includes/footer.html';
  ?>

  <script src="../js/redaccion.js"></script>

</body>
</html>