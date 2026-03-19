<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}
require_once '../config/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos datos
    $nombre      = $_POST['nombre'];
    $especie     = $_POST['especie'];
    $raza        = $_POST['raza'];
    $edad_valor  = $_POST['edad_valor'];
    $edad_unidad = $_POST['edad_unidad'];
    $sexo        = $_POST['sexo'];
    $tamanio     = $_POST['tamanio'];
    $descripcion = $_POST['descripcion'];

    // Gestión de la FOTO
    $foto_nombre = $_FILES['foto']['name'];
    $ruta_temporal = $_FILES['foto']['tmp_name'];
    $carpeta_destino = "../assets/img/mascotas/";
    
    // Creamos un nombre único para la foto para que no se sobreescriban
    $foto_final = time() . "_" . $foto_nombre;

    if (move_uploaded_file($ruta_temporal, $carpeta_destino . $foto_final)) {
        // Insertamos en la base de datos (Usando tus columnas exactas)
        $sql = "INSERT INTO Mascotas (id_usuario_alta, nombre, especie, raza, edad_valor, edad_unidad, sexo, tamanio, descripcion, foto_url, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Disponible')";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isssisssss", $_SESSION['id_usuario'], $nombre, $especie, $raza, $edad_valor, $edad_unidad, $sexo, $tamanio, $descripcion, $foto_final);

        if ($stmt->execute()) {
            $mensaje = '<div class="alert alert-success">¡Mascota añadida correctamente!</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al guardar en BD: ' . $conexion->error . '</div>';
        }
    } else {
        $mensaje = '<div class="alert alert-danger">Error al subir la foto. Revisa los permisos de la carpeta.</div>';
    }
}

include '../includes/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                <h2 class="fw-bold text-brand mb-4">🐾 Añadir Nueva Mascota</h2>
                <?= $mensaje ?>

                <form action="crear_mascotas.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Especie</label>
                            <select name="especie" class="form-select" required>
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="Macho">Macho</option>
                                <option value="Hembra">Hembra</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Raza</label>
                            <input type="text" name="raza" class="form-control" placeholder="Ej: Labrador, Mestizo...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Edad (Valor)</label>
                            <input type="number" name="edad_valor" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Unidad</label>
                            <select name="edad_unidad" class="form-select">
                                <option value="años">Años</option>
                                <option value="meses">Meses</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tamaño</label>
                            <select name="tamanio" class="form-select">
                                <option value="Pequeño">Pequeño</option>
                                <option value="Mediano">Mediano</option>
                                <option value="Grande">Grande</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción / Historia</label>
                            <textarea name="descripcion" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Foto de la mascota</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <a href="dashboard.php" class="btn btn-outline-secondary px-4 me-2">Cancelar</a>
                            <button type="submit" class="btn btn-nexadopt px-5">Guardar Mascota</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_admin.php'; ?>