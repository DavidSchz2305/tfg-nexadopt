<?php
session_start();
// Si no hay sesión o el rol no es 1 (Admin), le saca
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}
require_once '../config/conexion.php';
?>