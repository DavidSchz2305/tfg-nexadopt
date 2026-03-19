<?php
session_start();
require_once 'config/conexion.php';

// SEGURIDAD
if (!isset($_SESSION['id_usuario'])) { header("Location: login.php"); exit(); }
if (!isset($_GET['id_mascota'])) { header("Location: adoptar.php"); exit(); }

$id_mascota = $conexion->real_escape_string($_GET['id_mascota']);
$id_usuario = $_SESSION['id_usuario'];
$mensaje_exito = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexion->begin_transaction();
    try {
        // Crear la solicitud base
        $sql_sol = "INSERT INTO Solicitudes_Adopcion (id_mascota, id_usuario, estado_tramite, fecha_solicitud) VALUES (?, ?, 'Pendiente', NOW())";
        $stmt_sol = $conexion->prepare($sql_sol);
        $stmt_sol->bind_param("ii", $id_mascota, $id_usuario);
        $stmt_sol->execute();
        $id_solicitud = $conexion->insert_id;

        // Todas las preguntas y formulario
        $cuestionario = [
            "Nombre" => $_POST['nombre'],
            "Apellidos" => $_POST['apellidos'],
            "Email" => $_POST['email_contacto'],
            "Teléfono" => $_POST['telefono'],
            "DNI / NIE" => $_POST['dni'],
            "Fecha de Nacimiento" => $_POST['fecha_nac'],
            "Dirección completa" => $_POST['direccion'],
            "Estado Civil" => $_POST['estado_civil'],
            "Profesión" => $_POST['profesion'],
            "¿Eres la persona que va a adoptar?" => $_POST['titular'],
            "¿Vivienda de alquiler o propiedad?" => $_POST['vivienda_regimen'],
            "En alquiler: ¿Permiten animales?" => $_POST['permiso_animales'],
            "¿Tipo de vivienda?" => $_POST['tipo_vivienda'],
            "¿Jardín vallado?" => $_POST['jardin_vallado'],
            "¿Dónde vivirá el animal?" => $_POST['donde_vivira'],
            "¿Mudanzas recientes?" => $_POST['mudanzas'],
            "¿Plan si te mudas?" => $_POST['mudanza_futura'],
            "¿Cuántas personas viven en casa?" => $_POST['convivientes'],
            "¿Niños y su trato con animales?" => $_POST['ninos_trato'],
            "¿Hijos a futuro?" => $_POST['hijos_futuro'],
            "¿Bebé en camino?" => $_POST['bebe_plan'],
            "¿Plan en caso de divorcio?" => $_POST['divorcio_plan'],
            "¿Estabilidad económica?" => $_POST['estabilidad_econ'],
            "¿Tiempo solo?" => $_POST['tiempo_solo'],
            "¿Paseos al día?" => $_POST['paseos'],
            "¿Plan vacaciones?" => $_POST['vacaciones'],
            "¿Motivo de adopción?" => $_POST['motivo'],
            "¿Primera vez con esta especie?" => $_POST['primera_vez'],
            "Gastos veterinarios imprevistos" => $_POST['gastos_urgencia'],
            "Seguimiento post-adopción" => $_POST['seguimiento']
        ];

        $stmt_res = $conexion->prepare("INSERT INTO Respuestas_Adopcion (id_solicitud, pregunta, respuesta) VALUES (?, ?, ?)");
        foreach ($cuestionario as $pregunta => $respuesta) {
            $stmt_res->bind_param("iss", $id_solicitud, $pregunta, $respuesta);
            $stmt_res->execute();
        }

        $conexion->commit();
        $conexion->query("UPDATE Mascotas SET estado = 'En proceso' WHERE id_mascota = '$id_mascota'");
        $mensaje_exito = "Cuestionario completo enviado correctamente.";
    } catch (Exception $e) { $conexion->rollback(); }
}

$mascota = $conexion->query("SELECT nombre, foto_url FROM Mascotas WHERE id_mascota = '$id_mascota'")->fetch_assoc();
include 'includes/header.php';
?>

<main class="site-main bg-light py-5">
    <div class="container">
        <div class="card border-0 shadow rounded-4 p-5 bg-white">
            <h2 class="fw-bold text-brand text-center mb-5">Formulario de Pre-Adopción Detallado</h2>
            
            <?php if ($mensaje_exito): ?>
                <div class="alert alert-success text-center"><h3>¡Enviado!</h3><p><?= $mensaje_exito ?></p><a href="adoptar.php" class="btn btn-nexadopt mt-3">Finalizar</a></div>
            <?php else: ?>
                <form action="" method="POST" class="row g-4">
                    
                    <h5 class="border-bottom pb-2 fw-bold text-brand">1. Datos del adoptante</h5>
                    <div class="col-md-4"><label class="form-label fw-bold">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Apellidos</label><input type="text" name="apellidos" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label fw-bold">DNI / NIE</label><input type="text" name="dni" class="form-control" required></div>
                    
                    <div class="col-md-6"><label class="form-label fw-bold">Email de contacto</label><input type="email" name="email_contacto" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label fw-bold">Teléfono</label><input type="tel" name="telefono" class="form-control" required></div>
                    
                    <div class="col-md-4"><label class="form-label fw-bold">Fecha Nacimiento</label><input type="date" name="fecha_nac" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Estado Civil</label><input type="text" name="estado_civil" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Profesión</label><input type="text" name="profesion" class="form-control"></div>
                    <div class="col-12"><label class="form-label fw-bold">Dirección y Código Postal</label><input type="text" name="direccion" class="form-control" required></div>
                    <div class="col-12"><label class="form-label fw-bold">¿Eres la persona que va a adoptar al animal?</label><select name="titular" class="form-select"><option>Sí</option><option>No</option></select></div>

                    <h5 class="border-bottom pb-2 fw-bold text-brand mt-5">2. Preguntas sobre el entorno</h5>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Vivienda de alquiler o propiedad?</label><select name="vivienda_regimen" class="form-select"><option>Propiedad</option><option>Alquiler</option></select></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Tipo de vivienda?</label><input type="text" name="tipo_vivienda" class="form-control" placeholder="Piso, Chalet..."></div>
                    <div class="col-12"><label class="form-label fw-bold">En alquiler: ¿Permiten animales?</label><input type="text" name="permiso_animales" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Exterior vallado?</label><select name="jardin_vallado" class="form-select"><option>Sí</option><option>No</option><option>N/A</option></select></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Dónde vivirá el animal?</label><input type="text" name="donde_vivira" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Mudanzas recientes?</label><input type="text" name="mudanzas" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Plan si te mudas?</label><input type="text" name="mudanza_futura" class="form-control"></div>

                    <h5 class="border-bottom pb-2 fw-bold text-brand mt-5">3. Familia y Convivencia</h5>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Cuántas personas viven?</label><input type="number" name="convivientes" class="form-control"></div>
                    <div class="col-md-8"><label class="form-label fw-bold">¿Hay niños y conocen el trato animal?</label><input type="text" name="ninos_trato" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Hijos a futuro?</label><input type="text" name="hijos_futuro" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Bebé en camino?</label><input type="text" name="bebe_plan" class="form-control"></div>
                    <div class="col-12"><label class="form-label fw-bold">¿Plan en caso de separación/divorcio?</label><textarea name="divorcio_plan" class="form-control"></textarea></div>

                    <h5 class="border-bottom pb-2 fw-bold text-brand mt-5">4. Ocupación y Tiempo libre</h5>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Estabilidad económica?</label><select name="estabilidad_econ" class="form-select"><option>Sí</option><option>No</option></select></div>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Tiempo solo al día?</label><input type="text" name="tiempo_solo" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Paseos diarios?</label><input type="number" name="paseos" class="form-control"></div>
                    <div class="col-12"><label class="form-label fw-bold">¿Qué harás en vacaciones?</label><textarea name="vacaciones" class="form-control"></textarea></div>

                    <h5 class="border-bottom pb-2 fw-bold text-brand mt-5">5. Responsabilidad</h5>
                    <div class="col-12"><label class="form-label fw-bold">¿Motivo de la adopción?</label><textarea name="motivo" class="form-control"></textarea></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Primera vez con la especie?</label><select name="primera_vez" class="form-select"><option>Sí</option><option>No</option></select></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Tienes otros animales?</label><input type="text" name="otros_animales" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Asumirías urgencias veterinarias?</label><select name="gastos_urgencia" class="form-select"><option>Sí</option><option>No</option></select></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Aceptas seguimiento post-adopción?</label><select name="seguimiento" class="form-select"><option>Sí</option><option>No</option></select></div>

                    <div class="col-12 mt-5 text-center"><button type="submit" class="btn btn-nexadopt btn-lg px-5 shadow-sm fw-bold">Enviar Cuestionario Profesional</button></div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>