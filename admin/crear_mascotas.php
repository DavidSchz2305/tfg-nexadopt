<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}
require_once '../config/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos datos del formulario
    $nombre      = $_POST['nombre'];
    $especie     = $_POST['especie'];
    $raza        = $_POST['raza'];
    $edad_valor  = $_POST['edad_valor'];
    $edad_unidad = $_POST['edad_unidad'];
    $sexo        = $_POST['sexo'];
    $tamanio     = $_POST['tamanio'];
    $descripcion = $_POST['descripcion'];

    
    
    // Limpiamos el nombre de la mascota para usarlo en la carpeta (quitamos espacios y caracteres raros)
    $nombre_limpio = preg_replace('/[^a-zA-Z0-9]/', '', $nombre);
    
    // Creamos el nombre de la carpeta: Nombre + Tiempo (para evitar duplicados si hay dos perros llamados igual)
    $nombre_carpeta = $nombre_limpio . "_" . time();
    $ruta_carpeta_destino = "../assets/img/mascotas/" . $nombre_carpeta . "/";

    // Creamos la carpeta físicamente en el servidor si no existe
    if (!file_exists($ruta_carpeta_destino)) {
        mkdir($ruta_carpeta_destino, 0777, true);
    }

    $foto_principal = "";
    $fotos_subidas_count = 0;
    
    // Contamos cuántas fotos ha subido el usuario
    $total_fotos = count($_FILES['fotos']['name']);
    
    // Limitamos a un máximo de 10 fotos
    if ($total_fotos > 10) {
        $total_fotos = 10;
    }

    // Recorremos todas las fotos subidas
    for ($i = 0; $i < $total_fotos; $i++) {
        $foto_nombre = $_FILES['fotos']['name'][$i];
        $ruta_temporal = $_FILES['fotos']['tmp_name'][$i];

        if ($ruta_temporal != "") {
            // Generamos un nombre seguro para cada foto (ej: foto_1_171098.jpg)
            $extension = pathinfo($foto_nombre, PATHINFO_EXTENSION);
            $nuevo_nombre_foto = "foto_" . ($i + 1) . "_" . time() . "." . $extension;
            $ruta_final_foto = $ruta_carpeta_destino . $nuevo_nombre_foto;

            // Movemos la foto a su nueva carpeta
            if (move_uploaded_file($ruta_temporal, $ruta_final_foto)) {
                // Si es la PRIMERA foto (índice 0), la guardamos como foto principal para la Base de Datos
                if ($i == 0) {
                    $foto_principal = $nombre_carpeta . "/" . $nuevo_nombre_foto;
                }
                $fotos_subidas_count++;
            }
        }
    }

    // Si al menos se ha subido 1 foto con éxito, insertamos en BD
    if ($fotos_subidas_count > 0) {
        $sql = "INSERT INTO Mascotas (id_usuario_alta, nombre, especie, raza, edad_valor, edad_unidad, sexo, tamanio, descripcion, foto_url, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Disponible')";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isssisssss", $_SESSION['id_usuario'], $nombre, $especie, $raza, $edad_valor, $edad_unidad, $sexo, $tamanio, $descripcion, $foto_principal);

        if ($stmt->execute()) {
            $mensaje = '<div class="alert alert-success">¡Mascota añadida correctamente con ' . $fotos_subidas_count . ' fotos!</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al guardar en BD: ' . $conexion->error . '</div>';
        }
    } else {
        $mensaje = '<div class="alert alert-danger">Error: Debes subir al menos 1 foto válida.</div>';
    }
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                <h2 class="fw-bold text-brand mb-4 d-flex align-items-center gap-2">
                    <i data-lucide="paw-print" style="width:28px; height:28px;"></i> Añadir Nueva Mascota
                </h2>
                <?= $mensaje ?>

                <form action="crear_mascotas.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="tag" style="width:14px; height:14px;"></i> Nombre
                            </label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="layers" style="width:14px; height:14px;"></i> Especie
                            </label>
                            <select name="especie" class="form-select" required>
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="user" style="width:14px; height:14px;"></i> Sexo
                            </label>
                            <select name="sexo" class="form-select">
                                <option value="Macho">Macho</option>
                                <option value="Hembra">Hembra</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="git-branch" style="width:14px; height:14px;"></i> Raza
                            </label>
                            <input type="text" name="raza" class="form-control" placeholder="Ej: Labrador, Mestizo...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="calendar" style="width:14px; height:14px;"></i> Edad (Valor)
                            </label>
                            <input type="number" name="edad_valor" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="clock" style="width:14px; height:14px;"></i> Unidad
                            </label>
                            <select name="edad_unidad" class="form-select">
                                <option value="años">Años</option>
                                <option value="meses">Meses</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="maximize-2" style="width:14px; height:14px;"></i> Tamaño
                            </label>
                            <select name="tamanio" class="form-select">
                                <option value="Pequeño">Pequeño</option>
                                <option value="Mediano">Mediano</option>
                                <option value="Grande">Grande</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="file-text" style="width:14px; height:14px;"></i> Descripción / Historia
                            </label>
                            <textarea name="descripcion" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold d-flex align-items-center gap-1">
                                <i data-lucide="image" style="width:14px; height:14px;"></i> Fotos de la mascota (Hasta 10 imágenes)
                            </label>
                            <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple required>
                            <small class="text-muted">Mantén pulsada la tecla CTRL para seleccionar varias fotos a la vez en tu ordenador.</small>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <a href="dashboard.php" class="btn btn-outline-secondary px-4 me-2 d-inline-flex align-items-center gap-1">
                                <i data-lucide="x" style="width:14px; height:14px;"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-nexadopt px-5 d-inline-flex align-items-center gap-2">
                                <i data-lucide="save" style="width:16px; height:16px;"></i> Guardar Mascota
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>

<?php include '../includes/footer_admin.php'; ?>