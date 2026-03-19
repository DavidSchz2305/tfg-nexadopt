<?php
session_start();
require_once 'config/conexion.php';

// Si ya está logueado, lo mandamos al inicio
if(isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id_usuario, nombre, password, id_rol FROM Usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $sql);

    if ($row = mysqli_fetch_assoc($resultado)) {
        // Comprobamos la contraseña encriptada
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['rol'] = $row['id_rol'];

            header("Location: index.php");
            exit();
        } else {
            $error = 'Contraseña incorrecta.';
        }
    } else {
        $error = 'El correo no está registrado.';
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

                    <?php if($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
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