<?php
include 'includes/header.php';
?>

<main class="site-main bg-crema">
    <section class="hero-section py-5 bg-verde-claro">
        <div class="container py-lg-5">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-brand mb-4">Colabora con nosotros</h1>
                <p class="lead text-dark" style="max-width: 700px; margin: 0 auto; line-height: 1.75;">
                    En NexAdopt creemos que cada gesto cuenta. Ya sea protegiendo animales, dándoles un hogar temporal o contribuyendo económicamente, tu ayuda transforma vidas felinas y caninas.
                </p>
            </div>
        </div>
    </section>

    <section class="collaboration-cards py-5 bg-crema">
        <div class="container">
            <div class="row g-4 d-flex align-items-stretch">
                
                <div class="col-lg-4">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="assets/img/colaborar/asociaciones.jpg" class="card-img-top" alt="Asociaciones colaboradoras" style="height: 280px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3">
                                <span class="badge rounded-pill text-white px-3 py-2" style="background-color: #58808d; font-size: 0.9rem;">
                                    1. Asociaciones
                                </span>
                            </div>
                            
                            <h3 class="card-title fw-bold text-dark h4 mb-3">
                                Nuestras protectoras aliadas
                            </h3>
                            
                            <p class="card-text text-muted mb-4" style="font-size: 0.95rem;">
                                ¿Eres una asociación o protectora? Únete a nuestra red de colaboradores. Con nuestra plataforma podrás gestionar tus animales, dar seguimiento a las adopciones y ampliar tu alcance. ¡Juntos rescatamos más vidas!
                            </p>

                            <ul class="list-unstyled small text-muted mb-4">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill me-2" style="color: #58808d;"></i>Gestión completa de animales
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill me-2" style="color: #58808d;"></i>Seguimiento de adopciones
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill me-2" style="color: #58808d;"></i>Alcance a nivel nacional
                                </li>
                            </ul>

                            <a href="pages/colabora/asociaciones.php" class="btn btn-lg mt-auto w-100 rounded-3 text-white" style="background-color: #58808d; font-weight: 500;">
                                Regístrate como asociación
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="assets/img/colaborar/acogida.jpg" class="card-img-top" alt="Acogida de animales" style="height: 280px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3">
                                <span class="badge bg-warning rounded-pill text-dark px-3 py-2" style="font-size: 0.9rem;">
                                    2. Acogida
                                </span>
                            </div>

                            <h3 class="card-title fw-bold text-dark h4 mb-3">
                                Acoge un animal
                            </h3>
                            
                            <p class="card-text text-muted mb-4" style="font-size: 0.95rem;">
                                ¿Tienes espacio en casa y amor para compartir? Acoge un animal de manera temporal mientras encuentra su familia definitiva. No requiere compromiso permanente, solo cuidados básicos y mucho cariño.
                            </p>

                            <div class="p-3 bg-light border-start border-4 border-warning rounded mb-4" style="font-size: 0.9rem;">
                                <strong class="d-block mb-2 text-dark">Beneficios:</strong>
                                <ul class="list-unstyled text-muted mb-0">
                                    <li class="mb-1"><i class="bi bi-check2 me-1 text-warning"></i>Nosotros cubrimos gastos veterinarios</li>
                                    <li class="mb-1"><i class="bi bi-check2 me-1 text-warning"></i>Apoyo y asesoramiento continuo</li>
                                    <li><i class="bi bi-check2 me-1 text-warning"></i>Experiencia enriquecedora</li>
                                </ul>
                            </div>

                            <a href="#" class="btn btn-warning btn-lg mt-auto w-100 rounded-3 text-dark" style="font-weight: 500;">
                                Dar hogar temporal
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card collaboration-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="assets/img/colaborar/aporta.jpg" class="card-img-top" alt="Donaciones" style="height: 280px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3">
                                <span class="badge bg-dark rounded-pill text-white px-3 py-2" style="font-size: 0.9rem;">
                                    3. Donaciones
                                </span>
                            </div>

                            <h3 class="card-title fw-bold text-dark h4 mb-3">
                                Aporta tu grano de arena
                            </h3>
                            
                            <p class="card-text text-muted mb-4" style="font-size: 0.95rem;">
                                Tu aportación económica nos permite seguir rescatando, alimentando y curando a animales en peligro. Cada euro cuenta y es destinado directamente al bienestar de nuestros protegidos.
                            </p>

                            <div class="p-3 bg-light border-start border-4 border-dark rounded mb-4" style="font-size: 0.9rem;">
                                <strong class="d-block mb-2 text-dark">¿A dónde va tu donativo?</strong>
                                <ul class="text-muted mb-0 ps-3">
                                    <li class="mb-1">Alimentación y agua potable</li>
                                    <li class="mb-1">Cuidados veterinarios</li>
                                    <li>Acondicionamiento de refugios</li>
                                </ul>
                            </div>

                            <a href="donar.php" class="btn btn-dark btn-lg mt-auto w-100 rounded-3" style="font-weight: 500;">
                                Hacer transferencia
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php
include 'includes/footer.php';
?>