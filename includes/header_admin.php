<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexAdopt - Panel de Administración</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body class="admin-body">

<div class="sidebar shadow">
    <div class="sidebar-brand">
        <img src="../assets/img/header_footer/logo_footer.png" alt="NexAdopt Admin" style="max-height: 60px;">
        <div class="mt-2 text-white small fw-bold text-uppercase opacity-75">Administración</div>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <span class="me-2">🏠</span> Dashboard
        </a>
        <a href="lista_mascotas.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'lista_mascotas.php' ? 'active' : ''; ?>">
            <span class="me-2">🐾</span> Mascotas
        </a>
        <a href="solicitudes.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'solicitudes.php' ? 'active' : ''; ?>">
            <span class="me-2">📩</span> Solicitudes
        </a>
        
        <a href="gestionar_historias.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'gestionar_historias.php' ? 'active' : ''; ?>">
            <span class="me-2">⭐</span> Historias
        </a>

        <hr class="mx-3 text-white opacity-25">
        <a href="../index.php">
            <span class="me-2">🌐</span> Ir a la Web
        </a>
        <a href="../logout.php" class="text-warning">
            <span class="me-2">🚪</span> Cerrar Sesión
        </a>
    </nav>
</div>

<div class="main-content">