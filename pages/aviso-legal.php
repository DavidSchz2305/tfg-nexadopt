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
                    <h1 class="fw-bold mb-4" style="color: var(--c4);">Aviso Legal y Condiciones de Uso</h1>
                    <p class="text-muted mb-5">Última actualización: Abril 2026</p>

                    <div class="legal-content" style="color: #4a5568; line-height: 1.8;">
                        <h4 class="fw-bold mt-4" style="color: var(--c4);">1. Información General y Datos Identificativos</h4>
                        <p>En cumplimiento con el deber de información dispuesto en la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y el Comercio Electrónico (LSSI-CE), se informa de que el presente sitio web, <strong>www.nexadopt.org</strong> (en adelante, el "Portal"), es titularidad de la <strong>Asociación NexAdopt</strong>, entidad sin ánimo de lucro inscrita en el Registro Nacional de Asociaciones, con NIF G-00000000 y domicilio social en [Dirección Completa de la Protectora], España.</p>
                        <p>Los usuarios pueden comunicarse de forma directa y efectiva con la entidad a través de la dirección de correo electrónico <strong>contacto@nexadopt.org</strong>.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">2. Objeto y Ámbito de Aplicación</h4>
                        <p>El presente Aviso Legal regula el acceso, navegación y uso del Portal por parte de los usuarios. La finalidad principal de NexAdopt es facilitar la difusión, gestión y tramitación de adopciones de animales rescatados, así como la captación de recursos y donaciones para su mantenimiento.</p>
                        <p>El acceso al Portal atribuye la condición de Usuario e implica la aceptación plena y sin reservas de todas las disposiciones incluidas en este Aviso Legal.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">3. Propiedad Intelectual e Industrial</h4>
                        <p>Todos los contenidos del Portal, entendiendo por estos a título meramente enunciativo los textos, fotografías, gráficos, imágenes, iconos, tecnología, software, así como su diseño gráfico y códigos fuente, constituyen una obra cuya propiedad pertenece a NexAdopt o a terceros que han autorizado expresamente su uso, sin que puedan entenderse cedidos al Usuario ninguno de los derechos de explotación sobre los mismos.</p>
                        <p>Queda estrictamente prohibida la reproducción, distribución y comunicación pública, incluida su modalidad de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización expresa de NexAdopt.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">4. Exclusión de Garantías y Responsabilidad</h4>
                        <p>NexAdopt no se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran ocasionar, a título enunciativo: errores u omisiones en los contenidos, falta de disponibilidad del portal o la transmisión de virus o programas maliciosos en los contenidos, a pesar de haber adoptado todas las medidas tecnológicas preventivas necesarias para evitarlo.</p>
                        <p>Toda la información relativa a los animales disponibles para adopción es orientativa. NexAdopt se reserva el derecho de rechazar cualquier solicitud de adopción si el equipo de evaluación determina que el entorno o el perfil del solicitante no es el adecuado para el bienestar del animal.</p>

                        <h4 class="fw-bold mt-4" style="color: var(--c4);">5. Legislación Aplicable y Jurisdicción</h4>
                        <p>La relación entre NexAdopt y el Usuario se regirá por la normativa española vigente. Para la resolución de cualquier controversia que pudiera derivarse del acceso o uso del Portal, ambas partes se someten a los Juzgados y Tribunales de la ciudad correspondiente al domicilio social de la Asociación, renunciando expresamente a cualquier otro fuero que pudiera corresponderles.</p>
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