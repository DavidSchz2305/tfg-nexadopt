<footer class="site-footer">
  <div class="footer-inner">

    <div class="footer-brand">
      <img src="assets/img/header_footer/logo_footer.png" alt="NexAdopt" class="footer-logo-top" />
      <div class="footer-social">
        <a class="social-link" href="#" title="Instagram">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
            <circle cx="12" cy="12" r="4"/>
            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
          </svg>
        </a>
        <a class="social-link" href="#" title="Facebook">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
          </svg>
        </a>
        <a class="social-link" href="#" title="TikTok">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/>
          </svg>
        </a>
      </div>
    </div>

    <div class="footer-links">
      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="index.php">Inicio</a></li>
          <li><a href="adoptar.php">Adoptar</a></li>
          <li><a href="colaborar.php">Colaborar</a></li>
          <li><a href="consejos.php">Consejos y recursos</a></li>
          <li><a href="nosotros.php">Sobre Nosotros</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Nosotros</h4>
        <ul>
          <li><a href="nosotros.php">Sobre la protectora</a></li>
          <li><a href="contacto.php">Contacto</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Ayuda</h4>
        <ul>
          <li><a href="adoptar.php">Proceso de adopción</a></li>
          <li><a href="colaborar.php">Hazte colaborador</a></li>
          <li><a href="donaciones.php">Donaciones</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="aviso-legal.php">Aviso legal</a></li>
          <li><a href="privacidad.php">Privacidad</a></li>
          <li><a href="cookies.php">Cookies</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <span>© 2026 NexAdopt · Todos los derechos reservados</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  let ultimoScroll = 0;
  const header = document.querySelector('.site-header');

  window.addEventListener('scroll', () => {
    let scrollActual = window.pageYOffset || document.documentElement.scrollTop;
    
    // Si scrolleamos hacia abajo y hemos pasado el umbral, ocultamos el header
    if (scrollActual > ultimoScroll && scrollActual > 90) {
      header.classList.add('header-hidden');
    } else {
        
      // Si subimos lo volvemos a mostrar
      header.classList.remove('header-hidden');
    }
    
    ultimoScroll = scrollActual <= 0 ? 0 : scrollActual; // Evita rebotes raros
  });
</script>
</body>
</html>