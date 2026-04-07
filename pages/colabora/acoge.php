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
                <a href="asociaciones.php" class="btn btn-outline-nexadopt btn-lg px-4">Asociaciones</a>
                <a href="../../adoptar.php" class="btn btn-outline-nexadopt btn-lg px-4">Buscar hogar</a>
                <a href="../donar.php" class="btn btn-outline-nexadopt btn-lg px-4">Donar</a>
            </div>
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold text-brand mb-3">Colabora con nosotros</h1>
                <p class="lead text-dark mb-0">Hay muchas formas de ayudar a los animales que necesitan un hogar.</p>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">

            <div class="row g-5 align-items-start mb-5">

                <div class="col-lg-8">
                    <div class="d-flex flex-column flex-sm-row align-items-center gap-4">
                        <div class="flex-shrink-0 mx-auto mx-sm-0">
                            <img
                                src="../../assets/img/colaborar/acoge/casa_de_acogida.png"
                                alt="Perro de acogida"
                                class="rounded-circle shadow"
                                style="width: 260px; height: 260px; object-fit: cover; object-position: center;">
                        </div>
                        <div>
                            <p class="text-dark fs-5 lh-lg mb-3">
                                Si te gustan los animales, pero no tienes ahora mismo una vida estable para poder hacerte
                                responsable de una adopción que durará toda la vida del animal, existe otra forma para
                                disfrutar de la compañía de un perro o gato&nbsp;…
                                ¡¡Hazte CASA de <strong>ACOGIDA TEMPORAL</strong>!!
                            </p>
                            <p class="text-dark fs-5 lh-lg mb-3">
                                Te permitirá disfrutar de todos los aspectos positivos que conlleva compartir nuestra
                                vida con un perro o gato, pero sólo tendrás esa responsabilidad de manera temporal,
                                mientras NexAdopt le encuentra un hogar definitivo al animal acogido.
                            </p>
                            <p class="text-dark fs-5 lh-lg mb-0">
                                <strong>La protectora se encarga de todos los costes veterinarios y de manutención
                                del animal</strong>, tú solo tienes que cuidarlo y quererlo como se merece durante
                                el tiempo que conviva contigo.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold text-brand mb-4 border-bottom pb-3">Requisitos</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-4">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 58px; height: 58px;">
                                    <img src="../../assets/img/colaborar/acoge/icon-casa1.png" alt="Casa" style="width: 34px; height: 34px; object-fit: contain;">
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block">Hogar seguro y cómodo</span>
                                    <span class="text-muted small">Espacio adecuado para el animal</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-4">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 58px; height: 58px;">
                                    <img src="../../assets/img/colaborar/acoge/icon-tiempo1.png" alt="Tiempo" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block">Disponibilidad de tiempo</span>
                                    <span class="text-muted small">Para paseos, juego y atención diaria</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-4">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 58px; height: 58px;">
                                    <img src="../../assets/img/colaborar/acoge/icon-bien.png" alt="Bienestar" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block">Compromiso con el bienestar</span>
                                    <span class="text-muted small">Responsabilidad durante la acogida</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-4">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 58px; height: 58px;">
                                    <img src="../../assets/img/colaborar/acoge/icon-Vete.png" alt="Veterinario" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block">Sin coste veterinario</span>
                                    <span class="text-muted small">NexAdopt cubre todos los gastos</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 58px; height: 58px;">
                                    <img src="../../assets/img/colaborar/acoge/icon-Apoyo1.png" alt="Apoyo" style="width: 50px; height: 50px; object-fit: contain; filter: brightness(0);">
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block">Apoyo continuo</span>
                                    <span class="text-muted small">Nuestro equipo te acompaña siempre</span>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-4 pt-3 border-top">
                            <a href="../../contacto.php" class="btn btn-nexadopt w-100 fw-bold rounded-pill py-2">
                                Quiero acoger
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <p class="text-dark fs-5 lh-lg mb-3">
                        Cualquiera de nuestros animales en adopción puede ser un buen candidato para acoger, pero siempre
                        requerimos de hogares temporales para cachorros, ancianos, animales debilitados que se están
                        recuperando de alguna enfermedad o intervención o animales con miedos o excesiva timidez que no
                        avanzan correctamente en el albergue.
                    </p>
                    <p class="text-dark fs-5 lh-lg mb-5">
                        La acogida salva vidas, no solo permite que el animal acogido esté esperando en un entorno más
                        agradable y cómodo mientras le encontramos una familia definitiva, sino que nos deja un hueco
                        libre en el albergue para poder rescatar a otro animal que lo necesita, por lo que aunque solo
                        acojas a un animal, <strong>en realidad estás ayudando a salvar dos vidas.</strong>
                    </p>

                    <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5 text-center">
                        <h4 class="fw-bold text-dark mb-2">¿Interesado?</h4>
                        <p class="text-muted mb-4 fs-5">Completa nuestro formulario de solicitud y nos pondremos en contacto contigo.</p>
                        <a href="../../contacto.php"
                           class="btn btn-nexadopt btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm text-uppercase"
                           style="letter-spacing: 1px;">
                            Solicitar ser familia de acogida
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php include '../../includes/footer.php'; ?>