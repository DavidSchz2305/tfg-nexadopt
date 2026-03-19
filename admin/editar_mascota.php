<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}
require_once '../config/conexion.php';

if (!isset($_GET['id'])) {
    header("Location: lista_mascotas.php");
    exit();
}

$id_mascota = (int)$_GET['id'];
$mensaje = '';

// OBTENER DATOS ACTUALES PARA RELLENAR EL FORMULARIO
$res = $conexion->query("SELECT * FROM Mascotas WHERE id_mascota = $id_mascota");
$mascota = $res->fetch_assoc();

if (!$mascota) {
    header("Location: lista_mascotas.php");
    exit();
}

// LÓGICA DE RUTAS DE FOTOS
$foto_db = $mascota['foto_url'];
$ruta_base = "../assets/img/mascotas/";
$carpeta_mascota = (strpos($foto_db, '/') !== false) ? dirname($foto_db) : '';
$ruta_directorio = $carpeta_mascota ? ($ruta_base . $carpeta_mascota . "/") : $ruta_base;

// PROCESAR EL FORMULARIO SI SE HA ENVIADO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre      = $_POST['nombre'];
    $especie     = $_POST['especie'];
    $raza        = $_POST['raza'];
    $edad_valor  = $_POST['edad_valor'];
    $edad_unidad = $_POST['edad_unidad'];
    $sexo        = $_POST['sexo'];
    $tamanio     = $_POST['tamanio'];
    $estado      = $_POST['estado'];
    $descripcion = $_POST['descripcion'];

    // BORRAR FOTOS SELECCIONADAS
    if (!empty($_POST['eliminar_fotos'])) {
        foreach ($_POST['eliminar_fotos'] as $foto_a_borrar) {
            if (file_exists($foto_a_borrar)) {
                unlink($foto_a_borrar); // Borra el archivo físico del servidor
            }
        }
    }

    // SUBIR NUEVAS FOTOS
    // Si el perro es muy antiguo y no tenía carpeta propia, se la creamos ahora
    if (empty($carpeta_mascota)) {
        $nombre_limpio = preg_replace('/[^a-zA-Z0-9]/', '', $nombre);
        $carpeta_mascota = $nombre_limpio . "_" . time();
        $ruta_directorio = $ruta_base . $carpeta_mascota . "/";
        mkdir($ruta_directorio, 0777, true);
    }

    if (!empty($_FILES['nuevas_fotos']['name'][0])) {
        $total_fotos = count($_FILES['nuevas_fotos']['name']);
        for ($i = 0; $i < $total_fotos; $i++) {
            $ruta_temporal = $_FILES['nuevas_fotos']['tmp_name'][$i];
            if ($ruta_temporal != "") {
                $extension = pathinfo($_FILES['nuevas_fotos']['name'][$i], PATHINFO_EXTENSION);
                $nuevo_nombre_foto = "foto_nueva_" . time() . "_" . $i . "." . $extension;
                move_uploaded_file($ruta_temporal, $ruta_directorio . $nuevo_nombre_foto);
            }
        }
    }

    // ACTUALIZAR LA FOTO PRINCIPAL EN LA BASE DE DATOS
    // Leemos la carpeta para ver qué fotos quedan tras borrar/añadir
    $foto_principal_nueva = "";
    if (is_dir($ruta_directorio)) {
        $fotos_restantes = glob($ruta_directorio . "*.{jpg,jpeg,png,webp,gif}", GLOB_BRACE);
        if (!empty($fotos_restantes)) {
            // Cogemos la primera que haya en la carpeta y guardamos solo la ruta relativa (Carpeta/foto.jpg)
            $foto_principal_nueva = $carpeta_mascota . "/" . basename($fotos_restantes[0]);
        }
    }

    // ACTUALIZAR TODOS LOS DATOS EN LA BASE DE DATOS
    $sql_update = "UPDATE Mascotas SET 
                   nombre=?, especie=?, raza=?, edad_valor=?, edad_unidad=?, 
                   sexo=?, tamanio=?, estado=?, descripcion=?, foto_url=? 
                   WHERE id_mascota=?";
                   
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("sssissssssi", $nombre, $especie, $raza, $edad_valor, $edad_unidad, $sexo, $tamanio, $estado, $descripcion, $foto_principal_nueva, $id_mascota);

    if ($stmt->execute()) {
        $mensaje = '<div class="alert alert-success">¡Datos y fotos actualizados correctamente!</div>';
        // Volvemos a cargar los datos para que el formulario se muestre actualizado
        $res = $conexion->query("SELECT * FROM Mascotas WHERE id_mascota = $id_mascota");
        $mascota = $res->fetch_assoc();
    } else {
        $mensaje = '<div class="alert alert-danger">Error al actualizar: ' . $conexion->error . '</div>';
    }
}

// OBTENER LAS FOTOS ACTUALES PARA MOSTRARLAS
$fotos_actuales = [];
if ($carpeta_mascota && is_dir($ruta_directorio)) {
    $fotos_actuales = glob($ruta_directorio . "*.{jpg,jpeg,png,webp,gif}", GLOB_BRACE);
} elseif ($foto_db && file_exists($ruta_base . $foto_db)) {
    $fotos_actuales[] = $ruta_base . $foto_db; // Mascota antigua con 1 sola foto
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-brand mb-0">✏️ Editar Mascota: <?= htmlspecialchars($mascota['nombre']) ?></h2>
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
                                <option value="Perro" <?= ($mascota['especie'] == 'Perro') ? 'selected' : '' ?>>Perro</option>
                                <option value="Gato" <?= ($mascota['especie'] == 'Gato') ? 'selected' : '' ?>>Gato</option>
                                <option value="Otro" <?= ($mascota['especie'] == 'Otro') ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="Macho" <?= ($mascota['sexo'] == 'Macho') ? 'selected' : '' ?>>Macho</option>
                                <option value="Hembra" <?= ($mascota['sexo'] == 'Hembra') ? 'selected' : '' ?>>Hembra</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Raza</label>
                            <input type="text" name="raza" class="form-control" value="<?= htmlspecialchars($mascota['raza']) ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Edad (Valor)</label>
                            <input type="number" name="edad_valor" class="form-control" value="<?= $mascota['edad_valor'] ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Unidad</label>
                            <select name="edad_unidad" class="form-select">
                                <option value="años" <?= ($mascota['edad_unidad'] == 'años') ? 'selected' : '' ?>>Años</option>
                                <option value="meses" <?= ($mascota['edad_unidad'] == 'meses') ? 'selected' : '' ?>>Meses</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Tamaño</label>
                            <select name="tamanio" class="form-select">
                                <option value="Pequeño" <?= ($mascota['tamanio'] == 'Pequeño') ? 'selected' : '' ?>>Pequeño</option>
                                <option value="Mediano" <?= ($mascota['tamanio'] == 'Mediano') ? 'selected' : '' ?>>Mediano</option>
                                <option value="Grande" <?= ($mascota['tamanio'] == 'Grande') ? 'selected' : '' ?>>Grande</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-danger">Estado Actual</label>
                            <select name="estado" class="form-select border-danger">
                                <option value="Disponible" <?= ($mascota['estado'] == 'Disponible') ? 'selected' : '' ?>>🟢 Disponible</option>
                                <option value="En proceso" <?= ($mascota['estado'] == 'En proceso') ? 'selected' : '' ?>>🟡 En proceso</option>
                                <option value="Adoptado" <?= ($mascota['estado'] == 'Adoptado') ? 'selected' : '' ?>>🔴 Adoptado</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción / Historia</label>
                            <textarea name="descripcion" class="form-control" rows="5"><?= htmlspecialchars($mascota['descripcion']) ?></textarea>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 mt-5">2. Galería de Fotos</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Fotos actuales (Selecciona las que quieras eliminar)</label>
                        <div class="row g-3">
                            <?php if(!empty($fotos_actuales)): ?>
                                <?php foreach($fotos_actuales as $foto): ?>
                                    <div class="col-6 col-md-3 col-lg-2">
                                        <div class="position-relative">
                                            <img src="<?= htmlspecialchars($foto) ?>" class="img-fluid rounded-3 shadow-sm object-fit-cover w-100 border" style="height: 120px;">
                                            <div class="form-check mt-2 text-center bg-light border rounded-2 p-1">
                                                <input class="form-check-input float-none ms-0" type="checkbox" name="eliminar_fotos[]" value="<?= htmlspecialchars($foto) ?>" id="borrar_<?= md5($foto) ?>">
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
                        <button type="submit" class="btn btn-nexadopt px-5 btn-lg fw-bold shadow-sm"> Guardar Todos los Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_admin.php'; ?>