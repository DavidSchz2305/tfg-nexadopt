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
                <h1 class="display-4 fw-bold text-dark mb-3">ANAA</h1>
                <p class="lead text-muted mb-0">
                    Asociación Nacional Amigos de los Animales. Desde 1992 trabajando por el rescate, protección y defensa de los animales abandonados y promoviendo el respeto a la vida.
                </p>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-16x9 bg-white d-flex align-items-center justify-content-center p-4">
                            <img src="../../assets/img/colaborar/Asocia-Anaa.png" alt="ANAA" class="w-100 h-100 object-fit-contain">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-4 h-100">
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                                    <img src="../../assets/img/colaborar/perfiles/Portada-ANAA1.jpg" alt="ANAA rescate" class="w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                                    <img src="../../assets/img/colaborar/perfiles/Portada-ANAA2.png" alt="ANAA adopción" class="w-100 h-100 object-fit-cover">
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
                        <h3 class="h5 fw-bold text-dark mb-2">Rescate y Recuperación</h3>
                        <p class="mb-0 text-muted">Acogemos a cientos de animales cada año en nuestro centro, brindándoles atención veterinaria, cuidados y el cariño necesario para su completa rehabilitación.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">2</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Adopción Responsable</h3>
                        <p class="mb-0 text-muted">Buscamos el hogar ideal para cada animal. Todos se entregan vacunados, desparasitados, esterilizados y con microchip, asegurando su bienestar futuro.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">3</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Sensibilización Social</h3>
                        <p class="mb-0 text-muted">Fomentamos el respeto hacia los animales y la vida en general a través de campañas de concienciación, educación y promoción del voluntariado activo.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">4</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Lucha contra el Maltrato</h3>
                        <p class="mb-0 text-muted">Actuamos firmemente denunciando el maltrato, el abandono y la utilización de animales en actividades o espectáculos que impliquen crueldad.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h4 fw-bold text-dark mb-3">Sobre ANAA</h2>
                            <p class="text-muted mb-3">
                                La Asociación Nacional Amigos de los Animales (ANAA) se fundó en Madrid en 1992 como respuesta al elevado número de animales abandonados y maltratados en nuestro país. Desde nuestro Centro de Adopción, ubicado en Fuente el Saz de Jarama, trabajamos sin descanso para ofrecer una segunda oportunidad a aquellos que más lo necesitan, proporcionándoles refugio, asistencia veterinaria a través de nuestra clínica propia y, finalmente, una familia definitiva.
                            </p>
                            <p class="text-muted mb-0">
                                Nuestra labor no se limita a la atención a corto plazo. Consideramos fundamental intervenir en la raíz del problema, por lo que a medio y largo plazo desarrollamos una intensa labor de educación ciudadana. A través de nuestras redes, programas de voluntariado y campañas sociales, buscamos instaurar un modelo de convivencia donde la tenencia responsable y el respeto a todas las formas de vida sean los pilares de la sociedad.
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
                            <img src="../../assets/img/colaborar/Asocia-Anaa.png" class="w-100 h-100 object-fit-contain" alt="Perros en adopción">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Perros en adopción</h3>
                            <p class="card-text text-muted mb-0">Cientos de perros, desde cachorros hasta seniors, esperan en nuestro centro la oportunidad de ser parte de tu familia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Gatos rescatados">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Gatos rescatados</h3>
                            <p class="card-text text-muted mb-0">Felinos de todas las edades que han sido cuidados y testados, listos para llenar tu hogar de ronroneos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-Anaa.png" class="w-100 h-100 object-fit-contain" alt="Casos invisibles">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Casos invisibles</h3>
                            <p class="card-text text-muted mb-0">Animales que, por su edad o timidez, llevan más tiempo esperando pero tienen muchísimo amor que dar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Otros animales">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Otros animales</h3>
                            <p class="card-text text-muted mb-0">No solo perros y gatos; a veces otros pequeños compañeros también buscan un refugio seguro a través de ANAA.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>