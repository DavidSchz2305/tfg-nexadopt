<?php
/**
 * Registro de nuevos usuarios en la plataforma.
 *
 * Medidas de seguridad implementadas:
 * - Token CSRF (includes/csrf.php) para proteger el formulario.
 * - Verificación de unicidad del email antes del INSERT.
 * - password_hash() con algoritmo BCRYPT (PASSWORD_DEFAULT) para almacenar credenciales.
 * - Validación mínima de longitud de contraseña (8 caracteres).
 * - Rol 2 asignado por defecto (usuario estándar); los admin solo se crean desde el panel.
 */

session_start();
require_once 'config/conexion.php';
require_once 'includes/csrf.php';

// Si ya está logueado, no tiene sentido que vea esta página.
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validación del token CSRF antes de procesar cualquier campo del formulario.
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $mensaje = '<div class="alert alert-danger">Error de seguridad. Por favor, recarga la página e inténtalo de nuevo.</div>';
    } else {

        $nombre        = trim($_POST['nombre']        ?? '');
        $apellidos     = trim($_POST['apellidos']     ?? '');
        $email         = trim($_POST['email']         ?? '');
        $telefono      = trim($_POST['telefono']      ?? '');
        $password      = $_POST['password']           ?? '';
        $password_conf = $_POST['password_conf']      ?? '';

        if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
            $mensaje = '<div class="alert alert-danger">Por favor, rellena todos los campos obligatorios.</div>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $mensaje = '<div class="alert alert-danger">Por favor, introduce una dirección de correo electrónico válida.</div>';
        } elseif ($password !== $password_conf) {
            $mensaje = '<div class="alert alert-danger">Las contraseñas no coinciden.</div>';
        } elseif (strlen($password) < 8) {
            $mensaje = '<div class="alert alert-danger">La contraseña debe tener al menos 8 caracteres.</div>';
        } else {
            try {
                // 2. Comprobamos si el email ya existe para evitar duplicados.
                $stmt_check = $conexion->prepare("SELECT id_usuario FROM Usuarios WHERE email = :email LIMIT 1");
                $stmt_check->execute([':email' => $email]);

                if ($stmt_check->fetch()) {
                    $mensaje = '<div class="alert alert-warning">Ese correo ya está registrado. <a href="login.php" class="alert-link">Inicia sesión aquí</a>.</div>';
                } else {
                    // 3. Hasheamos la contraseña con BCRYPT antes de guardarla.
                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                    // 4. Insertamos el nuevo usuario con rol 2 (usuario estándar).
                    $sql_insert = "INSERT INTO Usuarios (id_rol, nombre, apellidos, email, password, telefono)
                                   VALUES (2, :nombre, :apellidos, :email, :password, :telefono)";
                    $stmt_insert = $conexion->prepare($sql_insert);
                    $stmt_insert->execute([
                        ':nombre'    => $nombre,
                        ':apellidos' => $apellidos,
                        ':email'     => $email,
                        ':password'  => $password_hashed,
                        ':telefono'  => $telefono ?: null,
                    ]);

                    $mensaje = '<div class="alert alert-success">¡Registro completado con éxito! <a href="login.php" class="alert-link">Ya puedes iniciar sesión</a>.</div>';
                }

            } catch (PDOException $e) {
                error_log('[NexAdopt - Registro Error] ' . $e->getMessage());
                $mensaje = '<div class="alert alert-danger">Hubo un error técnico al registrar tu cuenta. Por favor, inténtalo de nuevo.</div>';
            }
        }
    }
}

// Generamos el token CSRF y lo pasamos a la vista.
$csrf_token = generateCsrfToken();

include 'includes/header.php';
?>

<main class="site-main bg-crema py-5 d-flex align-items-center" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4 card-nexadopt bg-white overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-brand">Crear cuenta</h2>
                            <p class="text-muted">Únete a NexAdopt y da el primer paso para cambiar una vida.</p>
                        </div>

                        <?= $mensaje ?>

                        <form action="registro.php" method="POST">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold text-brand">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border-c2 px-3 py-2" id="nombre" name="nombre" required placeholder="Ej. Ana">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label fw-semibold text-brand">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control border-c2 px-3 py-2" id="apellidos" name="apellidos" required placeholder="Ej. García López">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold text-brand">Correo electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control border-c2 px-3 py-2" id="email" name="email" required placeholder="tu@email.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold text-brand">Teléfono</label>
                                    <input type="tel" class="form-control border-c2 px-3 py-2" id="telefono" name="telefono" placeholder="Opcional">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold text-brand">Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control border-c2 px-3 py-2" id="password" name="password" required placeholder="Mínimo 8 caracteres">
                            </div>

                            <div class="mb-4">
                                <label for="password_conf" class="form-label fw-semibold text-brand">Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control border-c2 px-3 py-2" id="password_conf" name="password_conf" required placeholder="Repite la contraseña">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-nexadopt py-2 fs-5">Registrarme</button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="text-muted small">¿Ya tienes cuenta? <a href="login.php" class="text-accent fw-bold text-decoration-none">Inicia sesión aquí</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>