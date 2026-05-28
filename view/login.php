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
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="login.php" class="activo" aria-current="page">Login</a></li>
    </ul>
  </nav>

  <main class="contenedor">

    <section style="max-width:460px; margin:3rem auto;">

      <div id="bloc-login">
        <h2 class="etiqueta-seccion">Iniciar sessió</h2>
        <form id="form-login" class="form-grup" novalidate>
          <div class="form-grupo">
            <label for="login-nom">Usuari</label>
            <input type="text" id="login-nom" placeholder="El teu nom d'usuari" required>
          </div>
          <div class="form-grupo">
            <label for="login-pass">Contrasenya</label>
            <input type="password" id="login-pass" placeholder="La teva contrasenya" required>
          </div>
          <p id="login-error" class="error-msg" style="display:none;color:#c00;margin-top:.5rem;"></p>
          <button type="submit" class="btn btn-primario" style="margin-top:1rem;width:100%;">Entrar</button>
        </form>
        <p style="margin-top:1rem;text-align:center;">
          Encara no tens compte? <a href="#" id="link-registre">Registra't</a>
        </p>
      </div>

      <div id="bloc-registre" style="display:none;">
        <h2 class="etiqueta-seccion">Crear compte</h2>
        <form id="form-registre" class="form-grup" novalidate>
          <div class="form-grupo">
            <label for="reg-nom">Usuari</label>
            <input type="text" id="reg-nom" placeholder="Nom d'usuari" required>
          </div>
          <div class="form-grupo">
            <label for="reg-email">Email</label>
            <input type="email" id="reg-email" placeholder="correu@exemple.com" required>
          </div>
          <div class="form-grupo">
            <label for="reg-pass">Contrasenya</label>
            <input type="password" id="reg-pass" placeholder="Mínim 6 caràcters" required>
          </div>
          <div class="form-grupo">
            <label for="reg-ubicacio">Ubicació <span style="color:#999;">(opcional)</span></label>
            <input type="text" id="reg-ubicacio" placeholder="p.e. Queens, Nova York">
          </div>
          <div class="form-grupo">
            <label for="reg-telefon">Telèfon <span style="color:#999;">(opcional)</span></label>
            <input type="tel" id="reg-telefon" placeholder="555-0000">
          </div>
          <p id="reg-error"   class="error-msg" style="display:none;color:#c00;margin-top:.5rem;"></p>
          <p id="reg-success" style="display:none;color:green;margin-top:.5rem;"></p>
          <button type="submit" class="btn btn-primario" style="margin-top:1rem;width:100%;">Registrar-me</button>
        </form>
        <p style="margin-top:1rem;text-align:center;">
          Ja tens compte? <a href="#" id="link-login">Inicia sessió</a>
        </p>
      </div>

      <div id="bloc-usuari" style="display:none;">
        <h2 class="etiqueta-seccion">Sessió activa</h2>
        <p>Benvingut/da, <strong id="nom-usuari"></strong> (<span id="rol-usuari"></span>).</p>
        <div style="display:flex;gap:1rem;margin-top:1.5rem;flex-wrap:wrap;">
          <a href="perfil.php" class="btn btn-secundario">El meu perfil</a>
          <a href="redaccion.php" class="btn btn-primario">+ Nova notícia</a>
          <button id="btn-logout" class="btn btn-peligro">Tancar sessió</button>
        </div>
      </div>

    </section>

  </main>

  <?php include_once '../includes/footer.html'; ?>

  <script src="../js/login.js"></script>

</body>
</html>
