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
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-16x9 bg-white d-flex align-items-center justify-content-center p-4">
                            <img src="../../assets/img/colaborar/Asocia-AbrazoAnimal.png" alt="Abrazo Animal" class="w-100 h-100 object-fit-contain">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-4 h-100">
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                            <img src="../../assets/img/colaborar/perfiles/Portada-AbrazoAnimal1.jpg" alt="Abrazo Animal" class="w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                            <img src="../../assets/img/colaborar/perfiles/Portada-AbrazoAnimal2.jpg" alt="Abrazo Animal" class="w-100 h-100 object-fit-cover">
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
            <div class="col-lg-10 mx-auto text-center mb-5">
                <h1 class="display-5 fw-bold text-dark mb-3">Abrazo Animal</h1>
                <p class="lead text-muted mb-0">
                    Liderando el cambio hacia un modelo de bienestar animal basado en la etología, la transparencia y el compromiso ético de Sacrificio Cero.
                </p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3 mb-3">1</div>
                        <h3 class="h6 fw-bold text-dark mb-2">Rehabilitación Etológica</h3>
                        <p class="mb-0 text-muted">Especialistas en la recuperación de animales con traumas o problemas de conducta, trabajando su equilibrio emocional antes de la adopción.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3 mb-3">2</div>
                        <h3 class="h6 fw-bold text-dark mb-2">Protocolo Sacrificio Cero</h3>
                        <p class="mb-0 text-muted">Compromiso absoluto con la vida. Ningún animal es sacrificado por falta de espacio o tiempo de estancia en el centro.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3 mb-3">3</div>
                        <h3 class="h6 fw-bold text-dark mb-2">Adopción Match-Making</h3>
                        <p class="mb-0 text-muted">Proceso de selección riguroso para asegurar que el estilo de vida de la familia y las necesidades del animal sean 100% compatibles.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="icon-circle rounded-circle d-inline-flex align-items-center justify-content-center fw-bold p-3 mb-3">4</div>
                        <h3 class="h6 fw-bold text-dark mb-2">Educación Ciudadana</h3>
                        <p class="mb-0 text-muted">Programas activos de concienciación en centros escolares y talleres de formación para propietarios y voluntarios.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h4 fw-bold text-dark mb-3">Sobre Abrazo Animal</h2>
                            <p class="text-muted mb-3">
                                Abrazo Animal gestiona el Centro de Protección Animal de Las Rozas bajo un modelo de excelencia. 
                                Su labor va más allá del refugio: cuentan con un equipo multidisciplinar que incluye veterinarios y educadores caninos orientados a la rehabilitación emocional.
                            </p>
                            <p class="text-muted mb-0">
                                Se distinguen por su transparencia administrativa y por ser un referente en la Comunidad de Madrid 
                                en la gestión de colonias felinas (Método CER) y en la creación de programas de voluntariado activo que integran a la comunidad local en el cuidado diario de los animales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-2">Animales que buscan hogar</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-AbrazoAnimal.png" class="w-100 h-100 object-fit-contain" alt="Rehabilitacion conductual">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Rehabilitacion conductual</h3>
                            <p class="card-text text-muted mb-0">Apoyo a animales con miedos, traumas o necesidades especiales.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Adopciones responsables">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Adopciones responsables</h3>
                            <p class="card-text text-muted mb-0">Procesos cuidados para encontrar familias compatibles con cada animal.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-AbrazoAnimal.png" class="w-100 h-100 object-fit-contain" alt="Seguimiento y asesoramiento">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Seguimiento y asesoramiento</h3>
                            <p class="card-text text-muted mb-0">Acompanamiento durante la adaptacion para fortalecer el vinculo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Concienciacion social">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Concienciacion social</h3>
                            <p class="card-text text-muted mb-0">Difusion de valores de respeto, bienestar y convivencia responsable.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
