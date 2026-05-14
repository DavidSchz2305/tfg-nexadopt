<?php
/**
 * Sistema de autenticación de usuarios.
 *
 * Medidas de seguridad implementadas:
 *  - Token CSRF (includes/csrf.php) para proteger el formulario.
 *  - Consulta PDO preparada: el parámetro :email nunca se interpola en SQL.
 *  - password_verify() para comparación segura del hash bcrypt almacenado.
 *  - session_regenerate_id(true) tras login para prevenir Session Fixation.
 *  - Mensaje de error único para prevenir enumeración de usuarios.
 */

session_start();
require_once 'config/conexion.php';
require_once 'includes/csrf.php';

// Si el usuario ya tiene sesión activa, lo redirigimos directamente al inicio.
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validación del token CSRF: primera línea de defensa antes de procesar
    //    cualquier dato enviado por el usuario.
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Error de seguridad. Por favor, recarga la página e inténtalo de nuevo.';
    } else {

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $error = 'Por favor, rellena todos los campos.';
        } else {
            try {
                // 2. Buscamos al usuario por email con sentencia preparada PDO.
                $sql  = "SELECT id_usuario, nombre, password, id_rol FROM Usuarios WHERE email = :email LIMIT 1";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([':email' => $email]);
                $usuario = $stmt->fetch();

                // 3. Mensaje único independientemente de si el email no existe
                //    o la contraseña es incorrecta, para prevenir enumeración de usuarios.
                if ($usuario && password_verify($password, $usuario['password'])) {

                    // 4. Regeneramos el ID de sesión para prevenir ataques de Session Fixation.
                    session_regenerate_id(true);

                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombre']     = $usuario['nombre'];
                    $_SESSION['rol']        = $usuario['id_rol'];

                    header('Location: index.php');
                    exit();

                } else {
                    $error = 'Credenciales incorrectas. Por favor, inténtalo de nuevo.';
                }

            } catch (PDOException $e) {
                error_log('[NexAdopt - Login Error] ' . $e->getMessage());
                $error = 'Ha ocurrido un error técnico. Por favor, inténtalo de nuevo.';
            }
        }
    }
}

// Generamos el token CSRF y lo pasamos a la vista para insertarlo en el formulario.
$csrf_token = generateCsrfToken();

include 'includes/header.php';
?>

<main class="site-main bg-crema py-5 d-flex align-items-center" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4 card-nexadopt bg-white p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-brand">Iniciar Sesión</h2>
                        <p class="text-muted">¡Hola de nuevo! Entra para gestionar tus adopciones.</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">

                        <!-- Token CSRF: campo oculto que protege el formulario contra ataques CSRF.
                             Generado con random_bytes(32) y validado en el servidor con hash_equals(). -->
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brand">Correo electrónico</label>
                            <input type="email" name="email" class="form-control border-c2" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-brand">Contraseña</label>
                            <input type="password" name="password" class="form-control border-c2" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-nexadopt py-2">Entrar</button>
                        </div>
                        <div class="text-center mt-4">
                            <p class="text-muted small">¿Aún no tienes cuenta? <a href="registro.php" class="text-accent fw-bold text-decoration-none">Regístrate aquí</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>