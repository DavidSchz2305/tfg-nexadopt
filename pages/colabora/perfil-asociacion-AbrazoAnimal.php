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
                <h1 class="display-4 fw-bold text-dark mb-3">Abrazo Animal</h1>
                <p class="lead text-muted mb-0">
                    Liderando el cambio hacia un modelo de bienestar animal basado en la etología, la transparencia y el compromiso ético de Sacrificio Cero.
                </p>
            </div>

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
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">1</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Rehabilitación Etológica</h3>
                        <p class="mb-0 text-muted">Especialistas en la recuperación de animales con traumas o problemas de conducta, trabajando su equilibrio emocional antes de la adopción.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">2</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Protocolo Sacrificio Cero</h3>
                        <p class="mb-0 text-muted">Compromiso absoluto con la vida. Ningún animal es sacrificado por falta de espacio o tiempo de estancia en el centro.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">3</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Adopción Match-Making</h3>
                        <p class="mb-0 text-muted">Proceso de selección riguroso para asegurar que el estilo de vida de la familia y las necesidades del animal sean 100% compatibles.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="icon-box rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center text-center">
                        <div class="fw-bolder mb-3" style="color: var(--c5); font-size: 4.5rem; line-height: 1;">4</div>
                        <h3 class="h5 fw-bold text-dark mb-2">Educación Ciudadana</h3>
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
                <h2 class="fw-bold text-dark mb-2">Animales que buscan hogar en Abrazo Animal</h2>
            </div>

            <div class="row g-4 mb-5">
                
                <div class="col-md-6 col-xl-3">
                    <div class="card h-100 shadow-sm rounded-4 border-0 card-nexadopt position-relative overflow-hidden">
                        <div class="ratio ratio-4x3">
                            <img src="../../assets/img/mascotas/africa1.jpg" 
                                 class="card-img-top object-fit-cover" alt="África">
                        </div>
                        
                        <div class="card-body p-3 d-flex flex-column">
                            <h5 class="card-title fw-bold text-brand mb-1">África</h5>
                            <p class="card-text text-muted mb-0 small">
                                2 años - Hembra
                            </p>
                            <p class="card-text text-muted fw-semibold small mb-3">Pitbull</p>
                            
                            <div class="mt-auto">
                                <a href="../../perfil-mascota.php?id=0" class="btn btn-nexadopt w-100 btn-sm py-2">Ver perfil</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Esta parte buscará a los demás de forma general
                $sql_otros = "SELECT * FROM mascotas WHERE estado = 'Disponible' AND nombre != 'Africa' ORDER BY id_mascota DESC LIMIT 3";
                $res_otros = $conexion->query($sql_otros);

                if ($res_otros && $res_otros->num_rows > 0):
                    while ($m = $res_otros->fetch_assoc()):
                ?>
                    <div class="col-md-6 col-xl-3">
                        <div class="card h-100 shadow-sm rounded-4 border-0 card-nexadopt position-relative overflow-hidden">
                            <img src="../../assets/img/mascotas/<?= htmlspecialchars($m['foto_url']) ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($m['nombre']) ?>" 
                                 style="height: 250px; object-fit: cover;">
                            
                            <div class="card-body p-3 d-flex flex-column">
                                <h5 class="card-title fw-bold text-brand mb-1"><?= htmlspecialchars($m['nombre']) ?></h5>
                                <p class="card-text text-muted mb-0 small">
                                    <?= $m['edad_valor'] ?> <?= $m['edad_unidad'] ?> - <?= htmlspecialchars($m['sexo']) ?>
                                </p>
                                <p class="card-text text-muted fw-semibold small mb-3"><?= htmlspecialchars($m['raza']) ?></p>
                                
                                <div class=\"mt-auto\">
                                    <a href="../../perfil-mascota.php?id=<?= $m['id_mascota'] ?>" class="btn btn-nexadopt w-100 btn-sm py-2">Ver perfil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; endif; ?>

            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>