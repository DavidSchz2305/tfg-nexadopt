<?php
// Primero incluimos el header 
include 'includes/header.php';
?>

<main class="site-main bg-crema"> 

    <section class="hero-section py-5 bg-verde-claro"> 
        <div class="container py-lg-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="assets/img/inicio/Perros-familia-feliz.jpg" class="d-block mx-lg-auto img-fluid rounded-4 shadow-lg" alt="Perros y gatos felices esperando adopción">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold lh-1 mb-3 text-brand">Dale un giro a tu vida: adopta a un amigo</h1>
                    <p class="lead mb-4" style="color: #4a5d63;">En NexAdopt somos el puente hacia tu nueva familia. Conectamos corazones, facilitando que animales rescatados encuentren un hogar lleno de amor. Únete a nosotros en un proceso de adopción seguro, transparente y lleno de esperanza.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="adoptar.php" class="btn btn-nexadopt btn-lg px-4 me-md-2">Ver mascotas disponibles</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="icon-features-section py-5 bg-crema">
        <div class="container text-center py-4">
            <div class="row row-cols-1 row-cols-md-5 g-4 justify-content-center">
                
                <div class="col">
                    <div class="icon-box text-center p-4 py-5 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle d-inline-flex align-items-center justify-content-center mb-4 rounded-circle" style="width: 80px; height: 80px;">
                            <img src="assets/icons/ICON-Refugio.png" alt="Icono Refugio" style="width: 42px; height: 42px; object-fit: contain;">
                        </div>
                        <h5 class="fw-semibold text-brand mb-2">Red de refugios</h5>
                        <p class="small mb-0" style="color: #6a828a;">Colaboramos con centros de rescate</p>
                    </div>
                </div>

                <div class="col">
                    <div class="icon-box text-center p-4 py-5 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle d-inline-flex align-items-center justify-content-center mb-4 rounded-circle" style="width: 80px; height: 80px;">
                            <img src="assets/icons/ICON-Cuidados.png" alt="Icono Cuidados" style="width: 42px; height: 42px; object-fit: contain;">
                        </div>
                        <h5 class="fw-semibold text-brand mb-2">Cuidados y salud</h5>
                        <p class="small mb-0" style="color: #6a828a;">Garantizamos el bienestar animal</p>
                    </div>
                </div>

                <div class="col">
                    <div class="icon-box text-center p-4 py-5 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle d-inline-flex align-items-center justify-content-center mb-4 rounded-circle" style="width: 80px; height: 80px;">
                            <img src="assets/icons/ICON-Adopta.png" alt="Icono Proceso de Adopción" style="width: 42px; height: 42px; object-fit: contain;">
                        </div>
                        <h5 class="fw-semibold text-brand mb-2">Proceso de adopción</h5>
                        <p class="small mb-0" style="color: #6a828a;">Transparente y paso a paso</p>
                    </div>
                </div>

                <div class="col">
                    <div class="icon-box text-center p-4 py-5 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle d-inline-flex align-items-center justify-content-center mb-4 rounded-circle" style="width: 80px; height: 80px;">
                            <img src="assets/icons/ICON-Donar.png" alt="Icono Donar" style="width: 42px; height: 42px; object-fit: contain;">
                        </div>
                        <h5 class="fw-semibold text-brand mb-2">Haz tu donativo</h5>
                        <p class="small mb-0" style="color: #6a828a;">Ayúdanos a salvar vidas</p>
                    </div>
                </div>

                <div class="col">
                    <div class="icon-box text-center p-4 py-5 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle d-inline-flex align-items-center justify-content-center mb-4 rounded-circle" style="width: 80px; height: 80px;">
                            <img src="assets/icons/ICON-Acogida.png" alt="Icono Acogida" style="width: 42px; height: 42px; object-fit: contain;">
                        </div>
                        <h5 class="fw-semibold text-brand mb-2">Familia de acogida</h5>
                        <p class="small mb-0" style="color: #6a828a;">Conviértete en familia de acogida</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="about-us-section py-5 text-center" style="background-color: #fff;">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="mb-4">
                            <img src="assets/img/header_footer/logo_transparente.png" alt="NexAdopt Logo" class="img-fluid" style="max-height: 45px; margin-top: 2px;" loading="lazy">
                        <h2 class="display-5 fw-bold text-brand mt-3">¿Quiénes somos?</h2>
                    </div>
                    <p class="lead mb-4 px-lg-5" style="color: #4a5d63;">Somos una plataforma digital innovadora dedicada a transformar el proceso de adopción animal. NexAdopt une el esfuerzo incansable de protectoras y refugios con personas comprometidas, garantizando adopciones responsables, seguras y transparentes para que cada animal reciba el hogar que merece.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="nosotros.php" class="btn btn-outline-nexadopt btn-lg px-4">Conoce nuestra historia</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="video-promo-section py-5 bg-verde-claro">
        <div class="container py-4">
            <h2 class="fw-bold text-center mb-5 text-brand">5 Razones para Adoptar</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg border border-3 border-white">
                        <video controls autoplay muted loop playsinline>
                            <source src="assets/video/video-nextadopt.mp4" type="video/mp4">
                            Tu navegador no soporta la reproducción de vídeos.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tips-section py-5 bg-crema">
        <div class="container py-4">
            <h2 class="fw-bold text-center mb-5 text-brand">Consejos y Recursos</h2>
            <div class="row g-4 align-items-stretch">
                
                <div class="col-lg-4 col-md-12">
                    <div class="card card-nexadopt h-100 shadow-sm rounded-4 overflow-hidden d-flex flex-column">
                        <img src="assets/img/inicio/Entrenamiento-perros.jpg" class="card-img-top" alt="Entrenamiento" style="height: 300px; object-fit: cover;" loading="lazy">
                        <div class="card-body text-center d-flex flex-column justify-content-center p-4 flex-grow-1">
                            <h5 class="card-title fw-bold text-brand">Guía de apoyo integral para el comportamiento y adiestramiento en casa</h5>
                            <div class="mt-4">
                                <a href="consejos.php" class="btn btn-nexadopt">Ver todos los consejos</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column h-100 gap-3">
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-4"><img src="assets/img/consejos/Perro-reactivo.jpg" class="img-fluid rounded-3" alt="Perro reactivo" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-8"><div class="card-body py-1 px-3"><p class="card-text fw-semibold text-brand mb-0">Identifica las señales de reactividad en tu perro</p></div></div>
                            </div>
                        </div>
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-4"><img src="assets/img/consejos/Entrenamiento-cachorros.jpg" class="img-fluid rounded-3" alt="Entrenamiento cachorros" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-8"><div class="card-body py-1 px-3"><p class="card-text fw-semibold text-brand mb-0">Guía básica de adiestramiento para cachorros</p></div></div>
                            </div>
                        </div>
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-4"><img src="assets/img/consejos/Como-entrenar-perro.jpg" class="img-fluid rounded-3" alt="Entrenar perro" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-8"><div class="card-body py-1 px-3"><p class="card-text fw-semibold text-brand mb-0">Consejos clave para educar a tu perro en positivo</p></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column h-100 gap-3">
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-4"><img src="assets/img/consejos/Perro-ladre.jpg" class="img-fluid rounded-3" alt="Perro ladrando" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-8"><div class="card-body py-1 px-3"><p class="card-text fw-semibold text-brand mb-0">Técnicas eficaces para gestionar los ladridos</p></div></div>
                            </div>
                        </div>
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-4"><img src="assets/img/consejos/Evitar_perro-muerda.jpg" class="img-fluid rounded-3" alt="Perro mordiendo" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-8"><div class="card-body py-1 px-3"><p class="card-text fw-semibold text-brand mb-0">Cómo prevenir y corregir mordidas indeseadas</p></div></div>
                            </div>
                        </div>
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-4"><img src="assets/img/consejos/Presentar-nuevo-perro.jpg" class="img-fluid rounded-3" alt="Presentar perros" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-8"><div class="card-body py-1 px-3"><p class="card-text fw-semibold text-brand mb-0">Pasos para presentar a tu nuevo perro a la familia</p></div></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="updates-section py-5 bg-verde-claro">
        <div class="container py-4">
            <h2 class="fw-bold text-center mb-5 text-brand">Historias con Final Feliz</h2>
            <div class="row g-4 align-items-stretch">
                
                <div class="col-lg-4 col-md-12">
                    <div class="d-flex flex-column h-100 gap-3">
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 bg-white flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-5"><img src="assets/img/historias/Tyson.jpg" class="img-fluid rounded-3" alt="Tyson" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-7"><div class="card-body py-1 px-3"><p class="card-text fw-bold text-brand mb-0">Tyson por fin disfruta de la calidez de un hogar.</p></div></div>
                            </div>
                        </div>
                        <div class="card card-nexadopt shadow-sm rounded-3 p-2 bg-white flex-grow-1 d-flex justify-content-center">
                            <div class="row g-0 align-items-center w-100">
                                <div class="col-5"><img src="assets/img/historias/Toby.jpg" class="img-fluid rounded-3" alt="Toby" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy"></div>
                                <div class="col-7"><div class="card-body py-1 px-3"><p class="card-text fw-bold text-brand mb-0">La tercera fue la vencida: Toby ya tiene una familia.</p></div></div>
                            </div>
                        </div>
                        <div class="mt-2 text-center text-lg-start">
                            <a href="nosotros.php" class="btn btn-nexadopt px-4 w-100 py-2">Leer más historias</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-nexadopt h-100 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column">
                        <img src="assets/img/historias/Lia.jpg" class="card-img-top" alt="Lia" style="height: 280px; object-fit: cover; object-position: center;" loading="lazy">
                        <div class="card-body d-flex flex-column p-4 text-center flex-grow-1">
                            <p class="card-text text-brand fw-medium mb-4">Lia, la perrita que era invisible en el refugio, se ha convertido en la indiscutible reina de su nueva casa.</p>
                            <div class="mt-auto">
                                <a href="nosotros.php" class="btn btn-outline-nexadopt btn-sm px-4">Conoce a Lia</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-nexadopt h-100 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column">
                        <img src="assets/img/historias/Thor.jpg" class="card-img-top" alt="Thor" style="height: 280px; object-fit: cover; object-position: center;" loading="lazy">
                        <div class="card-body d-flex flex-column p-4 text-center flex-grow-1">
                            <p class="card-text text-brand fw-medium mb-4">Tras un largo proceso de recuperación, el valiente Thor ya descansa tranquilo en su propio sofá familiar.</p>
                            <div class="mt-auto">
                                <a href="nosotros.php" class="btn btn-outline-nexadopt btn-sm px-4">Conoce a Thor</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php
// Incluimos el footer 
include 'includes/footer.php';
?>