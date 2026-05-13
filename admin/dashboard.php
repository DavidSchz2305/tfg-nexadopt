<?php
/**
 * Panel de control principal del back-office de NexAdopt.
 * Aquí se muestran estadísticas clave, gráficos de adopciones y accesos rápidos a las funciones más usadas por el administrador.
 * - Estadísticas rápidas: total de mascotas, solicitudes pendientes, animales adoptados. 
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Control de acceso: solo el rol 1 (Administrador) puede entrar aquí.
if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

// =========================================================================
// ESTADÍSTICAS RÁPIDAS PARA LAS TARJETAS DEL DASHBOARD
// =========================================================================

$total_mascotas = 0;
$pendientes     = 0;
$adoptados      = 0;

try {
    $total_mascotas = (int)$conexion->query("SELECT COUNT(*) FROM Mascotas")->fetchColumn();
    $pendientes     = (int)$conexion->query("SELECT COUNT(*) FROM Solicitudes_Adopcion WHERE estado_tramite = 'Pendiente'")->fetchColumn();
    $adoptados      = (int)$conexion->query("SELECT COUNT(*) FROM Mascotas WHERE estado = 'Adoptado'")->fetchColumn();
} catch (PDOException $e) {
    error_log('[NexAdopt - Dashboard/Stats Error] ' . $e->getMessage());
}

// =========================================================================
// DATOS PARA EL GRÁFICO DE ADOPCIONES POR MES (año en curso)
// =========================================================================
$meses_nombres      = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$adopciones_por_mes = array_fill(0, 12, 0);

try {
    // Agrupamos las solicitudes aprobadas del año actual por mes para construir el gráfico.
    $sql_grafico = "SELECT MONTH(fecha_solicitud) AS mes, COUNT(*) AS total 
                    FROM Solicitudes_Adopcion 
                    WHERE estado_tramite = 'Aprobado' 
                      AND YEAR(fecha_solicitud) = YEAR(CURRENT_DATE())
                    GROUP BY MONTH(fecha_solicitud)";

    $filas_grafico = $conexion->query($sql_grafico)->fetchAll();

    foreach ($filas_grafico as $fila) {
        // El mes en SQL va del 1 al 12, pero el array va del 0 al 11.
        $adopciones_por_mes[(int)$fila['mes'] - 1] = (int)$fila['total'];
    }
} catch (PDOException $e) {
    error_log('[NexAdopt - Dashboard/Grafico Error] ' . $e->getMessage());
}

// Convertimos los datos a JSON para que Chart.js los coja directamente.
$labels_js = json_encode($meses_nombres);
$datos_js  = json_encode($adopciones_por_mes);

include '../includes/header_admin.php';
?>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-brand fw-bold mb-0">Panel de Control NexAdopt</h1>
        <div class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
            Sesión iniciada como: <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>
        </div>
    </div>
    
    <!-- TARJETAS DE ESTADÍSTICAS -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-brand fs-2 me-3" style="width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i data-lucide="paw-print" style="width:32px; height:32px;"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Mascotas en total</h6>
                        <span class="h2 fw-bold mb-0 text-dark"><?= $total_mascotas ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning fs-2 me-3" style="width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i data-lucide="mail" style="width:32px; height:32px;"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Pendientes de revisión</h6>
                        <span class="h2 fw-bold mb-0 text-warning"><?= $pendientes ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success bg-opacity-10 text-success fs-2 me-3" style="width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i data-lucide="home" style="width:32px; height:32px;"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Animales Adoptados</h6>
                        <span class="h2 fw-bold mb-0 text-success"><?= $adoptados ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACCIONES RÁPIDAS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-4 d-flex align-items-center text-dark text-start">
                    <i data-lucide="zap" class="me-2" style="width:20px; height:20px;"></i> Acciones rápidas de gestión
                </h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="crear_mascotas.php" class="text-decoration-none">
                            <div class="p-4 border rounded-3 bg-light text-center hover-shadow transition h-100">
                                <div class="fs-1 mb-2 d-flex justify-content-center">
                                    <i data-lucide="plus-circle" style="width:48px; height:48px;"></i>
                                </div>
                                <div class="fs-5 fw-bold text-dark">Añadir Nueva Mascota</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="solicitudes.php" class="text-decoration-none">
                            <div class="p-4 border rounded-3 bg-light text-center hover-shadow transition h-100">
                                <div class="fs-1 mb-2 d-flex justify-content-center">
                                    <i data-lucide="clipboard-list" style="width:48px; height:48px;"></i>
                                </div>
                                <div class="fs-5 fw-bold text-dark">Revisar Solicitudes</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="crear_historia.php" class="text-decoration-none">
                            <div class="p-4 border rounded-3 bg-light text-center hover-shadow transition h-100">
                                <div class="fs-1 mb-2 d-flex justify-content-center">
                                    <i data-lucide="star" style="width:48px; height:48px;"></i>
                                </div>
                                <div class="fs-5 fw-bold text-dark">Añadir Nueva Historia</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GRÁFICO DE ADOPCIONES -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-4 text-brand d-flex align-items-center">
                    <i data-lucide="trending-up" class="me-2" style="width:20px; height:20px;"></i> Adopciones Aprobadas (<?= date('Y') ?>)
                </h5>
                <div style="height: 350px;">
                    <canvas id="graficoAdopciones"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoAdopciones').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $labels_js ?>,
            datasets: [{
                label: 'Adopciones Finalizadas',
                data: <?= $datos_js ?>,
                borderColor: '#c24e35',
                backgroundColor: 'rgba(194, 78, 53, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#c24e35',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { position: 'top' } }
        }
    });

    lucide.createIcons();
</script>

<?php include '../includes/footer_admin.php'; ?>