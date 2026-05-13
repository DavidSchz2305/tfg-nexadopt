<?php
/**
 * Edición de una historia de adopción existente.
 * He separado la carga inicial de datos del procesamiento del POST
 * en bloques try-catch independientes para mayor claridad y seguridad.
 */

session_start();

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

// Escaneamos el directorio de imágenes para el selector de fotografías.
$directorio_imagenes = '../assets/img/historias/';
$lista_imagenes = [];
if (is_dir($directorio_imagenes)) {
    foreach (scandir($directorio_imagenes) as $archivo) {
        if ($archivo !== '.' && $archivo !== '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $archivo)) {
            $lista_imagenes[] = $archivo;
        }
    }
}

// Validamos que el ID del GET sea un entero positivo antes de usarlo.
$id_historia = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_historia <= 0) {
    header('Location: gestionar_historias.php');
    exit();
}

// =========================================================================
// PROCESAMIENTO DEL FORMULARIO (POST)
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_historia = (int)($_POST['id_historia'] ?? 0);
    $titulo      = trim($_POST['titulo']      ?? '');
    $testimonio  = trim($_POST['testimonio']  ?? '');
    $foto_url    = !empty($_POST['foto_seleccionada'])
        ? 'assets/img/historias/' . basename($_POST['foto_seleccionada'])
        : '';

    if (!empty($titulo) && !empty($testimonio) && $id_historia > 0) {
        try {
            $sql  = "UPDATE historias_exito SET titulo = :titulo, testimonio = :testimonio, foto_final_url = :foto WHERE id_historia = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':titulo'     => $titulo,
                ':testimonio' => $testimonio,
                ':foto'       => $foto_url,
                ':id'         => $id_historia,
            ]);

            header('Location: gestionar_historias.php');
            exit();

        } catch (PDOException $e) {
            error_log('[NexAdopt - EditarHistoria Error] ' . $e->getMessage());
        }
    }
}

// =========================================================================
// CARGA DE DATOS ACTUALES PARA RELLENAR EL FORMULARIO
// =========================================================================
$titulo_actual     = '';
$testimonio_actual = '';
$foto_actual       = '';

try {
    $stmt_carga = $conexion->prepare(
        "SELECT titulo, testimonio, foto_final_url FROM historias_exito WHERE id_historia = :id LIMIT 1"
    );
    $stmt_carga->execute([':id' => $id_historia]);
    $historia = $stmt_carga->fetch();

    if (!$historia) {
        header('Location: gestionar_historias.php');
        exit();
    }

    $titulo_actual     = $historia['titulo'];
    $testimonio_actual = $historia['testimonio'];
    // Usamos basename() para obtener solo el nombre del archivo, sin la ruta completa.
    $foto_actual       = basename($historia['foto_final_url']);

} catch (PDOException $e) {
    error_log('[NexAdopt - EditarHistoria/Load Error] ' . $e->getMessage());
    header('Location: gestionar_historias.php');
    exit();
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="gestionar_historias.php" class="btn btn-outline-secondary border-0 me-3 d-inline-flex align-items-center">
            <i data-lucide="arrow-left" style="width:20px; height:20px;"></i>
        </a>
        <h2 class="fw-bold text-brand mb-0 d-flex align-items-center gap-2">
            <i data-lucide="pencil" style="width:24px; height:24px;"></i> Editar Historia #<?= $id_historia ?>
        </h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="editar_historia.php?id=<?= $id_historia ?>" method="POST">
                    <input type="hidden" name="id_historia" value="<?= $id_historia ?>">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Título / Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" class="form-control form-control-lg bg-light border-0"
                               value="<?= htmlspecialchars($titulo_actual) ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Fotografía</label>
                        <select name="foto_seleccionada" class="form-select form-select-lg bg-light border-0" style="cursor: pointer;">
                            <option value="">-- Sin foto --</option>
                            <?php foreach ($lista_imagenes as $img): ?>
                                <option value="<?= htmlspecialchars($img) ?>" <?= ($img === $foto_actual) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($img) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-muted small text-uppercase">Testimonio <span class="text-danger">*</span></label>
                        <textarea name="testimonio" class="form-control bg-light border-0" rows="6" required><?= htmlspecialchars($testimonio_actual) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-nexadopt px-5 py-2 d-inline-flex align-items-center gap-2">
                        <i data-lucide="save" style="width:16px; height:16px;"></i> Actualizar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>