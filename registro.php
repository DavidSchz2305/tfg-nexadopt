<?php
// Iniciamos la sesión
session_start();

// Si el usuario ya está logueado (usamos el nombre de la columna: id_usuario), lo mandamos al inicio
if(isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectamos la base de datos
require_once 'config/conexion.php'; 

$mensaje = '';

// Si se ha enviado el formulario...
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos los datos y quitamos espacios en blanco accidentales
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']); 
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);   
    $password = $_POST['password'];
    $password_conf = $_POST['password_conf'];

    // Validaciones básicas (obligamos a rellenar los NOT NULL de la BD)
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
        $mensaje = '<div class="alert alert-danger">Por favor, rellena todos los campos obligatorios.</div>';
    } elseif ($password !== $password_conf) {
        $mensaje = '<div class="alert alert-danger">Las contraseñas no coinciden.</div>';
    } else {
        
        // 1. Comprobar si el email ya existe en tu tabla Usuarios
        $sql_check = "SELECT id_usuario FROM Usuarios WHERE email = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $resultado = $stmt_check->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = '<div class="alert alert-warning">Ese correo ya está registrado. <a href="login.php" class="alert-link">Inicia sesión aquí</a>.</div>';
        } else {
            // 2. Encriptar la contraseña (¡importante por seguridad!)
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // 3. Insertar el nuevo usuario
            // Le pasamos el id_rol = 2 porque es el rol de "Usuario" (el 1 es para Admin, que no se puede registrar desde aquí)
            $sql_insert = "INSERT INTO Usuarios (id_rol, nombre, apellidos, email, password, telefono) VALUES (2, ?, ?, ?, ?, ?)";
            $stmt_insert = $conexion->prepare($sql_insert);
            
            // "sssss" significa que le pasamos 5 variables de tipo String
            $stmt_insert->bind_param("sssss", $nombre, $apellidos, $email, $password_hashed, $telefono);
            
            if ($stmt_insert->execute()) {
                $mensaje = '<div class="alert alert-success">¡Registro completado con éxito! <a href="login.php" class="alert-link">Ya puedes iniciar sesión</a>.</div>';
            } else {
                // Si falla algo en la base de datos, mostramos el error
                $mensaje = '<div class="alert alert-danger">Hubo un error al registrar: ' . $conexion->error . '</div>';
            }
        }
    }
}

// Incluimos el header 
include 'includes/header.php';
?>

<main class="site-main bg-crema py-5 d-flex align-items-center" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6"> <div class="card shadow-lg border-0 rounded-4 card-nexadopt bg-white overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-brand">Crear cuenta</h2>
                            <p class="text-muted">Únete a NexAdopt y da el primer paso para cambiar una vida.</p>
                        </div>

                        <?= $mensaje ?>

                        <form action="registro.php" method="POST">
                            
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
                                <input type="password" class="form-control border-c2 px-3 py-2" id="password" name="password" required placeholder="Crea una contraseña segura">
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