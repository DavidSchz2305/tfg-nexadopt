<?php
/**
 * Página corporativa con tres secciones: misión, FAQ e Historias de Adopción.
 * La única interacción con la BD es la carga de las historias de éxito,
 * que he envuelto en un try-catch para que un fallo en esa consulta no
 * rompa el resto de la página.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/conexion.php';
include 'includes/header.php';

// Cargamos las historias de éxito ordenadas por fecha, las más recientes primero.
$historias = [];
try {
    $stmt_historias = $conexion->query(
        "SELECT titulo, testimonio, foto_final_url, fecha_publicacion 
         FROM historias_exito 
         ORDER BY fecha_publicacion DESC"
    );
    $historias = $stmt_historias->fetchAll();
} catch (PDOException $e) {
    error_log('[NexAdopt - Nosotros/Historias Error] ' . $e->getMessage());
    // Si falla la consulta, simplemente mostramos la sección vacía sin interrumpir la página.
}
?>

<main class="site-main py-5" style="background-color: var(--c1);">
    <div class="container py-4">
        
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h1 class="fw-bold display-5 mb-3" style="color: var(--c4);">Sobre nosotros</h1>
                <hr class="mx-auto opacity-100" style="width: 60px; border-top: 3px solid var(--c5);">
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 d-flex justify-content-center flex-wrap gap-3">
                <button id="btn-porque"   class="btn btn-tab-nosotros active" onclick="mostrarSeccion('porque', this)">Por qué NexAdopt</button>
                <button id="btn-faq"      class="btn btn-tab-nosotros"        onclick="mostrarSeccion('faq', this)">Preguntas frecuentes</button>
                <button id="btn-historias" class="btn btn-tab-nosotros"       onclick="mostrarSeccion('historias', this)">Historias</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5 min-vh-50">

                    <!-- SECCIÓN: Por qué NexAdopt -->
                    <div id="seccion-porque" class="seccion-tab text-center text-md-start" style="display: block;">
                        <h2 class="fw-bold mb-3" style="color: var(--c4);">Por qué elegir NexAdopt</h2>
                        <h6 class="fw-bold mb-4 text-uppercase tracking-wide" style="color: var(--c5);">Nuestra misión</h6>
                        
                        <p class="lead mb-5" style="color: #6c868e; line-height: 1.8;">
                            En NexAdopt trabajamos incansablemente para conectar a animales rescatados con familias dispuestas a darles una segunda oportunidad. Nuestro objetivo es erradicar el abandono mediante procesos transparentes, seguros y llenos de empatía, asegurando el bienestar animal por encima de todo.
                        </p>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="p-4 rounded-4 shadow-sm h-100 feature-box-pro" style="background-color: #ffffff; border-left: 5px solid var(--c4);">
                                    <h5 class="fw-bold mb-2" style="color: var(--c4);">Proceso seguro y verificado</h5>
                                    <p class="mb-0" style="color: #6c868e;">Evaluamos a las familias y a los animales para asegurar una compatibilidad perfecta y duradera.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 rounded-4 shadow-sm h-100 feature-box-pro" style="background-color: #ffffff; border-left: 5px solid var(--c5);">
                                    <h5 class="fw-bold mb-2" style="color: var(--c4);">Salud garantizada</h5>
                                    <p class="mb-0" style="color: #6c868e;">Todos los animales se entregan vacunados, desparasitados, con microchip y revisión veterinaria completa.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 rounded-4 shadow-sm h-100 feature-box-pro" style="background-color: #ffffff; border-left: 5px solid var(--c5);">
                                    <h5 class="fw-bold mb-2" style="color: var(--c4);">Seguimiento continuo</h5>
                                    <p class="mb-0" style="color: #6c868e;">No te dejamos solo. Ofrecemos apoyo y asesoramiento durante los primeros meses de adaptación tras la adopción.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 rounded-4 shadow-sm h-100 feature-box-pro" style="background-color: #ffffff; border-left: 5px solid var(--c4);">
                                    <h5 class="fw-bold mb-2" style="color: var(--c4);">Red de protectoras</h5>
                                    <p class="mb-0" style="color: #6c868e;">Colaboramos con múltiples refugios de la zona para dar visibilidad conjunta a los animales que más lo necesitan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center mt-5 pt-4 border-top" style="border-color: var(--c2) !important;">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <h2 class="fw-bold display-5 mb-1" style="color: var(--c4);">500+</h2>
                                <p class="fw-bold text-uppercase small mb-0" style="color: #6c868e;">Mascotas rescatadas</p>
                            </div>
                            <div class="col-md-4 mb-4 mb-md-0">
                                <h2 class="fw-bold display-5 mb-1" style="color: var(--c4);">50+</h2>
                                <p class="fw-bold text-uppercase small mb-0" style="color: #6c868e;">Protectoras asociadas</p>
                            </div>
                            <div class="col-md-4">
                                <h2 class="fw-bold display-5 mb-1" style="color: var(--c5);">98%</h2>
                                <p class="fw-bold text-uppercase small mb-0" style="color: #6c868e;">Familias felices</p>
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN: FAQ con Acordeón Bootstrap -->
                    <div id="seccion-faq" class="seccion-tab" style="display: none;">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-3" style="color: var(--c4);">Preguntas Frecuentes</h2>
                            <p class="lead" style="color: #6c868e;">Resolvemos las dudas más comunes sobre nuestro proceso.</p>
                        </div>
                        
                        <div class="accordion custom-accordion" id="accordionFAQ">
                            <?php
                            $faqs = [
                                ["¿Cuál es el proceso de adopción?",                        "El proceso consiste en rellenar un formulario inicial, realizar una entrevista personal con nuestros voluntarios, conocer a la mascota y, finalmente, firmar el contrato de adopción."],
                                ["¿Hay algún costo al adoptar?",                            "Sí, la adopción tiene un donativo asociado que cubre parcialmente los gastos veterinarios previos (vacunas, microchip, desparasitación y esterilización)."],
                                ["¿Qué documentación necesito para adoptar?",               "Necesitarás presentar tu DNI o NIE en vigor, un comprobante de domicilio (recibo o contrato de alquiler) y firmar el contrato legal de adopción."],
                                ["¿Puedo adoptar si vivo de alquiler?",                     "Sí, siempre y cuando presentes una autorización por escrito de tu casero o el contrato de alquiler especifique que se permiten mascotas en la vivienda."],
                                ["¿Se entregan los animales esterilizados?",                "Sí, todos los animales adultos se entregan esterilizados. En el caso de cachorros, se firma un compromiso de esterilización obligatoria al alcanzar la edad adecuada."],
                                ["¿Qué pasa si la adopción no funciona?",                   "Si surge algún problema de adaptación insalvable, el animal SIEMPRE debe regresar a NexAdopt. Queda terminantemente prohibido cederlo a terceros o llevarlo a otro refugio."],
                                ["¿Puedo adoptar si ya tengo otras mascotas?",              "¡Claro! De hecho, en la entrevista te pediremos información sobre tus mascotas actuales para asegurar que el animal que vas a adoptar es compatible con ellos."],
                                ["¿Puedo adoptar si vivo fuera de la Comunidad de Madrid?", "Actualmente priorizamos adopciones en la Comunidad de Madrid para poder realizar los seguimientos pertinentes, pero evaluamos casos excepcionales de provincias limítrofes."],
                                ["¿Los animales tienen chip y vacunas al día?",             "Absolutamente. Ningún animal abandona nuestras instalaciones sin su cartilla veterinaria al día, microchip a nombre del adoptante y desparasitación interna y externa."],
                                ["¿Hacéis seguimiento tras la adopción?",                   "Sí. Realizamos seguimientos periódicos (por teléfono, fotos o visitas presenciales) durante los primeros meses para asegurarnos de que la adaptación está siendo positiva."],
                            ];

                            foreach ($faqs as $index => $faq): ?>
                            <div class="accordion-item faq-item border-0 mb-3 rounded-4 shadow-sm">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold p-4 rounded-4" style="color: var(--c4);" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $index ?>">
                                        <?= htmlspecialchars($faq[0]) ?>
                                    </button>
                                </h2>
                                <div id="faq<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body p-4 pt-0 lh-lg" style="color: #6c868e;">
                                        <?= htmlspecialchars($faq[1]) ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- SECCIÓN: Historias de éxito cargadas desde la BD -->
                    <div id="seccion-historias" class="seccion-tab" style="display: none;">
                        <div class="text-center mb-5 position-relative">
                            <h2 class="fw-bold mb-3" style="color: var(--c4);">Historias con final feliz</h2>
                            <p class="lead" style="color: #6c868e;">Conoce a algunos de nuestros peludos que ya disfrutan de una segunda oportunidad.</p>
                        </div>
                        
                        <div class="row g-4">
                            <?php if (!empty($historias)): ?>
                                <?php foreach ($historias as $historia):
                                    $foto = !empty($historia['foto_final_url'])
                                        ? $historia['foto_final_url']
                                        : 'assets/img/default-mascota.jpg';
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden historia-pro-card">
                                        <div class="historia-img-wrapper">
                                            <img src="<?= htmlspecialchars($foto) ?>" 
                                                 class="card-img-top" alt="Historia de adopción"
                                                 onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=600&auto=format&fit=crop'">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <span class="badge bg-light rounded-pill mb-3 align-self-start fw-bold" style="color: var(--c5);">
                                                <i class="fas fa-star me-1" style="color: #ffc107;"></i> Final Feliz
                                            </span>
                                            <h5 class="fw-bold mb-1" style="color: var(--c4);"><?= htmlspecialchars($historia['titulo']) ?></h5>
                                            <p class="card-text small flex-grow-1 mt-2" style="color: #6c868e; font-style: italic;">
                                                "<?= htmlspecialchars($historia['testimonio']) ?>"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center py-5">
                                    <i class="fas fa-book-open fs-1 mb-3" style="color: var(--c2);"></i>
                                    <h5 class="fw-bold" style="color: var(--c4);">Aún no hay historias publicadas</h5>
                                    <p style="color: #6c868e;">¡Muy pronto compartiremos los finales felices de nuestros peludos!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function mostrarSeccion(idSeccion, elementoBoton) {
        document.querySelectorAll('.seccion-tab').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.btn-tab-nosotros').forEach(b => b.classList.remove('active'));
        document.getElementById('seccion-' + idSeccion).style.display = 'block';
        elementoBoton.classList.add('active');
    }
</script>

<?php include 'includes/footer.php'; ?>