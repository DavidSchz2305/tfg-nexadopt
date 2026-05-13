<?php
/**
 * He migrado toda la capa de acceso a datos de mysqli a PDO (PHP Data Objects).
 * Esta decisión técnica se justifica en la memoria (sección 10.2) por las ventajas
 * que ofrece PDO en seguridad, flexibilidad y uso de sentencias preparadas nativas.
 */

// --- Parámetros de conexión ---
define('DB_HOST',    'localhost');
define('DB_NAME',    'bd_nexadopt');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    DB_HOST,
    DB_NAME,
    DB_CHARSET
);

// Configuramos PDO con tres opciones clave para seguridad y rendimiento:
// 1. ERRMODE_EXCEPTION -> cualquier error SQL lanzará una PDOException capturarble con try-catch.
// 2. FETCH_ASSOC -> los resultados vendrán como arrays asociativos por defecto.
// 3. EMULATE_PREPARES => false -> forzamos sentencias preparadas nativas en el motor MySQL,
//    lo que añade una capa de protección real contra inyecciones SQL.
$opciones_pdo = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conexion = new PDO($dsn, DB_USER, DB_PASS, $opciones_pdo);
} catch (PDOException $e) {
    // Si la conexión falla, registramos el error real en el log del servidor
    // pero NUNCA lo mostramos al usuario final, para no exponer información sensible.
    error_log('[NexAdopt - DB Error] ' . $e->getMessage());
    http_response_code(503);
    die('
        <style>body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f8f4ee;}</style>
        <div style="text-align:center;color:#4a5d63;">
            <h2>Servicio temporalmente no disponible</h2>
            <p>No hemos podido conectar con la base de datos. Por favor, inténtalo de nuevo en unos minutos.</p>
        </div>
    ');
}