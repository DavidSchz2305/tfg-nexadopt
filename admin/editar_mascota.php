<?php
/**
 * Edición completa de una mascota: datos, estado, clínica y galería de fotos.
 * FLUJO: Cargamos datos → procesamos POST si existe → recargamos datos → renderizamos.
 */

session_start();

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

// Validamos que nos llegue un ID numérico positivo por GET.
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: lista_mascotas.php');
    exit();
}

$id_mascota = (int)$_GET['id'];
$mensaje    = '';

// =========================================================================
// FUNCIÓN AUXILIAR: Carga los datos de una mascota por su ID
// =========================================================================
function cargarMascota(PDO $conexion, int $id): ?array
{
    try {
        $stmt = $conexion->prepare("SELECT * FROM Mascotas WHERE id_mascota = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    } catch (PDOException $e) {
        error_log('[NexAdopt - EditarMascota/Load Error] ' . $e->getMessage());
        return null;
    }
}

$mascota = cargarMascota($conexion, $id_mascota);

if (!$mascota) {
    header('Location: lista_mascotas.php');
    exit();
}

// =========================================================================
// LÓGICA DE RUTAS: calculamos la carpeta de imágenes de esta mascota
// =========================================================================
$foto_db         = $mascota['foto_url'];
$ruta_base       = '../assets/img/mascotas/';
$carpeta_mascota = (strpos($foto_db, '/') !== false) ? dirname($foto_db) : '';
$ruta_directorio = $carpeta_mascota ? ($ruta_base . $carpeta_mascota . '/') : $ruta_base;

// =========================================================================
// PROCESAMIENTO DEL FORMULARIO (POST)
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre      = trim($_POST['nombre']      ?? '');
    $especie     = trim($_POST['especie']     ?? '');
    $raza        = trim($_POST['raza']        ?? '');
    $edad_valor  = (int)($_POST['edad_valor'] ?? 0);
    $edad_unidad = trim($_POST['edad_unidad'] ?? '');
    $sexo        = trim($_POST['sexo']        ?? '');
    $tamanio     = trim($_POST['tamanio']     ?? '');
    $estado      = trim($_POST['estado']      ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    //CAMPOS CLÍNICOS
    $vacunado       = isset($_POST['vacunado']) ? 1 : 0;
    $desparasitado  = isset($_POST['desparasitado']) ? 1 : 0;
    $castrado       = isset($_POST['castrado']) ? 1 : 0;
    $fecha_revision = !empty($_POST['fecha_revision']) ? $_POST['fecha_revision'] : null;

    // --- PASO 1: Eliminar fotos marcadas para borrar ---
    if (!empty($_POST['eliminar_fotos'])) {
        foreach ($_POST['eliminar_fotos'] as $foto_a_borrar) {
            $foto_real = realpath($foto_a_borrar);
            if ($foto_real && file_exists($foto_real)) {
                unlink($foto_real);
            }
        }
    }

    // --- PASO 2: Crear carpeta si la mascota es antigua y no tenía ninguna ---
    if (empty($carpeta_mascota)) {
        $nombre_limpio   = preg_replace('/[^a-zA-Z0-9]/', '', $nombre);
        $carpeta_mascota = $nombre_limpio . '_' . time();
        $ruta_directorio = $ruta_base . $carpeta_mascota . '/';
        mkdir($ruta_directorio, 0777, true);
    }

    // --- PASO 3: Subir nuevas fotos si las hay ---
    if (!empty($_FILES['nuevas_fotos']['name'][0])) {
        $total_nuevas = count($_FILES['nuevas_fotos']['name']);
        for ($i = 0; $i < $total_nuevas; $i++) {
            $ruta_temporal = $_FILES['nuevas_fotos']['tmp_name'][$i];
            if (!empty($ruta_temporal)) {
                $extension         = pathinfo($_FILES['nuevas_fotos']['name'][$i], PATHINFO_EXTENSION);
                $nuevo_nombre_foto = 'foto_nueva_' . time() . '_' . $i . '.' . strtolower($extension);
                move_uploaded_file($ruta_temporal, $ruta_directorio . $nuevo_nombre_foto);
            }
        }
    }

    // --- PASO 4: Determinar la nueva foto principal ---
    $foto_principal_nueva = '';
    if (is_dir($ruta_directorio)) {
        $fotos_restantes = glob($ruta_directorio . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
        if (!empty($fotos_restantes)) {
            $foto_principal_nueva = $carpeta_mascota . '/' . basename($fotos_restantes[0]);
        }
    }

    // --- PASO 5: Actualizar en base de datos ---
    try {
        // ACTUALIZACIÓN DE SQL CON CAMPOS CLÍNICOS
        $sql_update = "UPDATE Mascotas SET 
                           nombre        = :nombre,
                           especie       = :especie,
                           raza          = :raza,
                           edad_valor    = :edad_valor,
                           edad_unidad   = :edad_unidad,
                           sexo          = :sexo,
                           tamanio       = :tamanio,
                           estado        = :estado,
                           descripcion   = :descripcion,
                           foto_url      = :foto_url,
                           vacunado      = :vacunado,
                           desparasitado = :desparasitado,
                           castrado      = :castrado,
                           fecha_revision= :fecha_revision
                       WHERE id_mascota = :id";

        $stmt = $conexion->prepare($sql_update);
        $stmt->execute([
            ':nombre'        => $nombre,
            ':especie'       => $especie,
            ':raza'          => $raza,
            ':edad_valor'    => $edad_valor,
            ':edad_unidad'   => $edad_unidad,
            ':sexo'          => $sexo,
            ':tamanio'       => $tamanio,
            ':estado'        => $estado,
            ':descripcion'   => $descripcion,
            ':foto_url'      => $foto_principal_nueva,
            ':vacunado'      => $vacunado,
            ':desparasitado' => $desparasitado,
            ':castrado'      => $castrado,
            ':fecha_revision'=> $fecha_revision,
            ':id'            => $id_mascota,
        ]);

        $mensaje = '<div class="alert alert-success">¡Datos y fotos actualizados correctamente!</div>';

        // Recargamos los datos actualizados para que el formulario refleje los cambios al instante.
        $mascota         = cargarMascota($conexion, $id_mascota);
        $foto_db         = $mascota['foto_url'] ?? '';
        $carpeta_mascota = (strpos($foto_db, '/') !== false) ? dirname($foto_db) : '';
        $ruta_directorio = $carpeta_mascota ? ($ruta_base . $carpeta_mascota . '/') : $ruta_base;

    } catch (PDOException $e) {
        error_log('[NexAdopt - EditarMascota/Update Error] ' . $e->getMessage());
        $mensaje = '<div class="alert alert-danger">Error al actualizar los datos. Por favor, inténtalo de nuevo.</div>';
    }
}

// =========================================================================
// CARGAMOS LAS FOTOS ACTUALES PARA MOSTRARLAS EN LA GALERÍA
// =========================================================================
$fotos_actuales = [];
if ($carpeta_mascota && is_dir($ruta_directorio)) {
    $fotos_actuales = glob($ruta_directorio . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
} elseif ($foto_db && file_exists($ruta_base . $foto_db)) {
    $fotos_actuales[] = $ruta_base . $foto_db;
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-start">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-brand mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="pencil" style="width:24px; height:24px;"></i> Editar Mascota: <?= htmlspecialchars($mascota['nombre']) ?>
                    </h2>
                    <a href="lista_mascotas.php" class="btn btn-outline-secondary btn-sm fw-bold">Volver al Inventario</a>
                </div>

                <?= $mensaje ?>

                <form action="editar_mascota.php?id=<?= $id_mascota ?>" method="POST" enctype="multipart/form-data">

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 mt-2">1. Datos Generales</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($mascota['nombre']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Especie</label>
                            <select name="especie" class="form-select" required>
                                <option value="Perro"  <?= ($mascota['especie'] === 'Perro')  ? 'selected' : '' ?>>Perro</option>
                                <option value="Gato"   <?= ($mascota['especie'] === 'Gato')   ? 'selected' : '' ?>>Gato</option>
                                <option value="Otro"   <?= ($mascota['especie'] === 'Otro')   ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="Macho"  <?= ($mascota['sexo'] === 'Macho')  ? 'selected' : '' ?>>Macho</option>
                                <option value="Hembra" <?= ($mascota['sexo'] === 'Hembra') ? 'selected' : '' ?>>Hembra</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Raza</label>
                            <input type="text" name="raza" class="form-control" value="<?= htmlspecialchars($mascota['raza']) ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Edad (Valor)</label>
                            <input type="number" name="edad_valor" class="form-control" value="<?= (int)$mascota['edad_valor'] ?>" required min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Unidad</label>
                            <select name="edad_unidad" class="form-select">
                                <option value="años"  <?= ($mascota['edad_unidad'] === 'años')  ? 'selected' : '' ?>>Años</option>
                                <option value="meses" <?= ($mascota['edad_unidad'] === 'meses') ? 'selected' : '' ?>>Meses</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Tamaño</label>
                            <select name="tamanio" class="form-select">
                                <option value="Pequeño" <?= ($mascota['tamanio'] === 'Pequeño') ? 'selected' : '' ?>>Pequeño</option>
                                <option value="Mediano" <?= ($mascota['tamanio'] === 'Mediano') ? 'selected' : '' ?>>Mediano</option>
                                <option value="Grande"  <?= ($mascota['tamanio'] === 'Grande')  ? 'selected' : '' ?>>Grande</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-danger">Estado Actual</label>
                            <select name="estado" class="form-select border-danger">
                                <option value="Disponible" <?= ($mascota['estado'] === 'Disponible') ? 'selected' : '' ?>>🟢 Disponible</option>
                                <option value="En proceso" <?= ($mascota['estado'] === 'En proceso') ? 'selected' : '' ?>>🟡 En proceso</option>
                                <option value="Adoptado"   <?= ($mascota['estado'] === 'Adoptado')   ? 'selected' : '' ?>>🔴 Adoptado</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-brand border-bottom pb-2">Información Clínica</h6>
                            <div class="row g-3 py-2">
                                <div class="col-md-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="vacunado" value="1" id="vax" <?= (!empty($mascota['vacunado'])) ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-semibold" for="vax">Vacunado</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="desparasitado" value="1" id="desp" <?= (!empty($mascota['desparasitado'])) ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-semibold" for="desp">Desparasitado</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="castrado" value="1" id="cast" <?= (!empty($mascota['castrado'])) ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-semibold" for="cast">Esterilizado</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Fecha de última revisión</label>
                                    <input type="date" name="fecha_revision" class="form-control form-control-sm" value="<?= $mascota['fecha_revision'] ?? '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label fw-bold">Descripción / Historia</label>
                            <textarea name="descripcion" class="form-control" rows="5"><?= htmlspecialchars($mascota['descripcion']) ?></textarea>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 mt-5">2. Galería de Fotos</h5>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Fotos actuales (Selecciona las que quieras eliminar)</label>
                        <div class="row g-3">
                            <?php if (!empty($fotos_actuales)): ?>
                                <?php foreach ($fotos_actuales as $foto): ?>
                                    <div class="col-6 col-md-3 col-lg-2">
                                        <div class="position-relative">
                                            <img src="<?= htmlspecialchars($foto) ?>" class="img-fluid rounded-3 shadow-sm object-fit-cover w-100 border" style="height: 120px;">
                                            <div class="form-check mt-2 text-center bg-light border rounded-2 p-1">
                                                <input class="form-check-input float-none ms-0" type="checkbox"
                                                       name="eliminar_fotos[]"
                                                       value="<?= htmlspecialchars($foto) ?>"
                                                       id="borrar_<?= md5($foto) ?>">
                                                <label class="form-check-label text-danger fw-bold small ms-1" for="borrar_<?= md5($foto) ?>">Borrar</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted small fst-italic">Este animal no tiene fotos registradas.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 bg-light p-4 rounded-3 border">
                        <label class="form-label fw-bold">Añadir nuevas fotos</label>
                        <input type="file" name="nuevas_fotos[]" class="form-control bg-white" accept="image/*" multiple>
                        <small class="text-muted mt-1 d-block">Puedes seleccionar varias fotos a la vez manteniendo pulsado CTRL. Las fotos se añadirán a la galería actual.</small>
                    </div>

                    <div class="col-12 mt-5 text-end border-top pt-4">
                        <a href="lista_mascotas.php" class="btn btn-outline-secondary px-4 me-2 fw-bold">Cancelar</a>
                        <button type="submit" class="btn btn-nexadopt px-5 btn-lg fw-bold shadow-sm">
                            Guardar Todos los Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>