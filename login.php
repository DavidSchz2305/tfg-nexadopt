<?php
/**
 * Sistema de autenticación de usuarios.
 * He implementado una consulta preparada para buscar al usuario por email,
 * y uso password_verify() para comparar de forma segura el hash almacenado en BD.
 */

session_start();
require_once 'config/conexion.php';

// Si el usuario ya tiene una sesión activa, lo redirigimos directamente al inicio.
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recogemos y saneamos los datos del formulario.
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Por favor, rellena todos los campos.';
    } else {
        try {
            // Buscamos al usuario por su email usando una sentencia preparada.
            // El parámetro :email nunca se interpola directamente en la consulta SQL.
            $sql  = "SELECT id_usuario, nombre, password, id_rol FROM Usuarios WHERE email = :email LIMIT 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch();

            if ($usuario) {
                // password_verify() compara la contraseña enviada con el hash bcrypt almacenado.
                // Esta función es resistente a ataques de timing, a diferencia de una comparación directa.
                if (password_verify($password, $usuario['password'])) {
                    // Regeneramos el ID de sesión tras el login para prevenir ataques de Session Fixation.
                    session_regenerate_id(true);

                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombre']     = $usuario['nombre'];
                    $_SESSION['rol']        = $usuario['id_rol'];

                    header('Location: index.php');
                    exit();
                } else {
                    $error = 'Contraseña incorrecta.';
                }
            } else {
                $error = 'El correo no está registrado.';
            }

        } catch (PDOException $e) {
            error_log('[NexAdopt - Login Error] ' . $e->getMessage());
            $error = 'Ha ocurrido un error técnico. Por favor, inténtalo de nuevo.';
        }
    }
}

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