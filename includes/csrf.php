<?php
/**
 * Módulo de seguridad CSRF (Cross-Site Request Forgery) — NexAdopt
 *
 * Centraliza la generación y validación de tokens de seguridad para proteger
 * todos los formularios POST de la plataforma contra ataques CSRF.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Genera un token CSRF criptográficamente seguro y lo almacena en sesión.
 *
 * Utiliza random_bytes(32) para obtener 256 bits de entropía criptográfica
 * (CSPRNG del sistema operativo), y bin2hex() para convertirlo a una cadena
 * hexadecimal de 64 caracteres segura para incluir en atributos HTML.
 *
 * Si ya existe un token en la sesión actual lo reutiliza, evitando así
 * invalidar formularios que el usuario pueda tener abiertos en varias pestañas.
 *
 * @return string Token en formato hexadecimal (64 caracteres).
 */
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida que el token recibido en el formulario coincida con el de la sesión.
 *
 * Usa hash_equals() en lugar del operador === para prevenir ataques de
 * temporización (timing attacks): en una comparación carácter a carácter,
 * el tiempo de respuesta varía según cuántos caracteres coinciden antes
 * del primer fallo, lo que permitiría a un atacante deducir el token
 * midiendo tiempos. hash_equals() tiene tiempo de ejecución constante
 * independientemente del punto de divergencia entre las cadenas.
 *
 * @param  string $token  Token recibido vía POST ($_POST['csrf_token']).
 * @return bool           true si el token es válido; false si falta o no coincide.
 */
function validateCsrfToken(string $token): bool
{
    return !empty($_SESSION['csrf_token'])
        && !empty($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}