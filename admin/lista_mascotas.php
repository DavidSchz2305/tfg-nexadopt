<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}
require_once '../config/conexion.php';

// --- Codigo para borrar una mascota ---
if (isset($_GET['eliminar'])) {
    $id_a_borrar = $_GET['eliminar'];
    $sql_borrar = "DELETE FROM Mascotas WHERE id_mascota = ?";
    $stmt = $conexion->prepare($sql_borrar);
    $stmt->bind_param("i", $id_a_borrar);
    
    if ($stmt->execute()) {
        header("Location: lista_mascotas.php?msj=borrado");
        exit();
    }
}

// --- CONSULTA ---
$sql = "SELECT m.id_mascota, m.nombre, m.especie, m.raza, m.estado, m.foto_url, m.descripcion,
               COUNT(s.id_solicitud) AS total_solicitudes
        FROM Mascotas m
        LEFT JOIN Solicitudes_Adopcion s ON m.id_mascota = s.id_mascota
        GROUP BY m.id_mascota
        ORDER BY m.id_mascota DESC";

$resultado = $conexion->query($sql);


include '../includes/header_admin.php'; 
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-brand mb-0">🐾 Inventario Total de Mascotas</h2>
        <a href="crear_mascotas.php" class="btn btn-nexadopt">➕ Añadir Nueva</a>
    </div>

    <?php if(isset($_GET['msj']) && $_GET['msj'] == 'borrado'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Mascota eliminada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Foto</th>
                        <th>Nombre</th>
                        <th>Especie / Raza</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Solicitudes</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultado && $resultado->num_rows > 0): ?>
                        <?php while($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="../assets/img/mascotas/<?php echo $row['foto_url']; ?>" 
                                         alt="" class="rounded-3 shadow-sm" 
                                         style="width: 70px; height: 70px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold text-brand"><?php echo $row['nombre']; ?></div>
                                    <div class="text-muted small">ID: #<?php echo $row['id_mascota']; ?></div>
                                </td>
                                <td>
                                    <div><?php echo $row['especie']; ?></div>
                                    <div class="text-muted small"><?php echo $row['raza']; ?></div>
                                </td>
                                <td>
                                    <?php 
                                        $clase = 'bg-success';
                                        if($row['estado'] == 'En proceso') $clase = 'bg-warning text-dark';
                                        if($row['estado'] == 'Adoptado') $clase = 'bg-secondary';
                                    ?>
                                    <span class="badge <?php echo $clase; ?> opacity-75">
                                        <?php echo $row['estado']; ?>
                                    </span>
                                </td>
                                <td class="small text-muted" style="max-width: 200px;">
                                    <?php echo (strlen($row['descripcion']) > 45) ? substr($row['descripcion'], 0, 45) . '...' : $row['descripcion']; ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill px-3">
                                        <?php echo $row['total_solicitudes']; ?> 📩
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="editar_mascota.php?id=<?php echo $row['id_mascota']; ?>" class="btn btn-sm btn-outline-primary border-0 me-2">✏️ Editar</a>
                                    <a href="lista_mascotas.php?eliminar=<?php echo $row['id_mascota']; ?>" 
                                       class="btn btn-sm btn-outline-danger border-0" 
                                       onclick="return confirm('¿Eliminar a <?php echo $row['nombre']; ?>?')">🗑️ Borrar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">No hay datos.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
include '../includes/footer_admin.php'; 
?>