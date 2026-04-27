<style>
  /* =========================================================================
     RESPONSIVE PARA EL FOOTER 
     ========================================================================= */
  @media (max-width: 991px) {
    .site-footer .footer-inner {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 2.5rem;
    }
    .site-footer .footer-links {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      gap: 1.5rem;
    }
    .site-footer .footer-social {
      display: flex;
      justify-content: center;
      margin-top: 1rem;
    }
    .site-footer .footer-col {
      margin-bottom: 1rem;
    }
    .site-footer .footer-col ul {
      padding-left: 0; /* Centra las listas en móvil */
    }
  }
</style>

<footer class="site-footer">
  <div class="footer-inner">

    <div class="footer-brand">
      <img src="<?php echo $base_url; ?>assets/img/header_footer/logo_footer.png" alt="NexAdopt" class="footer-logo-top" />
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
          <li><a href="<?php echo $base_url; ?>index.php">Inicio</a></li>
          <li><a href="<?php echo $base_url; ?>adoptar.php">Adoptar</a></li>
          <li><a href="<?php echo $base_url; ?>colaborar.php">Colaborar</a></li>
          <li><a href="<?php echo $base_url; ?>consejos.php">Consejos y recursos</a></li>
          <li><a href="<?php echo $base_url; ?>nosotros.php">Sobre Nosotros</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Nosotros</h4>
        <ul>
          <li><a href="<?php echo $base_url; ?>nosotros.php">Sobre la protectora</a></li>
          <li><a href="<?php echo $base_url; ?>contacto.php">Contacto</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Ayuda</h4>
        <ul>
          <li><a href="<?php echo $base_url; ?>adoptar.php">Proceso de adopción</a></li>
          <li><a href="<?php echo $base_url; ?>colaborar.php">Hazte colaborador</a></li>
          <li><a href="<?php echo $base_url; ?>pages/donar.php">Donaciones</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="<?php echo $base_url; ?>pages/aviso-legal.php">Aviso legal</a></li>
          <li><a href="<?php echo $base_url; ?>pages/privacidad.php">Privacidad</a></li>
          <li><a href="<?php echo $base_url; ?>pages/cookies.php">Cookies</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <span>© 2026 NexAdopt · Todos los derechos reservados</span>
  </div>

  <a href="https://wa.me/34695822401?text=Hola%20NexAdopt,%20me%20gustaría%20información%20sobre%20adopciones." class="whatsapp-float shadow-lg" target="_blank" rel="noopener noreferrer" title="Contacta por WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
    </svg>
</a>

<style>
/* Estilos del botón de WhatsApp */
.whatsapp-float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 25px; /* Distancia desde abajo */
    right: 25px;  /* Distancia desde la derecha */
    background-color: #25d366; /* Color oficial de WhatsApp */
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 35px;
    z-index: 9999; /* Para que esté por encima de todo */
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: transform 0.3s ease;
}

.whatsapp-float:hover {
    color: white;
    transform: scale(1.1); /* Efecto de crecer un poco al pasar el ratón */
}
</style>

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