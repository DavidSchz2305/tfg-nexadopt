<?php
/**
 * Alta de nuevas mascotas en el sistema, incluyendo la creación de su carpeta
 * de imágenes y la subida de hasta 10 fotografías.
 */

session_start();

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../config/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recogemos y limpiamos los campos del formulario.
    $nombre      = trim($_POST['nombre']      ?? '');
    $especie     = trim($_POST['especie']     ?? '');
    $raza        = trim($_POST['raza']        ?? '');
    $edad_valor  = (int)($_POST['edad_valor'] ?? 0);
    $edad_unidad = trim($_POST['edad_unidad'] ?? '');
    $sexo        = trim($_POST['sexo']        ?? '');
    $tamanio     = trim($_POST['tamanio']     ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    // Limpiamos el nombre para usarlo como nombre de carpeta seguro en el servidor.
    // Solo dejamos letras y números para evitar problemas con el sistema de archivos.
    $nombre_limpio   = preg_replace('/[^a-zA-Z0-9]/', '', $nombre);
    $nombre_carpeta  = $nombre_limpio . '_' . time();
    $ruta_carpeta_destino = '../assets/img/mascotas/' . $nombre_carpeta . '/';

    // Creamos la carpeta de la mascota si no existe.
    if (!file_exists($ruta_carpeta_destino)) {
        mkdir($ruta_carpeta_destino, 0777, true);
    }

    $foto_principal      = '';
    $fotos_subidas_count = 0;

    // Limitamos a 10 fotos máximo para no saturar el servidor.
    $total_fotos = min(count($_FILES['fotos']['name']), 10);

    for ($i = 0; $i < $total_fotos; $i++) {
        $ruta_temporal = $_FILES['fotos']['tmp_name'][$i];

        if (!empty($ruta_temporal)) {
            $extension        = pathinfo($_FILES['fotos']['name'][$i], PATHINFO_EXTENSION);
            $nuevo_nombre_foto = 'foto_' . ($i + 1) . '_' . time() . '.' . strtolower($extension);
            $ruta_final_foto  = $ruta_carpeta_destino . $nuevo_nombre_foto;

            if (move_uploaded_file($ruta_temporal, $ruta_final_foto)) {
                // La primera foto que se suba exitosamente será la portada de la tarjeta en el catálogo.
                if ($i === 0) {
                    $foto_principal = $nombre_carpeta . '/' . $nuevo_nombre_foto;
                }
                $fotos_subidas_count++;
            }
        }
    }

    // Solo insertamos en BD si al menos una foto se subió correctamente.
    if ($fotos_subidas_count > 0) {
        try {
            $sql  = "INSERT INTO Mascotas 
                         (id_usuario_alta, nombre, especie, raza, edad_valor, edad_unidad, sexo, tamanio, descripcion, foto_url, estado) 
                     VALUES 
                         (:id_usuario, :nombre, :especie, :raza, :edad_valor, :edad_unidad, :sexo, :tamanio, :descripcion, :foto_url, 'Disponible')";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':id_usuario'  => (int)$_SESSION['id_usuario'],
                ':nombre'      => $nombre,
                ':especie'     => $especie,
                ':raza'        => $raza,
                ':edad_valor'  => $edad_valor,
                ':edad_unidad' => $edad_unidad,
                ':sexo'        => $sexo,
                ':tamanio'     => $tamanio,
                ':descripcion' => $descripcion,
                ':foto_url'    => $foto_principal,
            ]);

            $mensaje = '<div class="alert alert-success">¡Mascota añadida correctamente con ' . $fotos_subidas_count . ' foto(s)!</div>';

        } catch (PDOException $e) {
            error_log('[NexAdopt - CrearMascota Error] ' . $e->getMessage());
            $mensaje = '<div class="alert alert-danger">Error al guardar en la base de datos. Por favor, inténtalo de nuevo.</div>';
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
                            <input type="number" name="edad_valor" class="form-control" min="0" required>
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