<?php
/**
 * Formulario para publicar nuevas historias de adopción exitosa.
 * La foto se selecciona de las imágenes ya subidas al servidor,
 * por lo que no hay upload aquí, solo una inserción en BD.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

// Escaneamos el directorio de imágenes para rellenar el selector del formulario.
$directorio_imagenes = '../assets/img/historias/';
$lista_imagenes = [];
if (is_dir($directorio_imagenes)) {
    foreach (scandir($directorio_imagenes) as $archivo) {
        if ($archivo !== '.' && $archivo !== '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $archivo)) {
            $lista_imagenes[] = $archivo;
        }
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo     = trim($_POST['titulo']     ?? '');
    $testimonio = trim($_POST['testimonio'] ?? '');
    // Construimos la ruta relativa solo si se ha seleccionado una imagen del desplegable.
    $foto_url   = !empty($_POST['foto_seleccionada'])
        ? 'assets/img/historias/' . basename($_POST['foto_seleccionada'])
        : '';

    if (!empty($titulo) && !empty($testimonio)) {
        try {
            
            $sql  = "INSERT INTO historias_exito (titulo, testimonio, foto_final_url) VALUES (:titulo, :testimonio, :foto)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':titulo'     => $titulo,
                ':testimonio' => $testimonio,
                ':foto'       => $foto_url,
            ]);

            header('Location: gestionar_historias.php');
            exit();

        } catch (PDOException $e) {
            error_log('[NexAdopt - CrearHistoria Error] ' . $e->getMessage());
            $error = 'No se pudo guardar la historia. Por favor, inténtalo de nuevo.';
        }
    } else {
        $error = 'El título y el testimonio son obligatorios.';
    }
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="gestionar_historias.php" class="btn btn-outline-secondary border-0 me-3 d-inline-flex align-items-center">
            <i data-lucide="arrow-left" style="width:20px; height:20px;"></i>
        </a>
        <h2 class="fw-bold text-brand mb-0 d-flex align-items-center gap-2">
            <i data-lucide="star" style="width:28px; height:28px;"></i> Añadir Nueva Historia
        </h2>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="crear_historia.php" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase d-flex align-items-center gap-1">
                            <i data-lucide="type" style="width:14px; height:14px;"></i> Título / Nombre <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="titulo" class="form-control form-control-lg bg-light border-0" placeholder="Ej: Tyson encontró su hogar" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase d-flex align-items-center gap-1">
                            <i data-lucide="image" style="width:14px; height:14px;"></i> Selecciona Fotografía
                        </label>
                        <select name="foto_seleccionada" class="form-select form-select-lg bg-light border-0" style="cursor: pointer;">
                            <option value="">-- Selecciona imagen de la carpeta --</option>
                            <?php foreach ($lista_imagenes as $img): ?>
                                <option value="<?= htmlspecialchars($img) ?>"><?= htmlspecialchars($img) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-muted small text-uppercase d-flex align-items-center gap-1">
                            <i data-lucide="file-text" style="width:14px; height:14px;"></i> Testimonio <span class="text-danger">*</span>
                        </label>
                        <textarea name="testimonio" class="form-control bg-light border-0" rows="6" placeholder="Escribe el testimonio aquí..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-nexadopt px-5 py-2 d-inline-flex align-items-center gap-2">
                        <i data-lucide="save" style="width:16px; height:16px;"></i> Guardar Historia
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>