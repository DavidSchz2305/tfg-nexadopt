<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/conexion.php';
include '../includes/header.php';
?>

<main class="site-main py-5" style="background-color: var(--c1);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <h1 class="fw-bold mb-4" style="color: var(--c4);">Política de Cookies</h1>
                    <p class="text-muted mb-5">Transparencia sobre el almacenamiento de datos en tu navegador.</p>

                    <div class="legal-content" style="color: #4a5568; line-height: 1.8;">
                        <h4 class="fw-bold mt-4" style="color: var(--c4);">1. Definición y Función de las Cookies</h4>
                        <p>Una cookie es un fichero que se descarga en su ordenador, tablet o dispositivo móvil al acceder a determinadas páginas web. Las cookies permiten a una página web, entre otras cosas, almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo y, dependiendo de la información que contengan, pueden utilizarse para reconocer al usuario autenticado.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">2. Tipología de Cookies utilizadas en NexAdopt</h4>
                        <p>Este portal web ha sido desarrollado priorizando la privacidad del usuario, por lo que <strong>no utilizamos cookies de rastreo, publicitarias ni de terceros (third-party cookies)</strong> sin tu consentimiento expreso.</p>
                        <p>Actualmente, el sitio web utiliza exclusivamente <strong>Cookies Técnicas (Estrictamente Necesarias)</strong>. Estas cookies son aquellas que permiten al usuario la navegación a través de la plataforma y la utilización de los servicios seguros.</p>
                        
                        <div class="table-responsive mt-3 mb-4">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre de la Cookie</th>
                                        <th>Tipo / Proveedor</th>
                                        <th>Finalidad y Descripción</th>
                                        <th>Duración</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>PHPSESSID</code></td>
                                        <td>Técnica / NexAdopt</td>
                                        <td>Cookie nativa de PHP. Es indispensable para gestionar la sesión del usuario. Permite que el sistema reconozca tu cuenta, mantenga tu sesión activa y te dé acceso a paneles restringidos (ej. Mi Perfil, Panel Admin).</td>
                                        <td>Fin de la sesión</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">3. Consentimiento y Legitimación</h4>
                        <p>Conforme al artículo 22.2 de la LSSI, las cookies técnicas o estrictamente necesarias para la prestación de un servicio expresamente solicitado por el usuario (como el inicio de sesión) están <strong>exentas de la obligación de obtener consentimiento</strong>. Al registrarte y acceder a tu cuenta, aceptas el uso imperativo de la cookie <code>PHPSESSID</code>.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">4. Gestión y Eliminación de Cookies</h4>
                        <p>Usted puede permitir, bloquear o eliminar las cookies instaladas en su equipo mediante la configuración de las opciones del navegador instalado en su ordenador:</p>
                        <ul>
                            <li><strong>Google Chrome:</strong> Configuración > Privacidad y seguridad > Cookies y otros datos de sitios.</li>
                            <li><strong>Mozilla Firefox:</strong> Opciones > Privacidad & Seguridad > Cookies y datos del sitio.</li>
                            <li><strong>Safari:</strong> Preferencias > Privacidad > Bloquear todas las cookies.</li>
                        </ul>
                        <p><em>Advertencia:</em> Si bloquea el uso de la cookie de sesión de PHP, las funciones de inicio de sesión, registro de adopciones y gestión administrativa quedarán completamente deshabilitadas por motivos de seguridad informática.</p>
                    </div>

                    <div class="text-center mt-5">
                        <a href="../index.php" class="btn fw-bold text-white rounded-pill px-5 shadow-sm" style="background-color: var(--c4);">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>