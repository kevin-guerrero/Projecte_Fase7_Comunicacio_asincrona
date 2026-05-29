<?php
  include_once '../includes/head.html';
  include_once '../includes/header.html';
?>

  <nav class="navbar" aria-label="Navegación principal">
    <ul>
      <li><a href="../index.php">Inicio</a></li>
      <li><a href="noticias.php">Noticias</a></li>
      <li><a href="articulo.php" class="activo" aria-current="page">Artículo</a></li>
      <li><a href="redaccion.php">Redacción</a></li>
      <li><a href="archivo.php">Archivo</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="login.php">Login</a></li>
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