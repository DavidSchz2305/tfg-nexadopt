<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/conexion.php';
include '../../includes/header.php';
?>

<main class="site-main bg-crema">
    <section class="py-5 bg-verde-claro">
        <div class="container py-lg-4">
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                <a href="asociaciones.php" class="btn btn-nexadopt btn-lg px-4">Asociaciones</a>
                <a href="../../adoptar.php" class="btn btn-outline-nexadopt btn-lg px-4">Buscar hogar</a>
                <a href="../donar.php" class="btn btn-outline-nexadopt btn-lg px-4">Donar</a>
            </div>

            <div class="col-lg-8 mx-auto text-center mb-5">
                <h1 class="display-5 fw-bold text-brand mb-3">Unete a nuestra red de asociaciones</h1>
                <p class="lead text-dark mb-0">
                    Si formas parte de una protectora o asociacion animal, en NexAdopt podemos trabajar
                    juntos para dar mas visibilidad a cada mascota y mejorar todo el proceso de adopcion.
                </p>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container collaboration-cards">
            <div class="row g-4 align-items-stretch mb-5">
                <div class="col-lg-7">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="card-body p-4 p-lg-5 d-flex flex-column">
                            <div class="mb-4">
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2 mb-3">Como empezar</span>
                                <h2 class="card-title fw-bold text-dark mb-3">Empieza a colaborar con NexAdopt</h2>
                                <p class="card-text text-muted mb-0">
                                    Nuestro equipo se encarga de todo el proceso tecnico para que podais centrar vuestros recursos
                                    en lo mas importante: el cuidado de los animales.
                                </p>
                            </div>

                            <div class="icon-box rounded-4 shadow-sm p-3 mb-3">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">1</div>
                                    <div>
                                        <h3 class="h6 fw-bold text-dark mb-2">Compartid vuestro catalogo</h3>
                                        <p class="mb-0 text-muted">Facilitadnos la informacion basica de la asociacion y de los animales que buscan hogar.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="icon-box rounded-4 shadow-sm p-3 mb-3">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">2</div>
                                    <div>
                                        <h3 class="h6 fw-bold text-dark mb-2">Nosotros creamos el perfil</h3>
                                        <p class="mb-0 text-muted">Nuestro equipo de administracion sube las fichas y optimiza las fotos para maximizar su alcance.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="icon-box rounded-4 shadow-sm p-3 mb-4">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">3</div>
                                    <div>
                                        <h3 class="h6 fw-bold text-dark mb-2">Recibid adoptantes filtrados</h3>
                                        <p class="mb-0 text-muted">En cuanto un usuario rellena el formulario de NexAdopt, os lo hacemos llegar validado y listo para revisar.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-light border rounded-4 p-3 p-lg-4 mb-4">
                                <p class="small fw-bold text-brand text-uppercase mb-3">Lo que os aporta NexAdopt</p>
                                <div class="d-grid gap-2">
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <span class="text-accent fw-bold">•</span>
                                        <span>Alta guiada por nuestro equipo</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <span class="text-accent fw-bold">•</span>
                                        <span>Publicacion optimizada de fichas</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <span class="text-accent fw-bold">•</span>
                                        <span>Solicitudes mejor filtradas y mas claras</span>
                                    </div>
                                </div>
                            </div>

                            <a href="../../colaborar.php" class="btn btn-donar btn-lg fw-bold mt-auto w-100 py-3">
                                Contacta con nosotros y unete a la red
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="card-body p-4 p-lg-5">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                                <div>
                                    <h2 class="card-title fw-bold text-dark mb-0">Beneficios para asociaciones</h2>
                                </div>
                            </div>

                            <div class="d-grid gap-3">
                                <div class="icon-box rounded-4 shadow-sm p-3">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">1</div>
                                        <p class="mb-0 text-muted">Gestion de visibilidad total: nosotros nos encargamos de publicar y mantener actualizadas las fichas de vuestros animales en la plataforma.</p>
                                    </div>
                                </div>
                                <div class="icon-box rounded-4 shadow-sm p-3">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">2</div>
                                        <p class="mb-0 text-muted">Filtro previo de candidatos: recibid solo solicitudes de personas que realmente cumplen con vuestros requisitos minimos de adopcion.</p>
                                    </div>
                                </div>
                                <div class="icon-box rounded-4 shadow-sm p-3">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">3</div>
                                        <p class="mb-0 text-muted">Reduccion de carga administrativa: olvidaos de gestionar decenas de correos iniciales; os entregamos el formulario listo para la decision final.</p>
                                    </div>
                                </div>
                                <div class="icon-box rounded-4 shadow-sm p-3">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">4</div>
                                        <p class="mb-0 text-muted">Enlace directo y fluido: centralizamos la comunicacion inicial para que vuestro equipo solo tenga que intervenir en el paso definitivo.</p>
                                    </div>
                                </div>
                                <div class="icon-box rounded-4 shadow-sm p-3">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3">5</div>
                                        <p class="mb-0 text-muted">Gestion segura de la informacion: centralizamos la proteccion de datos de los candidatos bajo protocolos seguros para ayudaros a cumplir con la normativa vigente sin gestionar bases de datos externas ni documentos fisicos dispersos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Nuestras asociaciones</h2>
                    <p class="text-muted mb-0">Protectores y entidades que ya forman parte de nuestra red.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-AbrazoAnimal.png" class="w-100 h-100 object-fit-contain" alt="Abrazo Animal">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Abrazo Animal</h3>
                            <p class="card-text text-muted mb-0">
                                Fuerte enfoque en rehabilitacion de conducta y politica de sacrificio cero.
                            </p>
                            <a href="perfil-asociacion-AbrazoAnimal.php" class="btn btn-outline-nexadopt mt-4">Ver perfil</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-Anaa.png" class="w-100 h-100 object-fit-contain" alt="ANAA">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">ANAA</h3>
                            <p class="card-text text-muted mb-0">
                                Rescatan todo tipo de animales y cuentan con una clinica propia de alto nivel.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-ElRefugio.png" class="w-100 h-100 object-fit-contain" alt="El Refugio">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">El Refugio</h3>
                            <p class="card-text text-muted mb-0">
                                Referentes en la lucha legal y judicial contra el maltrato animal y en veterinaria social.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-Spap.png" class="w-100 h-100 object-fit-contain" alt="SPAP">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">SPAP</h3>
                            <p class="card-text text-muted mb-0">
                                Expertos en casos dificiles y en encontrar hogar para animales invisibles o senior.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
