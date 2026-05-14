<?php
/**
 * Formulario de contacto que almacena los mensajes en la tabla `mensajes_contacto`.
 *
 * Medidas de seguridad implementadas:
 *  - Token CSRF (includes/csrf.php) para proteger el formulario.
 *  - Sentencia preparada PDO con parámetros nombrados para la inserción,
 *    eliminando cualquier riesgo de inyección SQL.
 *  - Validación de formato de email con FILTER_VALIDATE_EMAIL.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/conexion.php';
require_once 'includes/csrf.php';

$mensaje_enviado = false;
$error_mensaje   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validación del token CSRF antes de procesar cualquier campo del formulario.
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $error_mensaje = 'Error de seguridad. Por favor, recarga la página e inténtalo de nuevo.';
    } else {

        $nombre             = trim($_POST['nombre']    ?? '');
        $telefono           = trim($_POST['telefono']  ?? '');
        $email              = trim($_POST['email']     ?? '');
        $asunto             = trim($_POST['asunto']    ?? '');
        $mensaje            = trim($_POST['mensaje']   ?? '');
        $terminos_aceptados = isset($_POST['terminos']);

        if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
            $error_mensaje = 'Por favor, rellena todos los campos obligatorios.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_mensaje = 'El formato del correo electrónico no es válido.';
        } elseif (!$terminos_aceptados) {
            $error_mensaje = 'Debes aceptar la Política de Privacidad para poder enviar el mensaje.';
        } else {
            try {
                // 2. Inserción con sentencia preparada y parámetros nombrados.
                $sql = "INSERT INTO mensajes_contacto (nombre, telefono, email, asunto, mensaje)
                        VALUES (:nombre, :telefono, :email, :asunto, :mensaje)";

                $stmt = $conexion->prepare($sql);
                $stmt->execute([
                    ':nombre'   => $nombre,
                    ':telefono' => $telefono ?: null,
                    ':email'    => $email,
                    ':asunto'   => $asunto,
                    ':mensaje'  => $mensaje,
                ]);

                $mensaje_enviado = true;

            } catch (PDOException $e) {
                error_log('[NexAdopt - Contacto Error] ' . $e->getMessage());
                $error_mensaje = 'Lo sentimos, hubo un error técnico al guardar tu mensaje. Por favor, inténtalo de nuevo.';
            }
        }
    }
}

// Generamos el token CSRF y lo pasamos a la vista.
$csrf_token = generateCsrfToken();

include 'includes/header.php';
?>

<main class="site-main py-5" style="background-color: var(--c1);">
    <div class="container py-4">

        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <span class="badge px-3 py-2 rounded-pill mb-3 fw-bold" style="background-color: var(--c2); color: var(--c4);">
                    <i class="fas fa-envelope me-1"></i> Contáctanos
                </span>
                <h1 class="fw-bold display-5 mb-3" style="color: var(--c4);">Estamos aquí para ayudarte</h1>
                <p class="lead" style="color: #6c868e;">¿Tienes alguna duda sobre el proceso de adopción, quieres colaborar o has encontrado un animal? Escríbenos y te responderemos lo antes posible.</p>
            </div>
        </div>

        <?php if ($mensaje_enviado): ?>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="alert alert-success d-flex align-items-center rounded-3 border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle fs-4 me-3"></i>
                    <div><strong>¡Mensaje enviado con éxito!</strong> Nos pondremos en contacto contigo muy pronto.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($error_mensaje)): ?>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="alert alert-danger d-flex align-items-center rounded-3 border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                    <div><strong>¡Atención!</strong> <?= htmlspecialchars($error_mensaje) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row justify-content-center g-4">

            <div class="col-lg-4">
                <div class="contacto-info-box p-4 rounded-4 shadow-sm h-100 bg-white">
                    <h4 class="fw-bold mb-4 border-bottom pb-2" style="color: var(--c4);">Información de contacto</h4>

                    <div class="d-flex align-items-start mb-4">
                        <div class="contacto-icon rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm">
                            <i class="fas fa-map-marker-alt fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--c4);">Ubicación</h6>
                            <p class="text-muted small mb-0">Plaza Norte 2<br>28108 Alcobendas, Madrid</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="contacto-icon rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm">
                            <i class="fas fa-phone-alt fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--c4);">Teléfono</h6>
                            <p class="text-muted small mb-0">+34 672 123 412<br>L-V de 10:00 a 18:00</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="contacto-icon rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm">
                            <i class="fas fa-envelope fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--c4);">Correo Electrónico</h6>
                            <p class="text-muted small mb-0">info@nexadopt.com<br>adopciones@nexadopt.com</p>
                        </div>
                    </div>

                    <div class="rounded-3 overflow-hidden mt-4 shadow-sm border" style="height: 250px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12128.530653655474!2d-3.6334651030064245!3d40.53866299863481!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422e1cae3d5fcb%3A0xbc70fdebb6d34e6e!2sParque%20Comercial%20R%C3%ADo%20Norte!5e0!3m2!1ses!2ses!4v1712760000000!5m2!1ses!2ses"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 shadow-sm bg-white h-100">
                    <h4 class="fw-bold mb-2" style="color: var(--c4);">Envíanos un mensaje</h4>
                    <p class="text-muted small mb-4">Rellena el siguiente formulario y nuestro equipo lo revisará detalladamente.</p>

                    <form action="contacto.php" method="POST">

                        <!-- Token CSRF: protege el formulario contra ataques Cross-Site Request Forgery -->
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: var(--c4);">Nombre completo</label>
                                <input type="text" name="nombre" class="form-control form-contacto-input" placeholder="Ej: David Sánchez" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: var(--c4);">Teléfono <span class="text-muted fw-normal">(Opcional)</span></label>
                                <input type="tel" name="telefono" class="form-control form-contacto-input" placeholder="Ej: 600 000 000">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: var(--c4);">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control form-contacto-input" placeholder="tu@email.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: var(--c4);">Asunto</label>
                                <select name="asunto" class="form-select form-contacto-input" required>
                                    <option value="" selected disabled>Selecciona el motivo de tu consulta...</option>
                                    <option value="adopcion">Información sobre Adopción</option>
                                    <option value="voluntariado">Quiero ser Voluntario/a</option>
                                    <option value="donacion">Dudas sobre Donaciones</option>
                                    <option value="rescate">Aviso de Animal Abandonado</option>
                                    <option value="otro">Otro motivo</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold" style="color: var(--c4);">Mensaje</label>
                                <textarea name="mensaje" class="form-control form-contacto-input" rows="5" placeholder="Escribe aquí todos los detalles de tu consulta..." required></textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terminos" id="checkTerminos" required>
                                    <label class="form-check-label small text-muted" for="checkTerminos">
                                        He leído y acepto el <a href="pages/aviso-legal.php" target="_blank" class="text-decoration-none fw-bold" style="color: var(--c5);">Aviso Legal</a> y la <a href="pages/privacidad.php" target="_blank" class="text-decoration-none fw-bold" style="color: var(--c5);">Política de Privacidad</a> referentes al tratamiento de mis datos.
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-submit-contacto w-100 fw-bold rounded-pill text-uppercase shadow-sm py-3" style="background-color: var(--c4); color: white;">
                                    <i class="fas fa-paper-plane me-2"></i> Enviar Mensaje
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>