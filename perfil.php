<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. SEGURIDAD: Si no está logueado, lo echamos al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

require_once 'config/conexion.php';

$id_usuario = $_SESSION['id_usuario'];
$mensaje = "";

// 2. LÓGICA PARA ACTUALIZAR DATOS
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_perfil'])) {
    $nuevo_nombre = trim($_POST['nombre']);
    $nuevo_email = trim($_POST['email']);
    
    if (!empty($nuevo_nombre) && !empty($nuevo_email)) {
        // Actualizamos en la base de datos
        $sql_update = "UPDATE usuarios SET nombre = ?, email = ? WHERE id_usuario = ?";
        if ($stmt = $conexion->prepare($sql_update)) {
            $stmt->bind_param("ssi", $nuevo_nombre, $nuevo_email, $id_usuario);
            if ($stmt->execute()) {
                // Actualizamos la variable de sesión para que el Header cambie el nombre al instante
                $_SESSION['nombre'] = $nuevo_nombre;
                $mensaje = "<div class='alert alert-success shadow-sm border-0'><i class='fas fa-check-circle me-2'></i> Perfil actualizado correctamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger shadow-sm border-0'>Error al actualizar los datos.</div>";
            }
            $stmt->close();
        }
    } else {
        $mensaje = "<div class='alert alert-warning shadow-sm border-0'>Por favor, rellena todos los campos.</div>";
    }
}

// 3. OBTENER DATOS ACTUALES DEL USUARIO
$nombre_actual = "";
$email_actual = "";
$sql_user = "SELECT nombre, email FROM usuarios WHERE id_usuario = ?";
if ($stmt = $conexion->prepare($sql_user)) {
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado_user = $stmt->get_result();
    if ($fila = $resultado_user->fetch_assoc()) {
        $nombre_actual = $fila['nombre'];
        $email_actual = $fila['email'];
    }
    $stmt->close();
}

// 4. OBTENER LAS SOLICITUDES DE ADOPCIÓN DE ESTE USUARIO
$sql_solicitudes = "SELECT s.id_solicitud, s.estado_tramite, s.fecha_solicitud, m.nombre AS mascota_nombre, m.foto_url 
                    FROM Solicitudes_Adopcion s 
                    JOIN Mascotas m ON s.id_mascota = m.id_mascota 
                    WHERE s.id_usuario = ? 
                    ORDER BY s.fecha_solicitud DESC";
$stmt_sol = $conexion->prepare($sql_solicitudes);
$stmt_sol->bind_param("i", $id_usuario);
$stmt_sol->execute();
$resultado_solicitudes = $stmt_sol->get_result();

include 'includes/header.php';
?>

<main class="site-main py-5" style="background-color: var(--c1); min-height: 80vh;">
    <div class="container py-4">
        
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold display-6 mb-1" style="color: var(--c4);">Mi Perfil</h2>
                <p class="text-muted">Gestiona tus datos personales y revisa el estado de tus adopciones.</p>
            </div>
        </div>

        <?php echo $mensaje; ?>

        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-start bg-white h-100">
                    <div class="text-center mb-4">
                        
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($nombre_actual); ?>&background=random&color=fff&size=128" 
                             alt="Avatar de <?php echo htmlspecialchars($nombre_actual); ?>" 
                             class="rounded-circle mb-3 shadow-sm" 
                             style="width: 100px; height: 100px; border: 3px solid var(--c5); object-fit: cover;">
                        
                        <h4 class="fw-bold" style="color: var(--c4);"><?php echo htmlspecialchars($nombre_actual); ?></h4>
                        
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                            <span class="badge bg-dark text-white rounded-pill px-3 py-2 mt-1 shadow-sm">👑 Administrador</span>
                        <?php else: ?>
                            <span class="badge bg-light text-muted border border-secondary rounded-pill px-3 py-2 mt-1">👤 Usuario</span>
                        <?php endif; ?>

                    </div>

                    <hr class="opacity-25 mb-4">

                    <form action="perfil.php" method="POST">
                        <input type="hidden" name="actualizar_perfil" value="1">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($nombre_actual); ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($email_actual); ?>" required>
                        </div>

                        <button type="submit" class="btn w-100 rounded-pill fw-bold text-white shadow-sm" style="background-color: var(--c4);">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
                    <h5 class="fw-bold mb-4 d-flex align-items-center" style="color: var(--c4);">
                        <i class="fas fa-paw me-2" style="color: var(--c5);"></i> Mis procesos de adopción
                    </h5>

                    <?php if ($resultado_solicitudes && $resultado_solicitudes->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted small text-uppercase" style="border-bottom: 2px solid #eaeaea;">
                                    <tr>
                                        <th class="py-3 border-0">Animal</th>
                                        <th class="py-3 border-0">Fecha de Solicitud</th>
                                        <th class="py-3 border-0 text-end">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while($solicitud = $resultado_solicitudes->fetch_assoc()): 
                                        $estado = $solicitud['estado_tramite'];
                                        $badge_class = 'bg-secondary';
                                        if ($estado == 'Pendiente') $badge_class = 'bg-warning text-dark';
                                        if ($estado == 'Aprobado') $badge_class = 'bg-success';
                                        if ($estado == 'Rechazado') $badge_class = 'bg-danger';

                                        $foto = !empty($solicitud['foto_url']) ? "assets/img/mascotas/" . $solicitud['foto_url'] : 'assets/img/default-mascota.jpg';
                                    ?>
                                        <tr>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo htmlspecialchars($foto); ?>" class="rounded-3 shadow-sm me-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=100&auto=format&fit=crop'">
                                                    <span class="fw-bold" style="color: var(--c4);"><?php echo htmlspecialchars($solicitud['mascota_nombre']); ?></span>
                                                </div>
                                            </td>
                                            <td class="py-3 text-muted small">
                                                <?php echo date("d/m/Y", strtotime($solicitud['fecha_solicitud'])); ?>
                                            </td>
                                            <td class="py-3 text-end">
                                                <span class="badge <?php echo $badge_class; ?> rounded-pill px-3 py-2 fw-bold shadow-sm">
                                                    <?php echo htmlspecialchars($estado); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px; color: var(--c2);">
                                <i class="fas fa-search fs-1"></i>
                            </div>
                            <h6 class="fw-bold" style="color: var(--c4);">Aún no tienes solicitudes en curso</h6>
                            <p class="text-muted small mb-4">¿Estás listo para darle un hogar a un peludo?</p>
                            <a href="adoptar.php" class="btn rounded-pill px-4 py-2 text-white fw-bold shadow-sm" style="background-color: var(--c5);">
                                Ver mascotas disponibles
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>