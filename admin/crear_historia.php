<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/conexion.php';

// Lector de carpeta para mostrar imágenes disponibles al crear/editar historia
$directorio_imagenes = '../assets/img/historias/';
$lista_imagenes = [];
if (is_dir($directorio_imagenes)) {
    $archivos = scandir($directorio_imagenes);
    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..' && preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo)) {
            $lista_imagenes[] = $archivo;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $testimonio = trim($_POST['testimonio']);
    $foto_url = !empty($_POST['foto_seleccionada']) ? 'assets/img/historias/' . $_POST['foto_seleccionada'] : '';

    if (!empty($titulo) && !empty($testimonio)) {
        $sql = "INSERT INTO historias_exito (titulo, testimonio, foto_final_url) VALUES (?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("sss", $titulo, $testimonio, $foto_url);
            if ($stmt->execute()) {
                header("Location: gestionar_historias.php");
                exit();
            }
            $stmt->close();
        }
    }
}

include '../includes/header_admin.php'; 
?>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="gestionar_historias.php" class="btn btn-outline-secondary border-0 me-3" style="font-size: 1.2rem;">⬅️</a>
        <h2 class="fw-bold text-brand mb-0">⭐ Añadir Nueva Historia</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="crear_historia.php" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Título / Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" class="form-control form-control-lg bg-light border-0" placeholder="Ej: Tyson encontró su hogar" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Selecciona Fotografía</label>
                        <select name="foto_seleccionada" class="form-select form-select-lg bg-light border-0" style="cursor: pointer;">
                            <option value="">-- Selecciona imagen de la carpeta --</option>
                            <?php foreach($lista_imagenes as $img): ?>
                                <option value="<?php echo htmlspecialchars($img); ?>"> <?php echo htmlspecialchars($img); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-muted small text-uppercase">Testimonio <span class="text-danger">*</span></label>
                        <textarea name="testimonio" class="form-control bg-light border-0" rows="6" placeholder="Escribe el testimonio aquí..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-nexadopt px-5 py-2"> Guardar Historia</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_admin.php'; ?>