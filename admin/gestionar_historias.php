<?php
/**
 * Inventario de historias de adopción exitosa con opciones de editar y borrar.
 * 
 * He convertido el DELETE a una sentencia preparada para prevenir inyecciones.
 * Para la consulta de listado, al no haber parámetros de usuario uso query()
 * directamente, que con PDO ya es seguro para consultas sin input externo.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

// =========================================================================
// BORRADO DE UNA HISTORIA
// =========================================================================
// Aunque el ID viene por GET, lo casteamos a entero y usamos una sentencia
// preparada para asegurarnos de que nunca se interpole directamente en el SQL.
if (isset($_GET['eliminar'])) {
    $id_a_borrar = (int)$_GET['eliminar'];

    if ($id_a_borrar > 0) {
        try {
            $stmt_borrar = $conexion->prepare("DELETE FROM historias_exito WHERE id_historia = :id");
            $stmt_borrar->execute([':id' => $id_a_borrar]);

            header('Location: gestionar_historias.php?msj=borrado');
            exit();

        } catch (PDOException $e) {
            error_log('[NexAdopt - GestionarHistorias/Delete Error] ' . $e->getMessage());
        }
    }
}

// =========================================================================
// CARGA DEL LISTADO
// =========================================================================
$historias = [];
try {
    $stmt_lista = $conexion->query(
        "SELECT id_historia, titulo, testimonio, foto_final_url, fecha_publicacion 
         FROM historias_exito 
         ORDER BY fecha_publicacion DESC"
    );
    $historias = $stmt_lista->fetchAll();
} catch (PDOException $e) {
    error_log('[NexAdopt - GestionarHistorias/List Error] ' . $e->getMessage());
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-brand mb-0 d-flex align-items-center gap-2">
            <i data-lucide="star" style="width:28px; height:28px;"></i> Inventario Total de Historias
        </h2>
        <a href="crear_historia.php" class="btn btn-nexadopt d-inline-flex align-items-center gap-2">
            <i data-lucide="plus-circle" style="width:18px; height:18px;"></i> Añadir Nueva
        </a>
    </div>

    <?php if (isset($_GET['msj']) && $_GET['msj'] === 'borrado'): ?>
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
                    <?php if (!empty($historias)): ?>
                        <?php foreach ($historias as $row):
                            $foto = !empty($row['foto_final_url'])
                                ? '../' . $row['foto_final_url']
                                : '../assets/img/default-mascota.jpg';
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="<?= htmlspecialchars($foto) ?>"
                                         alt="" class="rounded-3 shadow-sm"
                                         style="width: 70px; height: 70px; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=100&auto=format&fit=crop'">
                                </td>
                                <td>
                                    <div class="fw-bold text-brand"><?= htmlspecialchars($row['titulo']) ?></div>
                                    <div class="text-muted small">ID: #<?= (int)$row['id_historia'] ?></div>
                                </td>
                                <td class="small text-muted" style="max-width: 250px;">
                                    <?= (mb_strlen($row['testimonio']) > 60)
                                        ? htmlspecialchars(mb_substr($row['testimonio'], 0, 60)) . '...'
                                        : htmlspecialchars($row['testimonio']) ?>
                                </td>
                                <td>
                                    <div class="text-muted small fw-bold d-flex align-items-center gap-1">
                                        <i data-lucide="calendar" style="width:13px; height:13px;"></i>
                                        <?= date('d/m/Y', strtotime($row['fecha_publicacion'])) ?>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="editar_historia.php?id=<?= (int)$row['id_historia'] ?>"
                                       class="btn btn-sm btn-outline-primary border-0 me-2 d-inline-flex align-items-center gap-1">
                                        <i data-lucide="pencil" style="width:14px; height:14px;"></i> Editar
                                    </a>
                                    <a href="gestionar_historias.php?eliminar=<?= (int)$row['id_historia'] ?>"
                                       class="btn btn-sm btn-outline-danger border-0 d-inline-flex align-items-center gap-1"
                                       onclick="return confirm('¿Eliminar la historia de <?= htmlspecialchars(addslashes($row['titulo'])) ?>?')">
                                        <i data-lucide="trash-2" style="width:14px; height:14px;"></i> Borrar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No hay historias guardadas. Haz clic en "Añadir Nueva".
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>