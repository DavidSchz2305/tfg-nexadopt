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
                <h1 class="display-4 fw-bold text-dark mb-3">El Refugio</h1>
                <p class="lead text-muted mb-0">
                    Organización independiente fundada en 1996, dedicada al rescate de perros y gatos abandonados y a la lucha activa por el "sacrificio cero".
                </p>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-16x9 bg-white d-flex align-items-center justify-content-center p-4">
                            <img src="../../assets/img/colaborar/Asocia-ElRefugio.png" alt="Logo de El Refugio" class="w-100 h-100 object-fit-contain">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-4 h-100">
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                                    <img src="../../assets/img/colaborar/perfiles/Portada-ElRefugio1.jpg" alt="Instalaciones de El Refugio" class="w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-nexadopt border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9 overflow-hidden">
                                    <img src="../../assets/img/colaborar/perfiles/Portada-ElRefugio2.jpg" alt="Animales rescatados en El Refugio" class="w-100 h-100 object-fit-cover">
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
                        <h3 class="h5 fw-bold text-dark mb-2">Rescate y Sacrificio Cero</h3>
                        <p class="mb-0 text-muted">Especializados desde 1996 en la ayuda a perros y gatos maltratados o abandonados, defendiendo inquebrantablemente el "sacrificio cero".</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">2</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Lucha Legal y Social</h3>
                        <p class="mb-0 text-muted">Denunciamos activamente el maltrato y las leyes de sacrificio, presentando iniciativas legislativas para proteger a los animales a nivel autonómico y nacional.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">3</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Independencia Total</h3>
                        <p class="mb-0 text-muted">Somos una organización totalmente independiente que no recibe subvenciones de organismos oficiales, empresas ni partidos políticos.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">4</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Voluntariado y Acción</h3>
                        <p class="mb-0 text-muted">Contamos con programas vitales como las casas de acogida para cachorros y los "Guau Walkers" en nuestro centro de El Espinar.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card card-nexadopt border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h4 fw-bold text-dark mb-3">Sobre El Refugio</h2>
                            <p class="text-muted mb-3">
                                El Refugio es una protectora especializada que, desde 1996, rescata y busca familia a perros y gatos víctimas de abandono y maltrato. Su refugio está situado en El Espinar, en la Sierra de Guadarrama, donde voluntarios y equipo cuidan a los animales. Además, disponen de un Centro Veterinario propio en Madrid capital abierto al público.
                            </p>
                            <p class="text-muted mb-0">
                                Lo que les hace únicos es su absoluta independencia económica, sostenida solo por cuotas de socios y donaciones de simpatizantes. Llevan décadas siendo la voz de los animales en los tribunales y frente a las administraciones, luchando para erradicar el sacrificio legal en centros de recogida y promoviendo el respeto a la vida animal en toda España.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-2">Formas de involucrarse</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-ElRefugio.png" class="w-100 h-100 object-fit-contain" alt="Perros rescatados">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Perros rescatados</h3>
                            <p class="card-text text-muted mb-0">Ayudamos a perros maltratados y abandonados a recuperar la confianza y encontrar una nueva familia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Gatos en adopción">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Gatos en adopción</h3>
                            <p class="card-text text-muted mb-0">Rescatamos gatos de la calle y les brindamos los cuidados necesarios hasta que encuentran su hogar definitivo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/Asocia-ElRefugio.png" class="w-100 h-100 object-fit-contain" alt="Casas de acogida">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Casas de acogida</h3>
                            <p class="card-text text-muted mb-0">Necesitamos familias voluntarias para acoger temporalmente a camadas de cachorros recién nacidos que rescatamos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="ratio ratio-4x3 bg-white d-flex align-items-center justify-content-center p-3">
                            <img src="../../assets/img/colaborar/asociaciones.jpg" class="w-100 h-100 object-fit-cover" alt="Guau Walkers">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h3 class="card-title fw-bold text-dark h5 mb-2">Guau Walkers</h3>
                            <p class="card-text text-muted mb-0">Únete a nuestro equipo en El Espinar para pasear y dar cariño a los animales que esperan ser adoptados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>