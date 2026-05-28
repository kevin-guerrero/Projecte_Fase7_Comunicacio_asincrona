<?php
  include_once '../includes/head.html';
  include_once '../includes/header.html';
?>

  <nav class="navbar" aria-label="Navegación principal">
    <ul>
      <li><a href="../index.html">Inicio</a></li>
      <li><a href="noticias.html" class="activo" aria-current="page">Noticias</a></li>
      <li><a href="articulo.html">Artículo</a></li>
      <li><a href="redaccion.html">Redacción</a></li>
      <li><a href="archivo.html">Archivo</a></li>
      <li><a href="contacto.html">Contacto</a></li>
    </ul>
  </nav>

  <main class="contenedor">

    <section aria-label="Listado de noticias">
      <header class="notis-header" style="margin-top:1.5rem;">
        <h2 class="etiqueta-seccion">Todas las noticias</h2>
        <a href="redaccion.html" class="btn btn-primario">+ Nueva noticia</a>
      </header>

      <!-- Filtros por categoría -->
      <div id="filtros" class="filtros-contenedor" role="group" aria-label="Filtrar por categoría">
        <button class="filtro-btn activo" data-categoria="todas">Todas</button>
      </div>

      <!-- Buscador -->
      <div class="form-grupo" style="margin-top:1rem;">
        <label for="buscador">Buscar noticia</label>
        <input type="search" id="buscador" placeholder="Escribe para buscar...">
      </div>

      <div id="lista-articulos">
        <p class="cargando">Cargando noticias...</p>
      </div>
    </section>

  </main>

  <!-- Modal confirmación de borrado -->
  <div class="modal-overlay" id="modal-borrar" role="dialog" aria-modal="true" aria-labelledby="modal-titulo">
    <div class="modal-caja">
      <h2 id="modal-titulo">¿Eliminar artículo?</h2>
      <p>Jameson lo desaprueba, pero tú mandas. Esta acción no se puede deshacer.</p>
      <div class="modal-botones">
        <button class="btn btn-peligro" id="btn-confirmar-borrar">Eliminar</button>
        <button class="btn btn-secundario" id="btn-cancelar-borrar">Cancelar</button>
      </div>
    </div>
  </div>

  <?php
    include_once '../includes/footer.html';
  ?>

  <script src="../js/noticias.js"></script>

</body>
</html>