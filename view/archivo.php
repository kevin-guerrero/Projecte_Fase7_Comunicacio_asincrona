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
      <li><a href="archivo.php" class="activo" aria-current="page">Archivo</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </nav>

  <main class="contenedor">
    <section style="margin-top:1.5rem;">

      <h2 class="etiqueta-seccion">Archivo histórico</h2>
      <hr class="separador-doble">

      <!-- Controles de filtro y orden -->
      <div class="archivo-controles">

        <div class="form-grupo">
          <label for="filtro-autor">Filtrar por autor</label>
          <select id="filtro-autor">
            <option value="">Todos los autores</option>
          </select>
        </div>

        <div class="form-grupo">
          <label for="filtro-fecha-desde">Desde</label>
          <input type="date" id="filtro-fecha-desde">
        </div>

        <div class="form-grupo">
          <label for="filtro-fecha-hasta">Hasta</label>
          <input type="date" id="filtro-fecha-hasta">
        </div>

        <div class="form-grupo">
          <label for="orden">Ordenar por fecha</label>
          <select id="orden">
            <option value="desc">Más recientes primero</option>
            <option value="asc">Más antiguos primero</option>
          </select>
        </div>

      </div>

      <!-- Contador -->
      <p id="contador" style="font-size:12px; color:var(--gris-linea); margin-bottom:1rem; letter-spacing:0.05em; text-transform:uppercase;"></p>

      <!-- Tabla de artículos -->
      <div id="tabla-archivo">
        <p class="cargando">Cargando archivo...</p>
      </div>

    </section>
  </main>

  <?php
    include_once '../includes/footer.html';
  ?>

  <script src="../js/archivo.js"></script>

</body>
</html>