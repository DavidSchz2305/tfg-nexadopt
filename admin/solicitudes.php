<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../index.php"); exit(); }
require_once '../config/conexion.php';

$mensaje_info = "";

// Lógica de aprobación/rechazo
if (isset($_GET['accion']) && isset($_GET['id_solicitud'])) {
    $accion = $_GET['accion'];
    $id_sol = (int)$_GET['id_solicitud'];
    $id_mas = (int)$_GET['id_mascota'];

    if ($accion == 'aprobar') {
        $conexion->query("UPDATE Solicitudes_Adopcion SET estado_tramite = 'Aprobado' WHERE id_solicitud = $id_sol");
        $conexion->query("UPDATE Mascotas SET estado = 'Adoptado' WHERE id_mascota = $id_mas");
        $conexion->query("UPDATE Solicitudes_Adopcion SET estado_tramite = 'Rechazado' WHERE id_mascota = $id_mas AND id_solicitud != $id_sol");
        $mensaje_info = '<div class="alert alert-success">Solicitud aprobada con éxito.</div>';
    } elseif ($accion == 'rechazar') {
        $conexion->query("UPDATE Solicitudes_Adopcion SET estado_tramite = 'Rechazado' WHERE id_solicitud = $id_sol");
        $mensaje_info = '<div class="alert alert-secondary">Solicitud movida a rechazadas.</div>';
    }
}

// Filtrado de solicitudes
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'Todos';
$where_clause = "";

if ($filtro == 'Pendiente') {
    $where_clause = " WHERE s.estado_tramite = 'Pendiente'";
} elseif ($filtro == 'Aprobado') {
    $where_clause = " WHERE s.estado_tramite = 'Aprobado'";
} elseif ($filtro == 'Rechazado') {
    $where_clause = " WHERE s.estado_tramite = 'Rechazado'";
}

$sql = "SELECT s.*, m.nombre AS nombre_mascota, m.foto_url, u.nombre AS nombre_usuario, u.email AS email_usuario 
        FROM Solicitudes_Adopcion s 
        JOIN Mascotas m ON s.id_mascota = m.id_mascota 
        JOIN Usuarios u ON s.id_usuario = u.id_usuario 
        $where_clause 
        ORDER BY s.fecha_solicitud DESC";

$resultado = $conexion->query($sql);
include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <h2 class="fw-bold text-brand mb-4">📋 Gestión de Solicitudes</h2>

    <div class="mb-4 d-flex gap-2">
        <a href="solicitudes.php?filtro=Todos" class="btn btn-sm <?= ($filtro == 'Todos') ? 'btn-dark' : 'btn-outline-dark' ?> rounded-pill px-3">Ver Todas</a>
        <a href="solicitudes.php?filtro=Pendiente" class="btn btn-sm <?= ($filtro == 'Pendiente') ? 'btn-warning' : 'btn-outline-warning' ?> rounded-pill px-3">⏳ Pendientes</a>
        <a href="solicitudes.php?filtro=Aprobado" class="btn btn-sm <?= ($filtro == 'Aprobado') ? 'btn-success' : 'btn-outline-success' ?> rounded-pill px-3">✅ Aprobadas</a>
        <a href="solicitudes.php?filtro=Rechazado" class="btn btn-sm <?= ($filtro == 'Rechazado') ? 'btn-secondary' : 'btn-outline-secondary' ?> rounded-pill px-3">📁 Rechazadas</a>
    </div>

    <?= $mensaje_info ?>

    <div class="row g-4">
        <?php while($row = $resultado->fetch_assoc()): ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-2 <?= ($row['estado_tramite'] == 'Rechazado') ? 'opacity-75' : '' ?>">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <img src="../assets/img/mascotas/<?= htmlspecialchars($row['foto_url']) ?>" class="rounded-circle img-fluid shadow-sm" style="aspect-ratio: 1/1; object-fit: cover;">
                        </div>
                        <div class="col-md-5">
                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($row['nombre_usuario']) ?> → <?= htmlspecialchars($row['nombre_mascota']) ?></h5>
                            <span class="text-muted small">📅 <?= $row['fecha_solicitud'] ?></span>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="badge rounded-pill px-3 py-2 <?= ($row['estado_tramite'] == 'Aprobado') ? 'bg-success' : (($row['estado_tramite'] == 'Rechazado') ? 'bg-secondary' : 'bg-warning text-dark') ?>">
                                <?= $row['estado_tramite'] ?>
                            </span>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-sm btn-outline-brand fw-bold me-2" type="button" data-bs-toggle="collapse" data-bs-target="#respuestas_<?= $row['id_solicitud'] ?>">
                                 Ver Respuestas
                            </button>

                            <?php if($row['estado_tramite'] == 'Pendiente'): ?>
                                <a href="?accion=aprobar&id_solicitud=<?= $row['id_solicitud'] ?>&id_mascota=<?= $row['id_mascota'] ?>" class="btn btn-success btn-sm fw-bold">Aprobar</a>
                                <a href="?accion=rechazar&id_solicitud=<?= $row['id_solicitud'] ?>&id_mascota=<?= $row['id_mascota'] ?>" class="btn btn-outline-danger btn-sm fw-bold">Rechazar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="collapse mt-4" id="respuestas_<?= $row['id_solicitud'] ?>">
                        <div class="row g-2 p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold small text-muted mb-3 text-uppercase">Cuestionario de Pre-Adopción Detallado:</h6>
                            <?php 
                            $id_s = $row['id_solicitud'];
                            $respuestas = $conexion->query("SELECT * FROM Respuestas_Adopcion WHERE id_solicitud = $id_s");
                            while($r = $respuestas->fetch_assoc()): ?>
                                <div class="col-md-6 border-bottom border-white py-2">
                                    <span class="d-block fw-bold text-brand small text-uppercase" style="font-size: 0.65rem;"><?= htmlspecialchars($r['pregunta']) ?></span>
                                    <span class="text-dark small"><?= htmlspecialchars($r['respuesta'] ?: 'Sin respuesta') ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer_admin.php'; ?>