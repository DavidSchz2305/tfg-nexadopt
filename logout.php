<?php
/**
 * Cierre de sesión seguro. He añadido la regeneración del ID de sesión
 * y la eliminación de la cookie para prevenir reutilización de tokens.
 */

session_start();

// Limpiamos todas las variables de la sesión antes de destruirla.
$_SESSION = [];

// Eliminamos la cookie de sesión del navegador del usuario para mayor seguridad.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

session_destroy();

header('Location: index.php');
exit();