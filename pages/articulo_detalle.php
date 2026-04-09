<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../consejos.php");
    exit();
}

$articulo_id = intval($_GET['id']);


$full_content = [
    1 => [
        "id" => 1,
        "categoria" => "Perros",
        "titulo" => "Cómo presentar a tu perro actual a un nuevo cachorro",
        "icono" => "fas fa-dog",
        "intro" => "Aprende las mejores prácticas para introducir un nuevo miembro a la familia sin generar estrés ni conflictos en casa.",
        "puntos_clave" => [
            "El Territorio Neutral es Esencial.",
            "Controla la Energía Inicial y usa correa.",
            "Supervísalos los primeros días de convivencia.",
            "Premia el buen comportamiento siempre."
        ],
        "contenido_completo" => "
            <p><strong>Paso 1: El Territorio Neutral es Esencial.</strong> Nunca realices la primera presentación dentro de tu casa. Esto puede activar el instinto territorial de tu perro actual. Elige un parque tranquilo o una calle lateral donde ninguno de los dos se sienta dueño del espacio.</p>
            <p><strong>Paso 2: Controla la Energía Inicial.</strong> Ambos perros deben estar con correa y bajo control. Permite un breve acercamiento para que se huelan, pero mantén una energía calmada. Si alguno de los dos se muestra demasiado efusivo, sepáralos y espera a que se calmen.</p>
            <p><strong>Paso 3: Supervísalos los Primeros Días.</strong> Cuando finalmente los traigas a casa, no los dejes solos. Utiliza barreras infantiles o mantén al cachorro en un parque de juegos cuando no puedas supervisarlos. Asegúrate de que tu perro actual siga teniendo su propio espacio.</p>
        "
    ],
    2 => [
        "id" => 2,
        "categoria" => "Gatos",
        "titulo" => "El lenguaje corporal de los gatos: qué te están diciendo",
        "icono" => "fas fa-cat",
        "intro" => "Descubre cómo interpretar los movimientos de la cola, orejas y bigotes de tu felino para entender sus emociones.",
        "puntos_clave" => [
            "La cola alta significa felicidad o saludo.",
            "Orejas hacia atrás indican miedo o agresividad.",
            "El ronroneo no siempre es sinónimo de relajación.",
            "El parpadeo lento es un beso de gato."
        ],
        "contenido_completo" => "
            <p><strong>La Cola:</strong> Es el principal indicador. Una cola erguida en forma de signo de interrogación indica un saludo amistoso. Si la cola está inflada, el gato está asustado o agresivo. Si la mueve de lado a lado rápidamente, está irritado, ¡déjalo tranquilo!</p>
            <p><strong>Las Orejas:</strong> Un gato relajado tiene las orejas apuntando hacia adelante. Si se aplanan hacia los lados (como un avión), está ansioso o a punto de atacar.</p>
            <p><strong>Los Ojos:</strong> Las pupilas dilatadas pueden significar miedo o excitación (por ejemplo, al jugar). Si tu gato te mira y parpadea lentamente, te está mostrando confianza extrema. Intenta devolverle el parpadeo lentamente.</p>
        "
    ],
    3 => [
        "id" => 3,
        "categoria" => "Salud",
        "titulo" => "Calendario de vacunas esencial para tu mascota",
        "icono" => "fas fa-heartbeat",
        "intro" => "Conoce las vacunas obligatorias y recomendadas para mantener a tu perro o gato protegido.",
        "puntos_clave" => [
            "Primera vacuna a las 6-8 semanas de vida.",
            "Revacunación anual obligatoria (Rabia).",
            "Protección contra Leishmania y Tos de las perreras.",
            "Desparasitación interna trimestral."
        ],
        "contenido_completo" => "
            <p><strong>Perros:</strong> La pauta suele comenzar a las 6 semanas con la vacuna contra el Parvovirus y el Moquillo. Posteriormente, se administran refuerzos polivalentes (Heptavalente) y, a los 3 meses, es obligatoria por ley la vacuna de la Rabia, que debe renovarse anualmente.</p>
            <p><strong>Gatos:</strong> La Trivalente Felina (Panleucopenia, Rinotraqueítis y Calicivirus) es fundamental y se inicia a las 8 semanas. Si tu gato tiene acceso al exterior, la vacuna contra la Leucemia Felina es altamente recomendable.</p>
            <p>Recuerda que ningún calendario de vacunación es efectivo si el animal no está previamente desparasitado. Consulta siempre con tu veterinario de confianza.</p>
        "
    ],
    4 => [
        "id" => 4,
        "categoria" => "General",
        "titulo" => "Preparando tu casa para la llegada de un animal",
        "icono" => "fas fa-home",
        "intro" => "Aprende a eliminar peligros y crear un espacio seguro y acogedor antes de traer a tu nuevo mejor amigo.",
        "puntos_clave" => [
            "Oculta cables eléctricos y productos tóxicos.",
            "Prepara una 'zona segura' o refugio tranquilo.",
            "Asegura ventanas y balcones (especial para gatos).",
            "Compra los suministros básicos antes de su llegada."
        ],
        "contenido_completo" => "
            <p><strong>A prueba de mascotas:</strong> Tírate al suelo para ver la casa desde su perspectiva. Cables sueltos, plantas tóxicas (como los lirios o el aloe vera), y pequeños objetos tragables deben ser retirados. Asegura los cubos de basura.</p>
            <p><strong>La Zona Segura:</strong> Tu nueva mascota necesita un lugar donde retirarse si se siente abrumada. Una cama cómoda en una esquina tranquila, lejos del ruido constante, es ideal. No lo molestes cuando esté en su refugio.</p>
            <p><strong>Seguridad en alturas:</strong> Si adoptas un gato, es imperativo instalar redes mosquiteras o mallas protectoras en ventanas y balcones para evitar el temido 'Síndrome del Gato Paracaidista'.</p>
        "
    ],
    5 => [
        "id" => 5,
        "categoria" => "Alimentación",
        "titulo" => "Alimentos prohibidos que nunca debes dar a tu perro",
        "icono" => "fas fa-utensils",
        "intro" => "Una guía completa sobre los alimentos de consumo humano que son tóxicos y peligrosos.",
        "puntos_clave" => [
            "El chocolate es altamente tóxico (Teobromina).",
            "Uvas y pasas causan fallo renal.",
            "Cebolla, ajo y puerro destruyen glóbulos rojos.",
            "Cuidado con los huesos cocinados (se astillan)."
        ],
        "contenido_completo" => "
            <p><strong>Chocolate:</strong> Contiene teobromina, una sustancia que los perros metabolizan muy lentamente. Puede causar vómitos, diarrea, temblores e incluso la muerte. Cuanto más puro sea el chocolate, más peligroso.</p>
            <p><strong>Uvas y Pasas:</strong> Aunque el mecanismo tóxico exacto se desconoce, ingerir incluso pequeñas cantidades de uvas o pasas puede causar una insuficiencia renal aguda e irreversible en perros.</p>
            <p><strong>Huesos Cocinados:</strong> A diferencia de los huesos crudos, los huesos que han sido hervidos o asados pierden colágeno y se astillan fácilmente al ser masticados. Esto puede provocar perforaciones graves en el esófago o los intestinos.</p>
        "
    ],
    6 => [
        "id" => 6,
        "categoria" => "Perros",
        "titulo" => "Cómo enseñar a tu perro a pasear sin tirar de la correa",
        "icono" => "fas fa-walking",
        "intro" => "Técnicas de adiestramiento en positivo para disfrutar de paseos relajados y seguros.",
        "puntos_clave" => [
            "Utiliza un arnés cómodo, no collares de castigo.",
            "El truco del 'Árbol': si tira, tú te detienes.",
            "Premia cuando camine a tu lado con la correa floja.",
            "Cansa a tu perro mentalmente antes de salir."
        ],
        "contenido_completo" => "
            <p><strong>Equipamiento correcto:</strong> Olvida los collares de ahorque o púas. Un buen arnés antitirones (con enganche en el pecho) redirigirá la fuerza del perro hacia un lado sin hacerle daño en la tráquea.</p>
            <p><strong>La técnica del Árbol:</strong> La regla de oro es: <em>Un perro que tira no avanza</em>. En el momento en que sientas tensión en la correa, detente por completo. Conviértete en una estatua. No tires hacia atrás ni le hables. Solo cuando la correa se afloje, reanuda la marcha.</p>
            <p><strong>Refuerzo positivo:</strong> Lleva premios muy sabrosos. Cada vez que tu perro camine a tu lado sin tensar la correa, o te mire, dale un premio. Esto le enseñará que la mejor posición es estar cerca de ti.</p>
        "
    ]
];

if (!array_key_exists($articulo_id, $full_content)) {
    header("Location: ../consejos.php");
    exit();
}

$articulo = $full_content[$articulo_id];

include '../includes/header.php';
?>

<main class="site-main py-5" style="background-color: var(--c1);">
    <div class="container py-4 text-start">
        
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge rounded-pill fw-bold bg-light text-muted border px-3 py-2">
                            <i class="<?php echo $articulo['icono']; ?> me-1"></i> <?php echo $articulo['categoria']; ?>
                        </span>
                        <a href="../consejos.php" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> Volver a la lista
                        </a>
                    </div>
                    <h1 class="fw-bold display-5 mb-3" style="color: var(--c4);"><?php echo $articulo['titulo']; ?></h1>
                    <p class="lead text-muted" style="color: #6c868e; line-height: 1.8;"><?php echo $articulo['intro']; ?></p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-dark">
                    <h4 class="fw-bold mb-4" style="color: var(--c4);">Guía Detallada</h4>
                    
                    <ul class="list-unstyled mb-5">
                        <?php foreach($articulo['puntos_clave'] as $punto): ?>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <?php echo $punto; ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="article-content" style="color: #6c868e; line-height: 1.8;">
                        <?php echo $articulo['contenido_completo']; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>