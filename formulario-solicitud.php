<?php
/**
 * Cuestionario de pre-adopción. Es la pieza más crítica del flujo de negocio,
 * ya que necesita insertar datos en dos tablas de forma atómica.
 */

session_start();
require_once 'config/conexion.php';

// Verificamos que el usuario esté autenticado y que nos llegue un ID de mascota válido.
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}
if (!isset($_GET['id_mascota']) || !ctype_digit($_GET['id_mascota'])) {
    header('Location: adoptar.php');
    exit();
}

// Casteamos a entero para asegurarnos de que el valor es numérico antes de usarlo.
$id_mascota  = (int)$_GET['id_mascota'];
$id_usuario  = (int)$_SESSION['id_usuario'];
$mensaje_exito = '';
$error_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Definimos el cuestionario completo como un mapa pregunta => respuesta.
    // Usamos el operador ?: para asegurarnos de que los campos vacíos no generen warnings.
    $cuestionario = [
        'Nombre'                                => $_POST['nombre']          ?? '',
        'Apellidos'                             => $_POST['apellidos']        ?? '',
        'Email'                                 => $_POST['email_contacto']   ?? '',
        'Teléfono'                              => $_POST['telefono']         ?? '',
        'DNI / NIE'                             => $_POST['dni']              ?? '',
        'Fecha de Nacimiento'                   => $_POST['fecha_nac']        ?? '',
        'Dirección completa'                    => $_POST['direccion']        ?? '',
        'Estado Civil'                          => $_POST['estado_civil']     ?? '',
        'Profesión'                             => $_POST['profesion']        ?? '',
        '¿Eres la persona que va a adoptar?'   => $_POST['titular']          ?? '',
        '¿Vivienda de alquiler o propiedad?'   => $_POST['vivienda_regimen'] ?? '',
        'En alquiler: ¿Permiten animales?'     => $_POST['permiso_animales'] ?? '',
        '¿Tipo de vivienda?'                   => $_POST['tipo_vivienda']    ?? '',
        '¿Jardín vallado?'                     => $_POST['jardin_vallado']   ?? '',
        '¿Dónde vivirá el animal?'             => $_POST['donde_vivira']     ?? '',
        '¿Mudanzas recientes?'                 => $_POST['mudanzas']         ?? '',
        '¿Plan si te mudas?'                   => $_POST['mudanza_futura']   ?? '',
        '¿Cuántas personas viven en casa?'     => $_POST['convivientes']     ?? '',
        '¿Niños y su trato con animales?'      => $_POST['ninos_trato']      ?? '',
        '¿Hijos a futuro?'                     => $_POST['hijos_futuro']     ?? '',
        '¿Bebé en camino?'                     => $_POST['bebe_plan']        ?? '',
        '¿Plan en caso de divorcio?'           => $_POST['divorcio_plan']    ?? '',
        '¿Estabilidad económica?'              => $_POST['estabilidad_econ'] ?? '',
        '¿Tiempo solo?'                        => $_POST['tiempo_solo']      ?? '',
        '¿Paseos al día?'                      => $_POST['paseos']           ?? '',
        '¿Plan vacaciones?'                    => $_POST['vacaciones']       ?? '',
        '¿Motivo de adopción?'                 => $_POST['motivo']           ?? '',
        '¿Primera vez con esta especie?'       => $_POST['primera_vez']      ?? '',
        'Gastos veterinarios imprevistos'       => $_POST['gastos_urgencia']  ?? '',
        'Seguimiento post-adopción'             => $_POST['seguimiento']      ?? '',
    ];

    try {
        // Iniciamos la transacción. Si cualquier operación falla, ejecutamos rollBack
        // para revertir todo y no dejar datos huérfanos en la BD.
        $conexion->beginTransaction();

        // Paso 1: Creamos el registro principal de la solicitud con estado 'Pendiente'.
        $sql_sol = "INSERT INTO Solicitudes_Adopcion (id_mascota, id_usuario, estado_tramite, fecha_solicitud) 
                    VALUES (:id_mascota, :id_usuario, 'Pendiente', NOW())";
        $stmt_sol = $conexion->prepare($sql_sol);
        $stmt_sol->execute([
            ':id_mascota' => $id_mascota,
            ':id_usuario' => $id_usuario,
        ]);

        // Recuperamos el ID de la solicitud recién creada para enlazar las respuestas.
        $id_solicitud = (int)$conexion->lastInsertId();

        // Paso 2: Insertamos cada respuesta del cuestionario asociada al ID de la solicitud.
        // Preparamos la sentencia una sola vez fuera del bucle para optimizar el rendimiento.
        $stmt_res = $conexion->prepare(
            "INSERT INTO Respuestas_Adopcion (id_solicitud, pregunta, respuesta) VALUES (:id_solicitud, :pregunta, :respuesta)"
        );

        foreach ($cuestionario as $pregunta => $respuesta) {
            $stmt_res->execute([
                ':id_solicitud' => $id_solicitud,
                ':pregunta'     => $pregunta,
                ':respuesta'    => trim($respuesta),
            ]);
        }

        // Paso 3: Actualizamos el estado de la mascota a 'En proceso' para que
        // no pueda recibir más solicitudes mientras se tramita esta.
        $stmt_estado = $conexion->prepare("UPDATE Mascotas SET estado = 'En proceso' WHERE id_mascota = :id");
        $stmt_estado->execute([':id' => $id_mascota]);

        // Si todo fue bien, confirmamos los cambios en la BD.
        $conexion->commit();
        $mensaje_exito = 'Cuestionario completo enviado correctamente.';

    } catch (PDOException $e) {
        // Si algo falla, revertimos TODAS las operaciones de esta transacción.
        $conexion->rollBack();
        error_log('[NexAdopt - Solicitud Error] ' . $e->getMessage());
        $error_mensaje = 'Ha ocurrido un error al enviar tu solicitud. Por favor, inténtalo de nuevo.';
    }
}

// Cargamos los datos de la mascota para mostrar su nombre en el formulario.
$mascota = null;
try {
    $stmt_mascota = $conexion->prepare("SELECT nombre, foto_url FROM Mascotas WHERE id_mascota = :id LIMIT 1");
    $stmt_mascota->execute([':id' => $id_mascota]);
    $mascota = $stmt_mascota->fetch();
} catch (PDOException $e) {
    error_log('[NexAdopt - Solicitud/Load Error] ' . $e->getMessage());
}

if (!$mascota) {
    header('Location: adoptar.php');
    exit();
}

include 'includes/header.php';
?>

<main class="site-main bg-light py-5">
    <div class="container">
        <div class="card border-0 shadow rounded-4 p-5 bg-white">
            <h2 class="fw-bold text-brand text-center mb-5">Formulario de Pre-Adopción Detallado</h2>
            
            <?php if ($mensaje_exito): ?>
                <div class="alert alert-success text-center">
                    <h3>¡Enviado!</h3>
                    <p><?= htmlspecialchars($mensaje_exito) ?></p>
                    <a href="adoptar.php" class="btn btn-nexadopt mt-3">Finalizar</a>
                </div>
            <?php elseif ($error_mensaje): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error_mensaje) ?></div>
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
                    <div class="col-md-4"><label class="form-label fw-bold">¿Cuántas personas viven?</label><input type="number" name="convivientes" class="form-control" min="1"></div>
                    <div class="col-md-8"><label class="form-label fw-bold">¿Hay niños y conocen el trato animal?</label><input type="text" name="ninos_trato" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Hijos a futuro?</label><input type="text" name="hijos_futuro" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Bebé en camino?</label><input type="text" name="bebe_plan" class="form-control"></div>
                    <div class="col-12"><label class="form-label fw-bold">¿Plan en caso de separación/divorcio?</label><textarea name="divorcio_plan" class="form-control"></textarea></div>

                    <h5 class="border-bottom pb-2 fw-bold text-brand mt-5">4. Ocupación y Tiempo libre</h5>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Estabilidad económica?</label><select name="estabilidad_econ" class="form-select"><option>Sí</option><option>No</option></select></div>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Tiempo solo al día?</label><input type="text" name="tiempo_solo" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">¿Paseos diarios?</label><input type="number" name="paseos" class="form-control" min="0"></div>
                    <div class="col-12"><label class="form-label fw-bold">¿Qué harás en vacaciones?</label><textarea name="vacaciones" class="form-control"></textarea></div>

                    <h5 class="border-bottom pb-2 fw-bold text-brand mt-5">5. Responsabilidad</h5>
                    <div class="col-12"><label class="form-label fw-bold">¿Motivo de la adopción?</label><textarea name="motivo" class="form-control"></textarea></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Primera vez con la especie?</label><select name="primera_vez" class="form-select"><option>Sí</option><option>No</option></select></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Tienes otros animales?</label><input type="text" name="otros_animales" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Asumirías urgencias veterinarias?</label><select name="gastos_urgencia" class="form-select"><option>Sí</option><option>No</option></select></div>
                    <div class="col-md-6"><label class="form-label fw-bold">¿Aceptas seguimiento post-adopción?</label><select name="seguimiento" class="form-select"><option>Sí</option><option>No</option></select></div>

                    <div class="col-12 mt-5 text-center">
                        <button type="submit" class="btn btn-nexadopt btn-lg px-5 shadow-sm fw-bold">
                            Enviar Cuestionario Profesional
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>