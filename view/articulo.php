<?php
  include_once '../includes/head.html';
  include_once '../includes/header.html';
?>

  <nav class="navbar" aria-label="Navegación principal">
    <ul>
      <li><a href="../index.html">Inicio</a></li>
      <li><a href="noticias.html">Noticias</a></li>
      <li><a href="articulo.html" class="activo" aria-current="page">Artículo</a></li>
      <li><a href="redaccion.html">Redacción</a></li>
      <li><a href="archivo.html">Archivo</a></li>
      <li><a href="contacto.html">Contacto</a></li>
    </ul>
  </nav>

  <main class="contenedor">
    <div id="contenido-articulo">
      <p class="cargando">Cargando artículo...</p>
    </div>
  </main>

  <?php
    include_once '../includes/footer.html';
  ?>

  <script src="../js/articulo.js"></script>

</body>
</html>