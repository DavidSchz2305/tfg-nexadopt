<?php
// SEGURIDAD
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}

// CONEXIÓN
require_once '../config/conexion.php';

// ESTADÍSTICAS RÁPIDAS
$total_mascotas = $conexion->query("SELECT COUNT(*) as total FROM Mascotas")->fetch_assoc()['total'];
$pendientes = $conexion->query("SELECT COUNT(*) as total FROM Solicitudes_Adopcion WHERE estado_tramite = 'Pendiente'")->fetch_assoc()['total'];
$adoptados = $conexion->query("SELECT COUNT(*) as total FROM Mascotas WHERE estado = 'Adoptado'")->fetch_assoc()['total'];

// LÓGICA DEL GRÁFICO DINÁMICO (Adopciones por mes del año actual)
$meses_nombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$adopciones_por_mes = array_fill(0, 12, 0); 

// Buscamos las solicitudes aprobadas este año, agrupadas por mes
$sql_grafico = "SELECT MONTH(fecha_solicitud) as mes, COUNT(*) as total 
                FROM Solicitudes_Adopcion 
                WHERE estado_tramite = 'Aprobado' AND YEAR(fecha_solicitud) = YEAR(CURRENT_DATE())
                GROUP BY MONTH(fecha_solicitud)";
$res_grafico = $conexion->query($sql_grafico);

if($res_grafico && $res_grafico->num_rows > 0) {
    while($fila = $res_grafico->fetch_assoc()) {
        $mes_index = $fila['mes'] - 1; 
        $adopciones_por_mes[$mes_index] = $fila['total'];
    }
}

// Convertimos a JSON para Chart.js
$labels_js = json_encode($meses_nombres);
$datos_js = json_encode($adopciones_por_mes);

// CARGAMOS EL HEADER 
include '../includes/header_admin.php'; 
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-brand fw-bold mb-0">Panel de Control NexAdopt</h1>
        <div class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
            Sesión iniciada como: <strong><?php echo $_SESSION['nombre']; ?></strong>
        </div>
    </div>
    
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-brand fs-2 me-3" style="width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">🐾</div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Mascotas en total</h6>
                        <span class="h2 fw-bold mb-0 text-dark"><?php echo $total_mascotas; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning fs-2 me-3" style="width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">📩</div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Pendientes de revisión</h6>
                        <span class="h2 fw-bold mb-0 text-warning"><?php echo $pendientes; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success bg-opacity-10 text-success fs-2 me-3" style="width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">🏠</div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Animales Adoptados</h6>
                        <span class="h2 fw-bold mb-0 text-success"><?php echo $adoptados; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-4 d-flex align-items-center text-dark text-start">
                    <span class="me-2">⚡</span> Acciones rápidas de gestión
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <a href="crear_mascotas.php" class="text-decoration-none">
                            <div class="p-4 border rounded-3 bg-light text-center hover-shadow transition">
                                <div class="fs-1 mb-2">➕</div>
                                <div class="fs-5 fw-bold text-dark">Añadir Nueva Mascota</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="solicitudes.php" class="text-decoration-none">
                            <div class="p-4 border rounded-3 bg-light text-center hover-shadow transition">
                                <div class="fs-1 mb-2">📋</div>
                                <div class="fs-5 fw-bold text-dark">Revisar Solicitudes</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-4 text-brand">📈 Adopciones Aprobadas (<?php echo date('Y'); ?>)</h5>
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
            labels: <?php echo $labels_js; ?>, 
            datasets: [{
                label: 'Adopciones Finalizadas',
                data: <?php echo $datos_js; ?>,
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
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { stepSize: 1 } 
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>

<?php 
// CARGA DE FOOTER
include '../includes/footer_admin.php'; 
?>