<?php
/**
 * Vista detallada de una mascota específica y punto de entrada al proceso de adopción.
 */

session_start();
include 'includes/header.php';
require_once 'config/conexion.php';

// Validamos que el ID exista y sea numérico
if (!isset($_GET['id']) || !ctype_digit($_GET['id']) || (int)$_GET['id'] <= 0) {
    header('Location: adoptar.php');
    exit();
}

$id_mascota = (int)$_GET['id'];
$mascota    = null;

try {
    $stmt = $conexion->prepare("SELECT * FROM Mascotas WHERE id_mascota = :id LIMIT 1");
    $stmt->execute([':id' => $id_mascota]);
    $mascota = $stmt->fetch();
} catch (PDOException $e) {
    error_log('[NexAdopt - PerfilMascota Error] ' . $e->getMessage());
}

if (!$mascota) {
    echo '<div class="container py-5 text-center">
            <h2 class="text-brand">Mascota no encontrada</h2>
            <p>Lo sentimos, esta mascota no existe en nuestros registros.</p>
            <a href="adoptar.php" class="btn btn-nexadopt mt-3">Ver otras mascotas</a>
          </div>';
    include 'includes/footer.php';
    exit();
}

// Determinamos el badge de estado
$badge_estado  = '<span class="badge bg-success px-3 py-2 rounded-pill shadow-sm fs-6">Disponible</span>';
$puede_adoptar = true;

if ($mascota['estado'] === 'En proceso') {
    $badge_estado  = '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm fs-6">En trámite</span>';
} elseif ($mascota['estado'] === 'Adoptado') {
    $badge_estado  = '<span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm fs-6">Adoptado</span>';
    $puede_adoptar = false;
}

// =====================================================================
// Comprobar si el usuario actual ya solicitó este perro
// =====================================================================
$ya_solicitado = false;
if (isset($_SESSION['id_usuario'])) {
    try {
        $stmt_check = $conexion->prepare("SELECT id_solicitud FROM Solicitudes_Adopcion WHERE id_usuario = :id_user AND id_mascota = :id_mascota LIMIT 1");
        $stmt_check->execute([
            ':id_user' => $_SESSION['id_usuario'],
            ':id_mascota' => $id_mascota
        ]);
        if ($stmt_check->fetch()) {
            $ya_solicitado = true; // Si encuentra un registro, es que ya lo pidió
        }
    } catch (PDOException $e) {
        error_log('[NexAdopt - Check Solicitud Error] ' . $e->getMessage());
    }
}

// Lógica de galería de imágenes
$foto_db      = $mascota['foto_url'];
$ruta_base    = 'assets/img/mascotas/';
$fotos_galeria = [];

if (strpos($foto_db, '/') !== false) {
    $carpeta         = dirname($foto_db);
    $ruta_directorio = $ruta_base . $carpeta . '/';

    if (is_dir($ruta_directorio)) {
        $archivos = glob($ruta_directorio . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
        foreach ($archivos as $archivo) {
            $fotos_galeria[] = $archivo;
        }
    }
}

if (empty($fotos_galeria)) {
    $fotos_galeria[] = $ruta_base . htmlspecialchars($foto_db);
}

$foto_principal = $fotos_galeria[0];
?>

<main class="site-main bg-crema py-5">
    <div class="container">
        <div class="mb-4">
            <a href="adoptar.php" class="text-decoration-none text-muted fw-bold transition hover-brand d-inline-flex align-items-center gap-1">
                <i data-lucide="arrow-left" style="width:16px; height:16px;"></i> Volver a todas las mascotas
            </a>
        </div>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="d-lg-none d-flex justify-content-between align-items-center mb-3">
                    <h1 class="display-5 fw-bold text-brand mb-0"><?= htmlspecialchars($mascota['nombre']) ?></h1>
                    <div><?= $badge_estado ?></div>
                </div>

                <div class="position-sticky" style="top: 100px;">
                    <a href="<?= htmlspecialchars($foto_principal) ?>" data-fslightbox="mascota-galeria">
                        <img src="<?= htmlspecialchars($foto_principal) ?>"
                             alt="<?= htmlspecialchars($mascota['nombre']) ?>"
                             class="img-fluid rounded-4 shadow-sm w-100 object-fit-cover border border-c2 mb-3 cursor-zoom-in"
                             style="max-height: 500px;">
                    </a>

                    <div class="row g-2">
                        <?php foreach ($fotos_galeria as $index => $ruta_foto): ?>
                            <div class="col-4">
                                <a href="<?= htmlspecialchars($ruta_foto) ?>" data-fslightbox="mascota-galeria">
                                    <img src="<?= htmlspecialchars($ruta_foto) ?>"
                                         alt="Vista <?= $index + 1 ?>"
                                         class="img-fluid rounded-3 shadow-sm w-100 galeria-miniatura <?= ($index === 0) ? '' : 'opacity-75' ?>"
                                         style="height: 120px; object-fit: cover;">
                                </a>
                            </div>
                        <?php endforeach; ?>
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
                    <h5 class="fw-bold text-brand mb-3"><span class="me-2"></span>La historia de <?= htmlspecialchars($mascota['nombre']) ?></h5>
                    <div class="text-dark lh-lg" style="white-space: pre-wrap; font-size: 1.05rem;">
                        <?= htmlspecialchars($mascota['descripcion']) ?>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="bg-white p-4 rounded-4 shadow-sm border card-nexadopt h-100">
                            <h5 class="fw-bold text-brand mb-4">Ficha Técnica</h5>
                            <div class="row g-3">
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase d-flex align-items-center gap-1"><i data-lucide="tag" style="width:13px; height:13px;"></i> Raza</span>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($mascota['raza']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase d-flex align-items-center gap-1"><i data-lucide="calendar" style="width:13px; height:13px;"></i> Edad</span>
                                    <span class="fw-semibold text-dark"><?= (int)$mascota['edad_valor'] ?> <?= htmlspecialchars($mascota['edad_unidad']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase d-flex align-items-center gap-1"><i data-lucide="maximize-2" style="width:13px; height:13px;"></i> Tamaño</span>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($mascota['tamanio']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column border-bottom pb-2">
                                    <span class="small text-muted fw-bold text-uppercase d-flex align-items-center gap-1"><i data-lucide="users" style="width:13px; height:13px;"></i> Sexo</span>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($mascota['sexo']) ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column pb-2">
                                    <span class="small text-muted fw-bold text-uppercase d-flex align-items-center gap-1"><i data-lucide="home" style="width:13px; height:13px;"></i> Convivencia</span>
                                    <span class="fw-semibold text-dark small">Perros y niños</span>
                                </div>
                                <div class="col-6 d-flex flex-column pb-2">
                                    <span class="small text-muted fw-bold text-uppercase d-flex align-items-center gap-1"><i data-lucide="tree-pine" style="width:13px; height:13px;"></i> Exterior</span>
                                    <span class="fw-semibold text-dark">Solo interior</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-4 shadow-sm border card-nexadopt mt-4">
                    
                    <?php if (!$puede_adoptar): ?>
                        <h5 class="fw-bold text-brand mb-2">Proceso finalizado</h5>
                        <p class="text-muted small mb-4">Este animal ya ha encontrado su hogar definitivo.</p>
                        <button class="btn btn-secondary btn-lg w-100 fw-bold shadow-sm" disabled>
                            Adoptado
                        </button>
                    
                    <?php elseif ($ya_solicitado): ?>
                        <div class="text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light text-brand rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i data-lucide="check-circle" style="width: 30px; height: 30px;"></i>
                            </div>
                            <h5 class="fw-bold text-brand mb-2">Solicitud en curso</h5>
                            <p class="text-muted small mb-0">Ya has enviado los trámites para adoptar a <?= htmlspecialchars($mascota['nombre']) ?>. Puedes consultar el estado en tu perfil.</p>
                        </div>

                    <?php elseif (isset($_SESSION['id_usuario'])): ?>
                        <h5 class="fw-bold text-brand mb-2">¿Todo listo para dar el paso?</h5>
                        <p class="text-muted small mb-4">Si crees que puedes darle a <?= htmlspecialchars($mascota['nombre']) ?> el hogar que se merece, inicia el proceso de adopción.</p>
                        <a href="formulario-solicitud.php?id_mascota=<?= $id_mascota ?>" 
                           class="btn btn-nexadopt btn-lg w-100 fw-bold shadow-sm py-3 d-inline-flex align-items-center justify-content-center gap-2">
                            <i data-lucide="heart" style="width:18px; height:18px;"></i> Empieza tu solicitud
                        </a>
                    <?php else: ?>
                        <h5 class="fw-bold text-brand mb-2">¿Todo listo para dar el paso?</h5>
                        <p class="text-muted small mb-4">Si crees que puedes darle a <?= htmlspecialchars($mascota['nombre']) ?> el hogar que se merece, inicia el proceso de adopción.</p>
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
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>lucide.createIcons();</script>

<?php include 'includes/footer.php'; ?>