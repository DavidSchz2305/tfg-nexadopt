<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/conexion.php';
include '../includes/header.php';
?>

<main class="site-main bg-crema py-5">
    <div class="container py-4">
        
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h1 class="fw-bold text-brand display-5 mb-3">Apoya nuestra misión</h1>
                <p class="lead text-muted">Tu donación nos ayuda a cuidar y encontrar hogares para más mascotas.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-brand">Realiza tu donación</h4>
                    
                    <form action="#" method="POST" id="form-donacion">
                        
                        <div class="row g-4 mb-5 text-center">
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="tipo_donacion" id="unica" value="Única" checked onchange="actualizarResumen()">
                                <label class="donar-radio w-100 p-4 rounded-4 h-100 d-flex flex-column justify-content-center" for="unica">
                                    <h5 class="fw-bold mb-2">Donación Única</h5>
                                    <span class="small">Ayuda puntual para emergencias</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="tipo_donacion" id="mensual" value="Mensual" onchange="actualizarResumen()">
                                <label class="donar-radio w-100 p-4 rounded-4 h-100 d-flex flex-column justify-content-center" for="mensual">
                                    <h5 class="fw-bold mb-2">Donación Mensual</h5>
                                    <span class="small">Apoyo constante a la protectora</span>
                                </label>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3 text-brand">Seleccione una cantidad:</h6>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <input type="radio" class="btn-check cantidad-radio" name="cantidad" id="cant10" value="10" checked onchange="actualizarResumen()">
                            <label class="donar-radio px-4 py-2 rounded-3 fw-bold fs-5" for="cant10">10€</label>

                            <input type="radio" class="btn-check cantidad-radio" name="cantidad" id="cant20" value="20" onchange="actualizarResumen()">
                            <label class="donar-radio px-4 py-2 rounded-3 fw-bold fs-5" for="cant20">20€</label>

                            <input type="radio" class="btn-check cantidad-radio" name="cantidad" id="cant40" value="40" onchange="actualizarResumen()">
                            <label class="donar-radio px-4 py-2 rounded-3 fw-bold fs-5" for="cant40">40€</label>

                            <input type="radio" class="btn-check cantidad-radio" name="cantidad" id="cant60" value="60" onchange="actualizarResumen()">
                            <label class="donar-radio px-4 py-2 rounded-3 fw-bold fs-5" for="cant60">60€</label>

                            <input type="radio" class="btn-check cantidad-radio" name="cantidad" id="cant80" value="80" onchange="actualizarResumen()">
                            <label class="donar-radio px-4 py-2 rounded-3 fw-bold fs-5" for="cant80">80€</label>

                            <input type="radio" class="btn-check cantidad-radio" name="cantidad" id="cant100" value="100" onchange="actualizarResumen()">
                            <label class="donar-radio px-4 py-2 rounded-3 fw-bold fs-5" for="cant100">100€</label>
                        </div>

                        <label class="form-label mb-2 mt-3 text-brand fw-bold small">O ingresa una cantidad personalizada:</label>
                        <div class="input-group mb-5 shadow-sm rounded-3 overflow-hidden donar-input-group" style="max-width: 250px;">
                            <input type="number" class="form-control form-control-lg border-end-0 border-brand" id="cantidad-custom" placeholder="0.00" oninput="limpiarRadiosYActualizar()">
                            <span class="input-group-text bg-white border-start-0 border-brand fw-bold text-brand">€</span>
                        </div>

                        <h6 class="fw-bold mb-3 text-brand">Método de pago:</h6>
                        <div class="row g-3 mb-5 text-center">
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="metodo_pago" id="tarjeta" value="tarjeta" checked onchange="mostrarFormularioPago()">
                                <label class="donar-radio w-100 p-3 rounded-3 d-flex align-items-center justify-content-center gap-2" for="tarjeta">
                                    <i class="fa-solid fa-credit-card fs-4"></i>
                                    <span class="fw-bold">Tarjeta</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="metodo_pago" id="bizum" value="bizum" onchange="mostrarFormularioPago()">
                                <label class="donar-radio w-100 p-3 rounded-3 d-flex align-items-center justify-content-center gap-2" for="bizum">
                                    <i class="fa-solid fa-mobile-screen fs-5"></i>
                                    <span class="fw-bold">Bizum</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="metodo_pago" id="paypal" value="paypal" onchange="mostrarFormularioPago()">
                                <label class="donar-radio w-100 p-3 rounded-3 d-flex align-items-center justify-content-center gap-2" for="paypal">
                                    <i class="fa-brands fa-paypal fs-5"></i>
                                    <span class="fw-bold">PayPal</span>
                                </label>
                            </div>
                        </div>

                        <hr class="mb-5" style="border-color: var(--c2);">

                        <div class="row g-5">
                            
                            <div class="col-md-7">
                                <h6 class="fw-bold mb-3 text-brand">Información del donante:</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Nombre completo" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control bg-light border-0 py-2" placeholder="Correo Electrónico" required>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control bg-light border-0 py-2" rows="3" placeholder="Mensaje (Opcional)"></textarea>
                                    </div>
                                </div>

                                <div id="form-tarjeta" class="p-4 rounded-3 border bg-light">
                                    <h6 class="fw-bold mb-3 small text-brand text-uppercase">Datos de la tarjeta</h6>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <input type="text" class="form-control" placeholder="MM/AA">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" placeholder="CVV">
                                        </div>
                                    </div>
                                </div>

                                <div id="form-bizum" class="p-4 rounded-3 border d-none bg-light text-center">
                                    <h6 class="fw-bold mb-3 small text-brand text-uppercase">Pago con Bizum</h6>
                                    <p class="small text-muted mb-2">Introduce tu número de teléfono para enviar la solicitud.</p>
                                    <input type="tel" class="form-control w-75 mx-auto text-center" placeholder="Ej: 600 000 000">
                                </div>

                                <div id="form-paypal" class="p-4 rounded-3 border d-none bg-light text-center">
                                    <h6 class="fw-bold mb-3 small text-brand text-uppercase">Pago con PayPal</h6>
                                    <p class="small text-muted mb-0">Serás redirigido a la pasarela segura de PayPal al hacer clic en Donar Ahora.</p>
                                </div>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="p-4 p-xl-5 rounded-4 h-100 d-flex flex-column justify-content-center text-center shadow-sm bg-crema donar-summary-card">
                                    <p class="text-muted mb-1 small text-uppercase fw-bold">Cantidad a donar:</p>
                                    <h2 class="fw-bold text-accent mb-4 display-6" id="resumen-cantidad">10.00 €</h2>
                                    
                                    <p class="text-muted mb-1 small text-uppercase fw-bold">Tipo:</p>
                                    <h5 class="fw-bold text-brand mb-4 pb-4 border-bottom" id="resumen-tipo" style="border-color: var(--c2) !important;">Donación Única</h5>

                                    <button type="button" class="btn btn-donar-action btn-lg w-100 fw-bold rounded-pill shadow-sm mb-3" onclick="alert('¡Transacción simulada completada!')">
                                        Donar Ahora
                                    </button>
                                    
                                    <div class="d-flex align-items-center justify-content-center text-success">
                                        <i class="fa-solid fa-lock me-2"></i>
                                        <span class="small fw-bold">Transacción segura SSL</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="text-center mt-5 pt-3">
                    <h3 class="fw-bold text-brand mb-5">El impacto de tu ayuda</h3>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="donar-impact-card p-4 h-100 d-flex flex-column justify-content-center align-items-center shadow-sm">
                                <div class="mb-3" style="color: var(--c3);">
                                    <i class="fa-solid fa-bowl-food fs-1"></i>
                                </div>
                                <h2 class="fw-bold text-accent mb-2 display-6">10€</h2>
                                <p class="text-muted px-2 mb-0">Comida de calidad para una mascota durante 1 semana entera.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="donar-impact-card p-4 h-100 d-flex flex-column justify-content-center align-items-center shadow-sm">
                                <div class="mb-3" style="color: var(--c3);">
                                    <i class="fa-solid fa-stethoscope fs-1"></i>
                                </div>
                                <h2 class="fw-bold text-accent mb-2 display-6">50€</h2>
                                <p class="text-muted px-2 mb-0">Revisión veterinaria completa, test de salud y análisis.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="donar-impact-card p-4 h-100 d-flex flex-column justify-content-center align-items-center shadow-sm">
                                <div class="mb-3" style="color: var(--c3);">
                                    <i class="fa-solid fa-syringe fs-1"></i>
                                </div>
                                <h2 class="fw-bold text-accent mb-2 display-6">100€</h2>
                                <p class="text-muted px-2 mb-0">Vacunas anuales, desparasitación completa y microchip.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    function mostrarFormularioPago() {
        const metodo = document.querySelector('input[name="metodo_pago"]:checked').value;
        document.getElementById('form-tarjeta').classList.add('d-none');
        document.getElementById('form-bizum').classList.add('d-none');
        document.getElementById('form-paypal').classList.add('d-none');
        document.getElementById('form-' + metodo).classList.remove('d-none');
    }

    function actualizarResumen() {
        const tipo = document.querySelector('input[name="tipo_donacion"]:checked').value;
        document.getElementById('resumen-tipo').innerText = 'Donación ' + tipo;

        let cantidad = 0;
        const inputCustom = document.getElementById('cantidad-custom').value;
        
        if (inputCustom && inputCustom > 0) {
            cantidad = parseFloat(inputCustom);
        } else {
            const radioSeleccionado = document.querySelector('input.cantidad-radio:checked');
            if(radioSeleccionado) cantidad = parseFloat(radioSeleccionado.value);
        }

        document.getElementById('resumen-cantidad').innerText = cantidad.toFixed(2) + ' €';
    }

    function limpiarRadiosYActualizar() {
        const radios = document.querySelectorAll('.cantidad-radio');
        radios.forEach(radio => radio.checked = false);
        actualizarResumen();
    }
</script>

<?php include '../includes/footer.php'; ?>