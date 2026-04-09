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
                    <h1 class="fw-bold mb-4" style="color: var(--c4);">Política de Privacidad</h1>
                    <p class="text-muted mb-5">De conformidad con el Reglamento (UE) 2016/679 (RGPD) y la Ley Orgánica 3/2018 (LOPDGDD).</p>

                    <div class="legal-content" style="color: #4a5568; line-height: 1.8;">
                        <h4 class="fw-bold mt-4" style="color: var(--c4);">1. Identidad del Responsable del Tratamiento</h4>
                        <p>La Asociación NexAdopt es la entidad responsable del tratamiento de los datos personales recabados a través de este sitio web. Puedes contactar con nuestro Delegado de Protección de Datos enviando un correo electrónico a <strong>privacidad@nexadopt.org</strong>.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">2. Finalidad del Tratamiento de los Datos</h4>
                        <p>En NexAdopt tratamos la información que nos facilitan las personas interesadas con los siguientes fines específicos:</p>
                        <ul>
                            <li><strong>Gestión de Usuarios:</strong> Creación y mantenimiento de las cuentas de perfil en la plataforma para el acceso a servicios personalizados.</li>
                            <li><strong>Trámites de Adopción:</strong> Evaluación de idoneidad, seguimiento de solicitudes (estado: Pendiente, Aprobado, Rechazado) y formalización de contratos de adopción o acogida.</li>
                            <li><strong>Gestión de Donaciones:</strong> Tramitación de colaboraciones económicas y emisión del correspondiente certificado fiscal a efectos de deducciones.</li>
                            <li><strong>Atención de Consultas:</strong> Responder a las peticiones recibidas a través de los formularios de contacto.</li>
                        </ul>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">3. Base Legitimadora del Tratamiento</h4>
                        <p>La base legal para el tratamiento de tus datos es el <strong>consentimiento expreso</strong> del interesado, otorgado mediante la marcación de las casillas de aceptación en los formularios de registro y adopción. Adicionalmente, el tratamiento es necesario para la <strong>ejecución de un contrato preadoptivo</strong> o de donación en el que el interesado es parte.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">4. Plazos de Conservación</h4>
                        <p>Los datos personales proporcionados se conservarán mientras se mantenga la relación vinculante con el Usuario. Una vez finalizada dicha relación (por ejemplo, tras la eliminación del perfil), los datos serán bloqueados y conservados únicamente durante los plazos legalmente establecidos para la atención de posibles responsabilidades nacidas del tratamiento.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">5. Destinatarios y Cesiones a Terceros</h4>
                        <p>NexAdopt garantiza que los datos personales no serán vendidos, alquilados ni cedidos a terceros, salvo obligación legal expresa (por ejemplo, a la Agencia Tributaria para la declaración de donaciones, o al Registro de Identificación de Animales de Compañía para el cambio de titularidad del microchip).</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">6. Ejercicio de Derechos (ARCO+)</h4>
                        <p>Cualquier persona tiene derecho a obtener confirmación sobre si en NexAdopt estamos tratando datos personales que le conciernan. Como titular de los datos, posees los derechos de:</p>
                        <ul>
                            <li><strong>Acceso:</strong> Conocer qué datos tuyos estamos tratando.</li>
                            <li><strong>Rectificación:</strong> Modificar los datos inexactos desde tu propio panel de "Mi Perfil".</li>
                            <li><strong>Supresión ("Derecho al olvido"):</strong> Solicitar la eliminación de tus datos de nuestros servidores.</li>
                            <li><strong>Limitación u Oposición:</strong> Restringir el procesamiento de tus datos bajo ciertas condiciones legales.</li>
                        </ul>
                        <p>Para ejercer estos derechos, deberás enviar una solicitud por escrito a privacidad@nexadopt.org aportando una copia de tu DNI o documento equivalente.</p>
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