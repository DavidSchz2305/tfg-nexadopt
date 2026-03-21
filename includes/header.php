<?php
// Iniciamos sesión al principio del todo para que el header sepa quién navega
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definimos la URL base del proyecto (Ajusta el nombre de la carpeta si es diferente)
$base_url = "http://localhost/tfg-nexadopt/"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NexAdopt</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  
  <link rel="stylesheet" href="/tfg-nexadopt/assets/css/style.css?v=<?php echo time(); ?>" />
</head>
<body>

<header class="site-header">
  <div class="header-inner">

    <a class="logo-wrap" href="<?php echo $base_url; ?>index.php">
      <img src="<?php echo $base_url; ?>assets/img/header_footer/logo.png" alt="NexAdopt logo" />
    </a>

    <nav>
      <a href="<?php echo $base_url; ?>index.php">Inicio</a>
      <a href="<?php echo $base_url; ?>adoptar.php">Adoptar</a>
      <a href="<?php echo $base_url; ?>colaborar.php">Colaborar</a>
      <a href="<?php echo $base_url; ?>consejos.php">Consejos y recursos</a>
      <a href="<?php echo $base_url; ?>nosotros.php">Sobre Nosotros</a>
    </nav>

    <div class="header-actions">
      <a href="<?php echo $base_url; ?>pages/donar.php" class="btn-donar">❤ Donar</a>

      <?php if(isset($_SESSION['id_usuario'])): ?>
        <div class="dropdown">
          <a href="#" class="btn-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Perfil de <?php echo $_SESSION['nombre']; ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="8" r="4"/>
              <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 mt-2">
            <li class="px-3 py-2 border-bottom bg-light rounded-top-3">
              <span class="d-block small text-muted">Hola,</span>
              <span class="fw-bold text-brand"><?php echo $_SESSION['nombre']; ?></span>
            </li>
            
            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
              <li><a class="dropdown-item py-2" href="<?php echo $base_url; ?>admin/dashboard.php">⚙ Panel Admin</a></li>
            <?php endif; ?>

            <li><a class="dropdown-item py-2" href="<?php echo $base_url; ?>perfil.php">👤 Mi Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item py-2 text-danger" href="<?php echo $base_url; ?>logout.php">🚪 Cerrar sesión</a></li>
          </ul>
        </div>

      <?php else: ?>
        <a href="<?php echo $base_url; ?>login.php" class="btn-profile" title="Iniciar sesión / Registro">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
          </svg>
        </a>
      <?php endif; ?>
    </div>

  </div>
</header>