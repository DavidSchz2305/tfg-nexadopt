<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/conexion.php';

$directorio_imagenes = '../assets/img/historias/';
$lista_imagenes = [];
if (is_dir($directorio_imagenes)) {
    $archivos = scandir($directorio_imagenes);
    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $archivo)) {
            $lista_imagenes[] = $archivo;
        }
    }
}

$id_historia = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_historia = intval($_POST['id_historia']);
    $titulo = trim($_POST['titulo']);
    $testimonio = trim($_POST['testimonio']);
    $foto_url = !empty($_POST['foto_seleccionada']) ? 'assets/img/historias/' . $_POST['foto_seleccionada'] : '';

    if (!empty($titulo) && !empty($testimonio)) {
        $sql = "UPDATE historias_exito SET titulo = ?, testimonio = ?, foto_final_url = ? WHERE id_historia = ?";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("sssi", $titulo, $testimonio, $foto_url, $id_historia);
            if ($stmt->execute()) {
                header("Location: gestionar_historias.php");
                exit();
            }
            $stmt->close();
        }
    }
}

$titulo_actual = "";
$testimonio_actual = "";
$foto_actual = "";

if ($id_historia > 0) {
    $sql = "SELECT titulo, testimonio, foto_final_url FROM historias_exito WHERE id_historia = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id_historia);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($fila = $resultado->fetch_assoc()) {
            $titulo_actual = $fila['titulo'];
            $testimonio_actual = $fila['testimonio'];
            $foto_actual = basename($fila['foto_final_url']); 
        } else {
            die("Historia no encontrada.");
        }
        $stmt->close();
    }
} else {
    die("ID no válido.");
}

include '../includes/header_admin.php'; 
?>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="gestionar_historias.php" class="btn btn-outline-secondary border-0 me-3" style="font-size: 1.2rem;">⬅️</a>
        <h2 class="fw-bold text-brand mb-0">✏️ Editar Historia #<?php echo $id_historia; ?></h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="editar_historia.php?id=<?php echo $id_historia; ?>" method="POST">
                    <input type="hidden" name="id_historia" value="<?php echo $id_historia; ?>">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Título / Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" class="form-control form-control-lg bg-light border-0" value="<?php echo htmlspecialchars($titulo_actual); ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Fotografía</label>
                        <select name="foto_seleccionada" class="form-select form-select-lg bg-light border-0" style="cursor: pointer;">
                            <option value="">-- Sin foto --</option>
                            <?php foreach($lista_imagenes as $img): ?>
                                <option value="<?php echo htmlspecialchars($img); ?>" <?php if($img == $foto_actual) echo 'selected'; ?>>
                                     <?php echo htmlspecialchars($img); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-muted small text-uppercase">Testimonio <span class="text-danger">*</span></label>
                        <textarea name="testimonio" class="form-control bg-light border-0" rows="6" required><?php echo htmlspecialchars($testimonio_actual); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-nexadopt px-5 py-2"> Actualizar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_admin.php'; ?>