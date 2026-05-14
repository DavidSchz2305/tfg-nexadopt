<?php
/**
 * Área privada del usuario: edición de datos personales y seguimiento de adopciones.
 *
 * Medidas de seguridad implementadas:
 *  - Token CSRF vía includes/csrf.php (centralizado, igual que el resto de formularios).
 *  - Verificación de sesión activa antes de cualquier operación.
 *  - Sentencias preparadas PDO para todas las consultas.
 *  - password_hash() para actualización segura de contraseña.
 *  - Validación de formato de email con FILTER_VALIDATE_EMAIL.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificamos la sesión antes de cargar cualquier dato de la BD.
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/conexion.php';
require_once 'includes/csrf.php';

$id_usuario = (int)$_SESSION['id_usuario'];
$mensaje    = '';

// =========================================================================
// LÓGICA DE ACTUALIZACIÓN DEL PERFIL
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_perfil'])) {

    // 1. Validación del token CSRF usando el módulo centralizado.
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        die("Error de seguridad: Token CSRF no válido.");
    }

    $nuevo_nombre = trim($_POST['nombre'] ?? '');
    $nuevo_email  = trim($_POST['email']  ?? '');
    $pass1        = $_POST['nueva_password']    ?? '';
    $pass2        = $_POST['confirmar_password'] ?? '';

    if (empty($nuevo_nombre) || empty($nuevo_email)) {
        $mensaje = "<div class='alert alert-warning shadow-sm border-0'>Por favor, rellena el nombre y el correo.</div>";
    } elseif (!filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "<div class='alert alert-warning shadow-sm border-0'>El formato del correo electrónico no es válido.</div>";
    } else {
        try {
            $sql_update = "UPDATE Usuarios SET nombre = :nombre, email = :email";
            $params = [
                ':nombre' => $nuevo_nombre,
                ':email'  => $nuevo_email,
                ':id'     => $id_usuario
            ];

            if (!empty($pass1)) {
                if ($pass1 === $pass2) {
                    $sql_update .= ", password = :pass";
                    $params[':pass'] = password_hash($pass1, PASSWORD_DEFAULT);
                } else {
                    throw new Exception("Las contraseñas no coinciden.");
                }
            }

            $sql_update .= " WHERE id_usuario = :id";

            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->execute($params);

            $_SESSION['nombre'] = $nuevo_nombre;
            $mensaje = "<div class='alert alert-success shadow-sm border-0'><i class='fas fa-check-circle me-2'></i> Perfil actualizado correctamente.</div>";

        } catch (Exception $e) {
            $mensaje = "<div class='alert alert-danger shadow-sm border-0'>" . htmlspecialchars($e->getMessage()) . "</div>";
        } catch (PDOException $e) {
            error_log('[NexAdopt - Perfil/Update Error] ' . $e->getMessage());
            $mensaje = "<div class='alert alert-danger shadow-sm border-0'>Error al actualizar los datos.</div>";
        }
    }
}

// =========================================================================
// CARGA DE DATOS ACTUALES E HISTORIAL DE SOLICITUDES
// =========================================================================
$nombre_actual = '';
$email_actual  = '';
$solicitudes   = [];

try {
    $stmt_user = $conexion->prepare("SELECT nombre, email FROM Usuarios WHERE id_usuario = :id LIMIT 1");
    $stmt_user->execute([':id' => $id_usuario]);
    $usuario_data = $stmt_user->fetch();

    if ($usuario_data) {
        $nombre_actual = $usuario_data['nombre'];
        $email_actual  = $usuario_data['email'];
    }

    $sql_solicitudes = "SELECT s.id_solicitud, s.estado_tramite, s.fecha_solicitud,
                               m.id_mascota, m.nombre AS mascota_nombre, m.foto_url
                        FROM Solicitudes_Adopcion s
                        JOIN Mascotas m ON s.id_mascota = m.id_mascota
                        WHERE s.id_usuario = :id
                        ORDER BY s.fecha_solicitud DESC";

    $stmt_sol = $conexion->prepare($sql_solicitudes);
    $stmt_sol->execute([':id' => $id_usuario]);
    $solicitudes = $stmt_sol->fetchAll();

} catch (PDOException $e) {
    error_log('[NexAdopt - Perfil/Load Error] ' . $e->getMessage());
}

// Generamos el token CSRF usando el módulo centralizado.
$csrf_token = generateCsrfToken();

include 'includes/header.php';
?>

<main class="site-main py-5" style="background-color: var(--c1); min-height: 80vh;">
    <div class="container py-4">

        <div class="row mb-4">
            <div class="col-12 text-start">
                <h2 class="fw-bold display-6 mb-1" style="color: var(--c4);">Mi Perfil</h2>
                <p class="text-muted">Gestiona tus datos personales y revisa el estado de tus adopciones.</p>
            </div>
        </div>

        <?= $mensaje ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($nombre_actual) ?>&background=random&color=fff&size=128"
                             alt="Avatar" class="rounded-circle mb-3 shadow-sm" style="width: 100px; height: 100px; border: 3px solid var(--c5); object-fit: cover;">
                        <h4 class="fw-bold" style="color: var(--c4);"><?= htmlspecialchars($nombre_actual) ?></h4>
                        <span class="badge <?= (isset($_SESSION['rol']) && (int)$_SESSION['rol'] === 1) ? 'bg-dark' : 'bg-light text-muted border' ?> rounded-pill px-3 py-2 mt-1">
                            <?= (isset($_SESSION['rol']) && (int)$_SESSION['rol'] === 1) ? '👑 Administrador' : '👤 Usuario' ?>
                        </span>
                    </div>

                    <hr class="opacity-25 mb-4">

                    <form action="perfil.php" method="POST">
                        <input type="hidden" name="actualizar_perfil" value="1">

                        <!-- Token CSRF: generado con el módulo centralizado includes/csrf.php -->
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control bg-light border-0" value="<?= htmlspecialchars($nombre_actual) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control bg-light border-0" value="<?= htmlspecialchars($email_actual) ?>" required>
                        </div>

                        <div class="mt-4 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px dashed #dee2e6;">
                            <p class="small fw-bold text-muted text-uppercase mb-3"><i class="fas fa-lock me-1"></i> Seguridad</p>
                            <div class="mb-3">
                                <label class="form-label small">Nueva Contraseña</label>
                                <input type="password" name="nueva_password" class="form-control border-0" placeholder="Opcional">
                            </div>
                            <div class="mb-1">
                                <label class="form-label small">Confirmar</label>
                                <input type="password" name="confirmar_password" class="form-control border-0">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 rounded-pill fw-bold text-white shadow-sm mt-4" style="background-color: var(--c4);">
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

                    <?php if (!empty($solicitudes)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="py-3 border-0">Animal</th>
                                        <th class="py-3 border-0">Fecha</th>
                                        <th class="py-3 border-0">Estado</th>
                                        <th class="py-3 border-0 text-end">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($solicitudes as $sol):
                                        $estado = $sol['estado_tramite'];
                                        $badge = match ($estado) {
                                            'Pendiente' => 'bg-warning text-dark',
                                            'Aprobado'  => 'bg-success',
                                            'Rechazado' => 'bg-danger',
                                            default     => 'bg-secondary',
                                        };
                                        $foto = !empty($sol['foto_url'])
                                            ? 'assets/img/mascotas/' . $sol['foto_url']
                                            : 'assets/img/default-mascota.jpg';
                                    ?>
                                        <tr>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= htmlspecialchars($foto) ?>" class="rounded-3 shadow-sm me-3" style="width: 45px; height: 45px; object-fit: cover;">
                                                    <span class="fw-bold text-dark"><?= htmlspecialchars($sol['mascota_nombre']) ?></span>
                                                </div>
                                            </td>
                                            <td class="py-3 text-muted small">
                                                <?= date('d/m/Y', strtotime($sol['fecha_solicitud'])) ?>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge <?= $badge ?> rounded-pill px-3 py-2 fw-bold small shadow-sm">
                                                    <?= htmlspecialchars($estado) ?>
                                                </span>
                                            </td>
                                            <td class="py-3 text-end">
                                                <a href="perfil-mascota.php?id=<?= $sol['id_mascota'] ?>"
                                                   class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">
                                                    <i class="fas fa-eye me-1"></i> Ver ficha
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-search fs-1 mb-3 text-muted"></i>
                            <h6 class="fw-bold">No tienes solicitudes activas</h6>
                            <a href="adoptar.php" class="btn btn-link text-brand fw-bold">Ver animales para adoptar</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>