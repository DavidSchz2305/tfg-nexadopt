<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/conexion.php';

// --- Codigo para borrar una historia ---
if (isset($_GET['eliminar'])) {
    $id_a_borrar = intval($_GET['eliminar']);
    $sql_borrar = "DELETE FROM historias_exito WHERE id_historia = ?";
    $stmt = $conexion->prepare($sql_borrar);
    $stmt->bind_param("i", $id_a_borrar);
    
    if ($stmt->execute()) {
        header("Location: gestionar_historias.php?msj=borrado");
        exit();
    }
}

// --- CONSULTA ---
$sql = "SELECT id_historia, titulo, testimonio, foto_final_url, fecha_publicacion FROM historias_exito ORDER BY fecha_publicacion DESC";
$resultado = $conexion->query($sql);

include '../includes/header_admin.php'; 
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-brand mb-0">⭐ Inventario Total de Historias</h2>
        <a href="crear_historia.php" class="btn btn-nexadopt">➕ Añadir Nueva</a>
    </div>

    <?php if(isset($_GET['msj']) && $_GET['msj'] == 'borrado'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Historia eliminada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Foto</th>
                        <th>Nombre / Título</th>
                        <th>Testimonio</th>
                        <th>Fecha de Publicación</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultado && $resultado->num_rows > 0): ?>
                        <?php while($row = $resultado->fetch_assoc()): 
                            $foto = !empty($row['foto_final_url']) ? "../" . $row['foto_final_url'] : '../assets/img/default-mascota.jpg';
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="<?php echo htmlspecialchars($foto); ?>" 
                                         alt="" class="rounded-3 shadow-sm" 
                                         style="width: 70px; height: 70px; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=100&auto=format&fit=crop'">
                                </td>
                                <td>
                                    <div class="fw-bold text-brand"><?php echo htmlspecialchars($row['titulo']); ?></div>
                                    <div class="text-muted small">ID: #<?php echo $row['id_historia']; ?></div>
                                </td>
                                <td class="small text-muted" style="max-width: 250px;">
                                    <?php echo (strlen($row['testimonio']) > 60) ? substr(htmlspecialchars($row['testimonio']), 0, 60) . '...' : htmlspecialchars($row['testimonio']); ?>
                                </td>
                                <td>
                                    <div class="text-muted small fw-bold">
                                        📅 <?php echo date("d/m/Y", strtotime($row['fecha_publicacion'])); ?>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="editar_historia.php?id=<?php echo $row['id_historia']; ?>" class="btn btn-sm btn-outline-primary border-0 me-2">✏️ Editar</a>
                                    <a href="gestionar_historias.php?eliminar=<?php echo $row['id_historia']; ?>" 
                                       class="btn btn-sm btn-outline-danger border-0" 
                                       onclick="return confirm('¿Eliminar la historia de <?php echo htmlspecialchars($row['titulo']); ?>?')">🗑️ Borrar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">No hay historias guardadas. Haz clic en "Añadir Nueva".</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
include '../includes/footer_admin.php'; 
?>