<?php
/**
 * Inventario completo de mascotas del sistema con acciones de editar y borrar.
 * 
 * He migrado el DELETE a una sentencia preparada y el SELECT del listado
 * a fetchAll() de PDO. También he agregado un conteo de solicitudes directamente en la consulta
 */

session_start();

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

// =========================================================================
// BORRADO DE UNA MASCOTA
// =========================================================================
if (isset($_GET['eliminar'])) {
    $id_a_borrar = (int)$_GET['eliminar'];

    if ($id_a_borrar > 0) {
        try {
            $stmt_borrar = $conexion->prepare("DELETE FROM Mascotas WHERE id_mascota = :id");
            $stmt_borrar->execute([':id' => $id_a_borrar]);

            header('Location: lista_mascotas.php?msj=borrado');
            exit();

        } catch (PDOException $e) {
            error_log('[NexAdopt - ListaMascotas/Delete Error] ' . $e->getMessage());
        }
    }
}

// =========================================================================
// CARGA DEL INVENTARIO COMPLETO
// =========================================================================
// Usamos un LEFT JOIN con COUNT para saber cuántas solicitudes tiene cada mascota
// directamente en la consulta, evitando consultas adicionales dentro del bucle.
$mascotas = [];
try {
    $mascotas = $conexion->query(
        "SELECT 
             m.id_mascota, m.nombre, m.especie, m.raza, m.estado, m.foto_url, m.descripcion,
             COUNT(s.id_solicitud) AS total_solicitudes
         FROM Mascotas m
         LEFT JOIN Solicitudes_Adopcion s ON m.id_mascota = s.id_mascota
         GROUP BY m.id_mascota
         ORDER BY m.id_mascota DESC"
    )->fetchAll();
} catch (PDOException $e) {
    error_log('[NexAdopt - ListaMascotas/List Error] ' . $e->getMessage());
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-brand mb-0 d-flex align-items-center gap-2">
            <i data-lucide="paw-print" style="width:28px; height:28px;"></i> Inventario Total de Mascotas
        </h2>
        <a href="crear_mascotas.php" class="btn btn-nexadopt d-flex align-items-center gap-2">
            <i data-lucide="plus-circle" style="width:18px; height:18px;"></i> Añadir Nueva
        </a>
    </div>

    <?php if (isset($_GET['msj']) && $_GET['msj'] === 'borrado'): ?>
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
                    <?php if (!empty($mascotas)): ?>
                        <?php foreach ($mascotas as $row):
                            // Determinamos el color del badge de estado con match() de PHP 8.
                            $badge_clase = match ($row['estado']) {
                                'En proceso' => 'bg-warning text-dark',
                                'Adoptado'   => 'bg-secondary',
                                default      => 'bg-success',
                            };
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="../assets/img/mascotas/<?= htmlspecialchars($row['foto_url']) ?>"
                                         alt="<?= htmlspecialchars($row['nombre']) ?>"
                                         class="rounded-3 shadow-sm"
                                         style="width: 70px; height: 70px; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=100&auto=format&fit=crop'">
                                </td>
                                <td>
                                    <div class="fw-bold text-brand"><?= htmlspecialchars($row['nombre']) ?></div>
                                    <div class="text-muted small">ID: #<?= (int)$row['id_mascota'] ?></div>
                                </td>
                                <td>
                                    <div><?= htmlspecialchars($row['especie']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($row['raza']) ?></div>
                                </td>
                                <td>
                                    <span class="badge <?= $badge_clase ?> opacity-75">
                                        <?= htmlspecialchars($row['estado']) ?>
                                    </span>
                                </td>
                                <td class="small text-muted" style="max-width: 200px;">
                                    <?= (mb_strlen($row['descripcion']) > 45)
                                        ? htmlspecialchars(mb_substr($row['descripcion'], 0, 45)) . '...'
                                        : htmlspecialchars($row['descripcion']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                        <?= (int)$row['total_solicitudes'] ?>
                                        <i data-lucide="mail" style="width:13px; height:13px;"></i>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="editar_mascota.php?id=<?= (int)$row['id_mascota'] ?>"
                                       class="btn btn-sm btn-outline-primary border-0 me-2 d-inline-flex align-items-center gap-1">
                                        <i data-lucide="pencil" style="width:14px; height:14px;"></i> Editar
                                    </a>
                                    <a href="lista_mascotas.php?eliminar=<?= (int)$row['id_mascota'] ?>"
                                       class="btn btn-sm btn-outline-danger border-0 d-inline-flex align-items-center gap-1"
                                       onclick="return confirm('¿Eliminar a <?= htmlspecialchars(addslashes($row['nombre'])) ?>?')">
                                        <i data-lucide="trash-2" style="width:14px; height:14px;"></i> Borrar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No hay mascotas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>