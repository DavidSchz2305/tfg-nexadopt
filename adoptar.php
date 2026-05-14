<?php
/**
 * Catálogo público de mascotas con sistema de filtros avanzados.
 */

include 'includes/header.php';
require_once 'config/conexion.php';

$f_especie = trim($_GET['especie'] ?? '');
$f_raza    = trim($_GET['raza']    ?? '');
$f_edad    = trim($_GET['edad']    ?? '');
$f_tamano  = trim($_GET['tamano']  ?? '');
$f_genero  = trim($_GET['genero']  ?? '');

$hay_filtros = ($f_especie || $f_raza || $f_edad || $f_tamano || $f_genero);

// =========================================================================
// 1. CONSULTA DINÁMICA DE RAZAS
// =========================================================================
$razas_disponibles = [];
try {
    $stmt_razas = $conexion->query("SELECT DISTINCT raza FROM Mascotas WHERE raza IS NOT NULL AND raza != '' ORDER BY raza ASC");
    $razas_disponibles = $stmt_razas->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    error_log('[NexAdopt - Adoptar/Razas Error] ' . $e->getMessage());
}

// =========================================================================
// 2. CONSTRUCCIÓN DINÁMICA Y SEGURA DE LA CONSULTA CON PDO
// =========================================================================

// Solo contamos solicitudes que NO estén rechazadas para el badge
$sql_base  = "SELECT *, (SELECT COUNT(*) FROM Solicitudes_Adopcion s WHERE s.id_mascota = Mascotas.id_mascota AND s.estado_tramite != 'Rechazado') as total_solicitudes FROM Mascotas WHERE estado != 'Adoptado'";
$where     = [];
$params    = [];

$especie_map = ['perros' => 'Perro', 'gatos' => 'Gato', 'otros' => 'Otro'];
$tamano_map  = ['pequeno' => 'Pequeño', 'mediano' => 'Mediano', 'grande' => 'Grande'];

if ($f_especie !== '' && isset($especie_map[$f_especie])) {
    $where[]           = "especie = :especie";
    $params[':especie'] = $especie_map[$f_especie];
}

if ($f_raza !== '') {
    $where[]        = "raza = :raza";
    $params[':raza'] = $f_raza;
}

if ($f_tamano !== '' && isset($tamano_map[$f_tamano])) {
    $where[]          = "tamanio = :tamano";
    $params[':tamano'] = $tamano_map[$f_tamano];
}

if ($f_genero !== '') {
    $where[]          = "sexo = :genero";
    $params[':genero'] = ucfirst($f_genero);
}

if ($f_edad !== '') {
    if ($f_edad === 'cachorro') {
        $where[] = "(edad_unidad = 'días' OR edad_unidad = 'meses' OR (edad_unidad = 'años' AND edad_valor < 1))";
    } elseif ($f_edad === 'adulto') {
        $where[] = "(edad_unidad = 'años' AND edad_valor >= 1 AND edad_valor <= 7)";
    } elseif ($f_edad === 'senior') {
        $where[] = "(edad_unidad = 'años' AND edad_valor > 7)";
    }
}

if (!empty($where)) {
    $sql_base .= ' AND ' . implode(' AND ', $where);
}
$sql_base .= " ORDER BY id_mascota DESC";

$mascotas_filtradas = [];
try {
    $stmt = $conexion->prepare($sql_base);
    $stmt->execute($params);
    $mascotas_filtradas = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('[NexAdopt - Adoptar/Filtros Error] ' . $e->getMessage());
}
?>

<main class="site-main bg-crema py-5">
    <div class="container">
        
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-5 fw-bold text-brand">Adopta a tu nuevo mejor amigo</h1>
                <p class="lead" style="color: #4a5d63;">Utiliza los filtros para encontrar la mascota que mejor se adapte a tu estilo de vida.</p>
            </div>
        </div>

        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="bg-white p-4 rounded-4 shadow-sm border card-nexadopt sticky-lg-top" style="top: 110px;">
                    <h4 class="fw-bold text-brand mb-4">Filtros</h4>
                    
                    <form action="adoptar.php" method="GET">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brand d-flex align-items-center gap-1">
                                <i data-lucide="paw-print" style="width:14px; height:14px;"></i> Especie
                            </label>
                            <select class="form-select border-c2" name="especie">
                                <option value="">Todos</option>
                                <option value="perros" <?= ($f_especie === 'perros') ? 'selected' : '' ?>>Perros</option>
                                <option value="gatos"  <?= ($f_especie === 'gatos')  ? 'selected' : '' ?>>Gatos</option>
                                <option value="otros"  <?= ($f_especie === 'otros')  ? 'selected' : '' ?>>Otros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brand d-flex align-items-center gap-1">
                                <i data-lucide="tag" style="width:14px; height:14px;"></i> Raza
                            </label>
                            <select class="form-select border-c2" name="raza">
                                <option value="">Cualquier raza</option>
                                <?php foreach ($razas_disponibles as $raza): ?>
                                    <?php if (!empty(trim($raza))): ?>
                                        <option value="<?= htmlspecialchars($raza) ?>" <?= ($f_raza === $raza) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($raza) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brand d-flex align-items-center gap-1">
                                <i data-lucide="calendar" style="width:14px; height:14px;"></i> Edad
                            </label>
                            <select class="form-select border-c2" name="edad">
                                <option value="">Todas las edades</option>
                                <option value="cachorro" <?= ($f_edad === 'cachorro') ? 'selected' : '' ?>>Cachorro (0-1 año)</option>
                                <option value="adulto"   <?= ($f_edad === 'adulto')   ? 'selected' : '' ?>>Adulto (1-7 años)</option>
                                <option value="senior"   <?= ($f_edad === 'senior')   ? 'selected' : '' ?>>Senior (+7 años)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brand d-flex align-items-center gap-1">
                                <i data-lucide="maximize-2" style="width:14px; height:14px;"></i> Tamaño
                            </label>
                            <select class="form-select border-c2" name="tamano">
                                <option value="">Cualquier tamaño</option>
                                <option value="pequeno" <?= ($f_tamano === 'pequeno') ? 'selected' : '' ?>>Pequeño</option>
                                <option value="mediano" <?= ($f_tamano === 'mediano') ? 'selected' : '' ?>>Mediano</option>
                                <option value="grande"  <?= ($f_tamano === 'grande')  ? 'selected' : '' ?>>Grande</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brand d-flex align-items-center gap-1">
                                <i data-lucide="users" style="width:14px; height:14px;"></i> Género
                            </label>
                            <select class="form-select border-c2" name="genero">
                                <option value="">Cualquiera</option>
                                <option value="macho"  <?= ($f_genero === 'macho')  ? 'selected' : '' ?>>Macho</option>
                                <option value="hembra" <?= ($f_genero === 'hembra') ? 'selected' : '' ?>>Hembra</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-nexadopt">Aplicar filtros</button>
                            <?php if ($hay_filtros): ?>
                                <a href="adoptar.php" class="btn btn-outline-secondary btn-sm">Limpiar filtros</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </aside>

            <div class="col-lg-9">
                
                <?php if ($hay_filtros): ?>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4 p-3 bg-white rounded-3 shadow-sm border card-nexadopt">
                    <span class="text-muted small fw-semibold me-2">Filtros activos:</span>
                    <?php if ($f_especie): ?><span class="badge bg-verde-claro text-brand border border-c3 px-3 py-2 fs-6 rounded-pill fw-normal">Especie: <?= htmlspecialchars(ucfirst($f_especie)) ?></span><?php endif; ?>
                    <?php if ($f_raza):    ?><span class="badge bg-verde-claro text-brand border border-c3 px-3 py-2 fs-6 rounded-pill fw-normal">Raza: <?= htmlspecialchars(ucfirst($f_raza)) ?></span><?php endif; ?>
                    <?php if ($f_edad):    ?><span class="badge bg-verde-claro text-brand border border-c3 px-3 py-2 fs-6 rounded-pill fw-normal">Edad: <?= htmlspecialchars(ucfirst($f_edad)) ?></span><?php endif; ?>
                    <?php if ($f_tamano):  ?><span class="badge bg-verde-claro text-brand border border-c3 px-3 py-2 fs-6 rounded-pill fw-normal">Tamaño: <?= htmlspecialchars(ucfirst($f_tamano)) ?></span><?php endif; ?>
                    <?php if ($f_genero):  ?><span class="badge bg-verde-claro text-brand border border-c3 px-3 py-2 fs-6 rounded-pill fw-normal">Género: <?= htmlspecialchars(ucfirst($f_genero)) ?></span><?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

                    <?php if (empty($mascotas_filtradas)): ?>
                        <div class="col-12 w-100 text-center py-5">
                            <div class="p-5 bg-white rounded-4 shadow-sm border border-c2">
                                <div class="mb-3 d-flex justify-content-center gap-2">
                                    <i data-lucide="search-x" style="width:48px; height:48px; color: var(--color-brand, #4a5d63);"></i>
                                </div>
                                <h4 class="text-brand fw-bold">No hemos encontrado compañeros con esos filtros</h4>
                                <p class="text-muted">Prueba a quitar algún filtro o buscar de forma más general.</p>
                                <a href="adoptar.php" class="btn btn-nexadopt mt-2">Ver todos los animales</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($mascotas_filtradas as $mascota): 
                            $es_en_proceso = ($mascota['estado'] === 'En proceso' || $mascota['total_solicitudes'] > 0);
                            $badge_class = $es_en_proceso ? 'bg-warning text-dark' : 'bg-success text-white';
                            $badge_text  = $es_en_proceso ? 'En trámite' : 'Disponible';
                        ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm rounded-4 border-0 card-nexadopt position-relative overflow-hidden">
                                    
                                    <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                        <span class="badge rounded-pill shadow-sm px-3 py-2 <?= $badge_class ?>" style="font-size: 0.7rem;">
                                            <?= $badge_text ?>
                                        </span>
                                    </div>

                                    <img src="assets/img/mascotas/<?= htmlspecialchars($mascota['foto_url']) ?>"
                                         class="card-img-top"
                                         alt="<?= htmlspecialchars($mascota['nombre']) ?>"
                                         style="height: 280px; object-fit: cover;">
                                    <div class="card-body p-3 d-flex flex-column">
                                        <h5 class="card-title fw-bold text-brand mb-1"><?= htmlspecialchars($mascota['nombre']) ?></h5>
                                        <p class="card-text text-muted mb-0 small">
                                            <?= (int)$mascota['edad_valor'] ?> <?= htmlspecialchars($mascota['edad_unidad']) ?> - <?= htmlspecialchars($mascota['sexo']) ?>
                                        </p>
                                        <p class="card-text text-muted fw-semibold small"><?= htmlspecialchars($mascota['raza']) ?></p>
                                        <div class="mt-auto pt-3 row g-2">
                                            <div class="col-12">
                                                <a href="perfil-mascota.php?id=<?= (int)$mascota['id_mascota'] ?>" class="btn btn-nexadopt w-100 btn-sm py-2">
                                                    Ver perfil para adoptar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>lucide.createIcons();</script>

<?php include 'includes/footer.php'; ?>