<?php
/**
 * Gestión del flujo de adopción: aprobar o rechazar solicitudes pendientes.
 */

session_start();

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

$mensaje_info = '';

// =========================================================================
// LÓGICA DE APROBACIÓN / RECHAZO
// =========================================================================
if (isset($_GET['accion'], $_GET['id_solicitud'], $_GET['id_mascota'])) {
    $accion   = $_GET['accion'];
    $id_sol   = (int)$_GET['id_solicitud'];
    $id_mas   = (int)$_GET['id_mascota'];

    // Solo procesamos acciones válidas para evitar manipulaciones.
    if (in_array($accion, ['aprobar', 'rechazar'], true) && $id_sol > 0 && $id_mas > 0) {

        try {
            if ($accion === 'aprobar') {
                // Envolvemos las operaciones en una transacción atómica
                $conexion->beginTransaction();

                $stmt_apro = $conexion->prepare(
                    "UPDATE Solicitudes_Adopcion SET estado_tramite = 'Aprobado' WHERE id_solicitud = :id_sol"
                );
                $stmt_apro->execute([':id_sol' => $id_sol]);

                $stmt_adop = $conexion->prepare(
                    "UPDATE Mascotas SET estado = 'Adoptado' WHERE id_mascota = :id_mas"
                );
                $stmt_adop->execute([':id_mas' => $id_mas]);

                // Rechazamos las demás solicitudes de esta mascota para mantener la coherencia.
                $stmt_rech_resto = $conexion->prepare(
                    "UPDATE Solicitudes_Adopcion SET estado_tramite = 'Rechazado' 
                     WHERE id_mascota = :id_mas AND id_solicitud != :id_sol"
                );
                $stmt_rech_resto->execute([':id_mas' => $id_mas, ':id_sol' => $id_sol]);

                $conexion->commit();
                $mensaje_info = '<div class="alert alert-success">Solicitud aprobada con éxito. La mascota ha pasado a estado "Adoptado".</div>';

            } elseif ($accion === 'rechazar') {
                $stmt_rech = $conexion->prepare(
                    "UPDATE Solicitudes_Adopcion SET estado_tramite = 'Rechazado' WHERE id_solicitud = :id"
                );
                $stmt_rech->execute([':id' => $id_sol]);
                $mensaje_info = '<div class="alert alert-secondary">Solicitud movida a rechazadas.</div>';
            }

        } catch (PDOException $e) {
            if ($conexion->inTransaction()) {
                $conexion->rollBack();
            }
            error_log('[NexAdopt - Solicitudes/Accion Error] ' . $e->getMessage());
            $mensaje_info = '<div class="alert alert-danger">Error al procesar la acción. Por favor, inténtalo de nuevo.</div>';
        }
    }
}

// =========================================================================
// FILTRADO DE SOLICITUDES
// =========================================================================
$filtros_validos = ['Todos', 'Pendiente', 'Aprobado', 'Rechazado'];


$filtro_get = $_GET['filtro'] ?? 'Todos';

// Validamos contra la lista blanca
$filtro = in_array($filtro_get, $filtros_validos) ? $filtro_get : 'Todos';

// Construimos la cláusula WHERE solo si hay un filtro activo distinto de "Todos".
$sql_solicitudes = "SELECT s.*, m.nombre AS nombre_mascota, m.foto_url, 
                           u.nombre AS nombre_usuario, u.email AS email_usuario
                    FROM Solicitudes_Adopcion s
                    JOIN Mascotas m  ON s.id_mascota = m.id_mascota
                    JOIN Usuarios u  ON s.id_usuario = u.id_usuario";

$params_filtro = [];
if ($filtro !== 'Todos') {
    $sql_solicitudes .= " WHERE s.estado_tramite = :estado";
    $params_filtro[':estado'] = $filtro;
}
$sql_solicitudes .= " ORDER BY s.fecha_solicitud DESC";

$solicitudes = [];
try {
    $stmt_sol = $conexion->prepare($sql_solicitudes);
    $stmt_sol->execute($params_filtro);
    $solicitudes = $stmt_sol->fetchAll();
} catch (PDOException $e) {
    error_log('[NexAdopt - Solicitudes/List Error] ' . $e->getMessage());
}

// =========================================================================
// PRECARGA DE RESPUESTAS DEL CUESTIONARIO
// =========================================================================
$todas_respuestas = [];
if (!empty($solicitudes)) {
    try {
        $ids_visibles = array_column($solicitudes, 'id_solicitud');
        $placeholders = implode(',', array_fill(0, count($ids_visibles), '?'));

        $stmt_resp = $conexion->prepare(
            "SELECT id_solicitud, pregunta, respuesta 
             FROM Respuestas_Adopcion 
             WHERE id_solicitud IN ($placeholders) 
             ORDER BY id"
        );
        $stmt_resp->execute($ids_visibles);

        foreach ($stmt_resp->fetchAll() as $resp) {
            $todas_respuestas[$resp['id_solicitud']][] = $resp;
        }
    } catch (PDOException $e) {
        error_log('[NexAdopt - Solicitudes/Respuestas Error] ' . $e->getMessage());
    }
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <h2 class="fw-bold text-brand mb-4 d-flex align-items-center gap-2">
        <i data-lucide="clipboard-list" style="width:28px; height:28px;"></i> Gestión de Solicitudes
    </h2>

    <div class="mb-4 d-flex gap-2">
        <a href="solicitudes.php?filtro=Todos"
           class="btn btn-sm <?= ($filtro === 'Todos') ? 'btn-dark' : 'btn-outline-dark' ?> rounded-pill px-3">
            Ver Todas
        </a>
        <a href="solicitudes.php?filtro=Pendiente"
           class="btn btn-sm <?= ($filtro === 'Pendiente') ? 'btn-warning' : 'btn-outline-warning' ?> rounded-pill px-3 d-inline-flex align-items-center gap-1">
            <i data-lucide="clock" style="width:14px; height:14px;"></i> Pendientes
        </a>
        <a href="solicitudes.php?filtro=Aprobado"
           class="btn btn-sm <?= ($filtro === 'Aprobado') ? 'btn-success' : 'btn-outline-success' ?> rounded-pill px-3 d-inline-flex align-items-center gap-1">
            <i data-lucide="check-circle" style="width:14px; height:14px;"></i> Aprobadas
        </a>
        <a href="solicitudes.php?filtro=Rechazado"
           class="btn btn-sm <?= ($filtro === 'Rechazado') ? 'btn-secondary' : 'btn-outline-secondary' ?> rounded-pill px-3 d-inline-flex align-items-center gap-1">
            <i data-lucide="folder" style="width:14px; height:14px;"></i> Rechazadas
        </a>
    </div>

    <?= $mensaje_info ?>

    <div class="row g-4">
        <?php if (!empty($solicitudes)): ?>
            <?php foreach ($solicitudes as $row):
                $badge_clase = match ($row['estado_tramite']) {
                    'Aprobado'  => 'bg-success',
                    'Rechazado' => 'bg-secondary',
                    default     => 'bg-warning text-dark',
                };
                $id_s = (int)$row['id_solicitud'];
            ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-2 <?= ($row['estado_tramite'] === 'Rechazado') ? 'opacity-75' : '' ?>">
                        <div class="row align-items-center">
                            <div class="col-md-1">
                                <img src="../assets/img/mascotas/<?= htmlspecialchars($row['foto_url']) ?>"
                                     class="rounded-circle img-fluid shadow-sm"
                                     style="aspect-ratio: 1/1; object-fit: cover;"
                                     onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=100&auto=format&fit=crop'">
                            </div>
                            <div class="col-md-5">
                                <h5 class="fw-bold mb-0">
                                    <?= htmlspecialchars($row['nombre_usuario']) ?> → <?= htmlspecialchars($row['nombre_mascota']) ?>
                                </h5>
                                <span class="text-muted small d-inline-flex align-items-center gap-1">
                                    <i data-lucide="calendar" style="width:13px; height:13px;"></i>
                                    <?= htmlspecialchars($row['fecha_solicitud']) ?>
                                </span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="badge rounded-pill px-3 py-2 <?= $badge_clase ?>">
                                    <?= htmlspecialchars($row['estado_tramite']) ?>
                                </span>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-sm btn-outline-brand fw-bold me-2 d-inline-flex align-items-center gap-1"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#respuestas_<?= $id_s ?>">
                                    <i data-lucide="eye" style="width:14px; height:14px;"></i> Ver Respuestas
                                </button>

                                <?php if ($row['estado_tramite'] === 'Pendiente'): ?>
                                    <a href="?accion=aprobar&id_solicitud=<?= $id_s ?>&id_mascota=<?= (int)$row['id_mascota'] ?>"
                                       class="btn btn-success btn-sm fw-bold d-inline-flex align-items-center gap-1">
                                        <i data-lucide="check" style="width:14px; height:14px;"></i> Aprobar
                                    </a>
                                    <a href="?accion=rechazar&id_solicitud=<?= $id_s ?>&id_mascota=<?= (int)$row['id_mascota'] ?>"
                                       class="btn btn-outline-danger btn-sm fw-bold d-inline-flex align-items-center gap-1">
                                        <i data-lucide="x" style="width:14px; height:14px;"></i> Rechazar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="collapse mt-4" id="respuestas_<?= $id_s ?>">
                            <div class="row g-2 p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold small text-muted mb-3 text-uppercase">Cuestionario de Pre-Adopción Detallado:</h6>
                                <?php
                                $respuestas_solicitud = $todas_respuestas[$id_s] ?? [];
                                if (!empty($respuestas_solicitud)):
                                    foreach ($respuestas_solicitud as $r): ?>
                                        <div class="col-md-6 border-bottom border-white py-2">
                                            <span class="d-block fw-bold text-brand small text-uppercase" style="font-size: 0.65rem;">
                                                <?= htmlspecialchars($r['pregunta']) ?>
                                            </span>
                                            <span class="text-dark small">
                                                <?= htmlspecialchars($r['respuesta'] ?: 'Sin respuesta') ?>
                                            </span>
                                        </div>
                                    <?php endforeach;
                                else: ?>
                                    <p class="text-muted small fst-italic">No hay respuestas registradas para esta solicitud.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <p class="text-muted mb-0">No hay solicitudes que mostrar para este filtro.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>