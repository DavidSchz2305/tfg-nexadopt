<?php
session_start();
include 'includes/header.php';
require_once 'config/conexion.php';


// RECOGER EL ID DE LA MASCOTA
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: adoptar.php");
    exit();
}

$id_mascota = $conexion->real_escape_string($_GET['id']);

// BUSCAR LOS DATOS
$sql = "SELECT * FROM Mascotas WHERE id_mascota = '$id_mascota'";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $mascota = $resultado->fetch_assoc();
} else {
    echo '<div class="container py-5 text-center">
            <h2 class="text-brand">Mascota no encontrada</h2>
            <p>Lo sentimos, esta mascota no existe en nuestros registros.</p>
            <a href="adoptar.php" class="btn btn-nexadopt mt-3">Ver otras mascotas</a>
          </div>';
    include 'includes/footer.php';
    exit();
}

// ETIQUETA DE ESTADO VISUAL
$badge_estado = '<span class="badge bg-success px-3 py-2 rounded-pill shadow-sm fs-6">Disponible</span>';
$puede_adoptar = true;

if ($mascota['estado'] == 'En proceso') {
    $badge_estado = '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm fs-6">En trámite</span>';
} elseif ($mascota['estado'] == 'Adoptado') {
    $badge_estado = '<span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm fs-6">Adoptado</span>';
    $puede_adoptar = false; 
}

// Definimos la ruta de la foto principal
$foto_principal = "assets/img/mascotas/" . htmlspecialchars($mascota['foto_url']);
?>

<main class="site-main bg-crema py-5">
    <div class="container">
        <div class="mb-4">
            <a href="adoptar.php" class="text-decoration-none text-muted fw-bold transition hover-brand">
                <span class="me-2">←</span> Volver a todas las mascotas
            </a>
        </div>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="d-lg-none d-flex justify-content-between align-items-center mb-3">
                    <h1 class="display-5 fw-bold text-brand mb-0"><?= htmlspecialchars($mascota['nombre']) ?></h1>
                    <div><?= $badge_estado ?></div>
                </div>

                <div class="position-sticky" style="top: 100px;">
                    <a href="<?= $foto_principal ?>" data-fslightbox="mascota-galeria" data-title="Foto principal de <?= htmlspecialchars($mascota['nombre']) ?>">
                        <img src="<?= $foto_principal ?>" 
                             alt="<?= htmlspecialchars($mascota['nombre']) ?>" 
                             class="img-fluid rounded-4 shadow-sm w-100 object-fit-cover border border-c2 mb-3 cursor-zoom-in" 
                             style="max-height: 500px;">
                    </a>

                    <div class="row g-2">
                        <div class="col-4">
                            <a href="<?= $foto_principal ?>" data-fslightbox="mascota-galeria" data-title="Vista 1 de <?= htmlspecialchars($mascota['nombre']) ?>">
                                <img src="<?= $foto_principal ?>" alt="" class="img-fluid rounded-3 shadow-sm w-100 galeria-miniatura">
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="<?= $foto_principal ?>" data-fslightbox="mascota-galeria" data-title="Vista 2 de <?= htmlspecialchars($mascota['nombre']) ?>">
                                <img src="<?= $foto_principal ?>" alt="" class="img-fluid rounded-3 shadow-sm w-100 galeria-miniatura opacity-75">
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="<?= $foto_principal ?>" data-fslightbox="mascota-galeria" data-title="Vista 3 de <?= htmlspecialchars($mascota['nombre']) ?>">
                                <img src="<?= $foto_principal ?>" alt="" class="img-fluid rounded-3 shadow-sm w-100 galeria-miniatura opacity-75">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="d-none d-lg-flex justify-content-between align-items-center mb-3">
                    <h1 class="display-4 fw-bold text-brand mb-0"><?= htmlspecialchars($mascota['nombre']) ?></h1>
                    <div><?= $badge_estado ?></div>
                </div>
                
                <p class="fs-5 text-muted mb-4">Estoy buscando mi hogar para siempre. ¿Podrías ser mi familia perfecta?</p>

                <div class="mb-4 p-4 bg-white rounded-4 shadow-sm border-start border-c2 border-5">
                    <h5 class="fw-bold text-brand mb-3"><span class="me-2">📖</span>La historia de <?= htmlspecialchars($mascota['nombre']) ?></h5>
                    <div class="text-dark lh-lg" style="white-space: pre-wrap; font-size: 1.05rem;"><?= htmlspecialchars($mascota['descripcion']) ?></div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="bg-white p-4 rounded-4 shadow-sm border card-nexadopt h-100">
                            <h5 class="fw-bold text-brand mb-4">Ficha Técnica</h5>
                            <div class="row g-3">
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase"><span class="me-2">🏷️</span>Raza</span>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($mascota['raza']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase"><span class="me-2">🎂</span>Edad</span>
                                    <span class="fw-semibold text-dark"><?= $mascota['edad_valor'] ?> <?= $mascota['edad_unidad'] ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase"><span class="me-2">📏</span>Tamaño</span>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($mascota['tamanio']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase"><span class="me-2">⚥</span>Sexo</span>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($mascota['sexo']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column pb-2">
                                    <span class="small text-muted fw-bold text-uppercase"><span class="me-2">🏡</span>Convivencia</span>
                                    <span class="fw-semibold text-dark small">Perros y niños</span>
                                </div>
                                <div class="col-6 d-flex flex-column pb-2">
                                    <span class="small text-muted fw-bold text-uppercase"><span class="me-2">🌳</span>Exterior</span>
                                    <span class="fw-semibold text-dark">Solo interior</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-4 shadow-sm border card-nexadopt mt-4">
                    <h5 class="fw-bold text-brand mb-2">¿Todo listo para dar el paso?</h5>
                    <p class="text-muted small mb-4">Si crees que puedes darle a <?= htmlspecialchars($mascota['nombre']) ?> el hogar que se merece, inicia el proceso de adopción.</p>
                    
                    <?php if(!$puede_adoptar): ?>
                        <button class="btn btn-secondary btn-lg w-100 fw-bold shadow-sm" disabled>
                            Este animal ya ha sido adoptado
                        </button>
                    <?php elseif(isset($_SESSION['id_usuario'])): ?>
                        <a href="formulario-solicitud.php?id_mascota=<?= $mascota['id_mascota'] ?>" class="btn btn-nexadopt btn-lg w-100 fw-bold shadow-sm py-3">
                            ❤️ Empieza tu solicitud
                        </a>
                    <?php else: ?>
                        <div class="text-center bg-light p-3 rounded-3 border">
                            <p class="small text-muted mb-2 fw-semibold">Debes iniciar sesión con tu cuenta para poder adoptar.</p>
                            <a href="login.php" class="btn btn-outline-nexadopt w-100 fw-bold">
                                Iniciar sesión / Registrarse
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/fslightbox/index.js"></script>

<?php include 'includes/footer.php'; ?>