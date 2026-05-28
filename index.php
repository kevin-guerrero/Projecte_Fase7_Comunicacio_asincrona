<?php
  include_once '../includes/head.html';
  include_once '../includes/header.html';
?>

  <nav class="navbar" aria-label="Navegación principal">
    <ul>
      <li><a href="index.html" class="activo" aria-current="page">Inicio</a></li>
      <li><a href="view/noticias.html">Noticias</a></li>
      <li><a href="view/articulo.html">Artículo</a></li>
      <li><a href="view/redaccion.html">Redacción</a></li>
      <li><a href="view/archivo.html">Archivo</a></li>
      <li><a href="view/contacto.html">Contacto</a></li>
    </ul>
  </nav>

  <main class="contenedor">

    <section id="noticia-destacada" aria-label="Noticia destacada">
      <p class="cargando">Cargando portada...</p>
    </section>

    <hr class="separador-doble">

    <section aria-label="Últimas noticias">
      <header class="notis-header">
        <h2 class="etiqueta-seccion roja">Últimas noticias</h2>
        <a href="view/noticias.html" class="notis-link">Ver todas →</a>
      </header>
      <div id="lista-noticias">
        <p class="cargando">Cargando noticias...</p>
      </div>
    </section>

  </main>

  <?php
    include_once '../includes/footer.html';
  ?>

  <script src="js/index.js"></script>

</body>
</html>