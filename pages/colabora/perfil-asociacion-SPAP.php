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
            
            <div class="col-lg-10 mx-auto text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">S.P.A.P. Madrid</h1>
                <p class="lead text-muted mb-0">
                    Pioneros en la defensa y protección animal en España desde 1929, gestionando el Albergue San Francisco de Asís bajo el firme compromiso del Sacrificio Cero.
                </p>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-16x9 bg-white d-flex align-items-center justify-content-center p-4">
                            <img src="../../assets/img/colaborar/Asocia-Spap.jpg" alt="Logo SPAP Madrid" class="w-100 h-100 object-fit-contain">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-4 h-100">
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                                    <img src="../../assets/img/colaborar/perfiles/Portada-Spap1.png" alt="Instalaciones SPAP" class="w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                                    <img src="../../assets/img/colaborar/perfiles/Portada-Spap2.png" alt="Animales rescatados SPAP" class="w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="asociaciones.php" class="btn btn-outline-nexadopt rounded-pill px-4">Volver a asociaciones</a>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">1</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Historia y Experiencia</h3>
                        <p class="mb-0 text-muted">Con casi un siglo de trayectoria, fundada en 1929, somos una de las organizaciones de protección animal y ambiental más antiguas de España.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">2</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Albergue Propio</h3>
                        <p class="mb-0 text-muted">Gestionamos el Albergue San Francisco de Asís, rescatando, rehabilitando y alojando a cientos de animales hasta encontrarles una familia.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">3</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Clínica Solidaria</h3>
                        <p class="mb-0 text-muted">Contamos con nuestra propia clínica veterinaria en Madrid para atender a nuestros rescatados y ofrecer servicios accesibles a nuestros socios.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">4</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Defensa Activa</h3>
                        <p class="mb-0 text-muted">Luchamos sin descanso por los derechos de los animales, impulsando cambios legales y realizando campañas contra el maltrato y el abandono.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h4 fw-bold text-dark mb-3">Sobre SPAP Madrid</h2>
                            <p class="text-muted mb-3">
                                La Sociedad Protectora de Animales y Plantas de Madrid (SPAP) es una entidad histórica declarada de Utilidad Pública. Lleva desde 1929 siendo un pilar fundamental en el rescate y cuidado de animales abandonados en la Comunidad de Madrid. Su labor principal se desarrolla en el Albergue San Francisco de Asís, un refugio seguro donde impera estrictamente la política de sacrificio cero.
                            </p>
                            <p class="text-muted mb-0">
                                Además de su innegable labor de rescate diario, la SPAP destaca por su fuerte activismo frente a injusticias como la experimentación animal, la tauromaquia y el abandono. Su equipo de profesionales veterinarios y su inmensa red de voluntarios trabajan los 365 días del año para curar las heridas físicas y emocionales de los animales, dándoles el calor y el respeto que merecen hasta su adopción definitiva.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-2">Formas de colaborar</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-Spap.jpg" class="w-100 h-100 object-fit-contain" alt="Adopción en el Albergue">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Adopción en el Albergue</h3>
                            <p class="card-text text-muted mb-0">Perros y gatos de todos los tamaños y edades te esperan en nuestro Albergue San Francisco de Asís.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Apadrinamiento">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Apadrinamiento</h3>
                            <p class="card-text text-muted mb-0">Si no puedes adoptar, apadrinar a uno de nuestros residentes ayuda a cubrir sus gastos de manutención y veterinarios.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-Spap.jpg" class="w-100 h-100 object-fit-contain" alt="Clínica Veterinaria">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Clínica Veterinaria</h3>
                            <p class="card-text text-muted mb-0">Utilizando los servicios de nuestra clínica apoyas directamente la financiación y el cuidado de los animales del refugio.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Voluntariado Activo">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Voluntariado Activo</h3>
                            <p class="card-text text-muted mb-0">Tu tiempo es su mayor alegría. Necesitamos manos para pasear, socializar y cuidar a los animales.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>