<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/conexion.php';
include 'includes/header.php';

$articulos = [
    [
        "id" => 1,
        "categoria" => "Perros",
        "color_cat" => "var(--c4)", 
        "titulo" => "Cómo presentar a tu perro actual a un nuevo cachorro",
        "descripcion" => "Aprende las mejores prácticas para introducir un nuevo miembro a la familia sin generar estrés ni conflictos en casa."
    ],
    [
        "id" => 2,
        "categoria" => "Gatos",
        "color_cat" => "#ff9800", 
        "titulo" => "El lenguaje corporal de los gatos: qué te están diciendo",
        "descripcion" => "Descubre cómo interpretar los movimientos de la cola, orejas y bigotes de tu felino para entender sus emociones."
    ],
    [
        "id" => 3,
        "categoria" => "Salud",
        "color_cat" => "var(--c5)", 
        "titulo" => "Calendario de vacunas esencial para tu mascota",
        "descripcion" => "Conoce las vacunas obligatorias y recomendadas para mantener a tu perro o gato protegido contra enfermedades comunes."
    ],
    [
        "id" => 4,
        "categoria" => "General",
        "color_cat" => "#4caf50", 
        "titulo" => "Preparando tu casa para la llegada de un animal",
        "descripcion" => "Aprende a eliminar peligros y crear un espacio seguro y acogedor antes de traer a tu nuevo mejor amigo a casa."
    ],
    [
        "id" => 5,
        "categoria" => "Alimentación",
        "color_cat" => "#9c27b0", 
        "titulo" => "Alimentos prohibidos que nunca debes dar a tu perro",
        "descripcion" => "Una guía completa sobre los alimentos de consumo humano que son tóxicos y peligrosos para el sistema digestivo canino."
    ],
    [
        "id" => 6,
        "categoria" => "Perros",
        "color_cat" => "var(--c4)", 
        "titulo" => "Cómo enseñar a tu perro a pasear sin tirar de la correa",
        "descripcion" => "Técnicas de adiestramiento en positivo para disfrutar de paseos relajados y seguros junto a tu mascota."
    ]
];
?>

<main class="site-main py-5" style="background-color: var(--c1);">
    <div class="container py-4">
        
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h1 class="fw-bold display-5 mb-3" style="color: var(--c4);">Consejos y recursos</h1>
                <p class="lead mb-4" style="color: #6c868e;">Descubre nuestras guías, trucos y mejores prácticas para asegurar el bienestar y la felicidad de tu compañero de cuatro patas.</p>
                <hr class="mx-auto opacity-100" style="width: 60px; border-top: 3px solid var(--c5);">
            </div>
        </div>

        <div class="row g-4 mb-5">
            <?php foreach($articulos as $articulo): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 consejo-card bg-white d-flex flex-column text-start">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge rounded-pill fw-bold border" style="color: <?php echo $articulo['color_cat']; ?>; border-color: <?php echo $articulo['color_cat']; ?> !important; background-color: transparent;">
                            <?php echo $articulo['categoria']; ?>
                        </span>
                        <a href="pages/articulo_detalle.php?id=<?php echo $articulo['id']; ?>" class="btn btn-outline-brand btn-sm rounded-pill fw-bold" style="border-color: var(--c4); color: var(--c4);">
                            Leer más <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <h5 class="fw-bold mb-3" style="color: var(--c4);"><?php echo $articulo['titulo']; ?></h5>
                    <p class="text-muted small flex-grow-1" style="line-height: 1.6;">
                        <?php echo $articulo['descripcion']; ?>
                    </p>
                    
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="p-5 rounded-4 shadow-sm text-center bg-white" style="border: 1px solid var(--c2);">
                    <h3 class="fw-bold mb-3" style="color: var(--c4);">¿No encontraste lo que buscabas?</h3>
                    <p class="text-muted mb-4">Nuestro equipo de expertos y veterinarios voluntarios está aquí para ayudarte con cualquier duda específica que tengas sobre tu mascota.</p>
                    <a href="contacto.php" class="btn fw-bold rounded-pill px-5 py-3 text-white shadow-sm btn-contacto-cta" style="background-color: var(--c5);">
                        <i class="fas fa-envelope me-2"></i> Contacta con nosotros
                    </a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>