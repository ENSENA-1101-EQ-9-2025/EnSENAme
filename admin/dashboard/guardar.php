<?php
session_start();
// Incluir la conexión a la base de datos
include '../../conexion.php'; // O la ruta correcta según tu estructura

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $tipoDocumento    = $_POST['tipoDocumento'];
    $numeroDocumento  = $_POST['numeroDocumento'];
    $primerNombre     = $_POST['primerNombre'];
    $segundoNombre    = $_POST['segundoNombre'];
    $primerApellido   = $_POST['primerApellido'];
    $segundoApellido  = $_POST['segundoApellido'];
    $clave            = $_POST['clave'];
    $rol              = $_POST['idrol'];

    // Realizar la inserción de datos
    $sql = "INSERT INTO usuarios (tipo_documento, numero_documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, clave, rol)
            VALUES ('$tipoDocumento', '$numeroDocumento', '$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$clave', '$rol')";

    if (mysqli_query($conexion, $sql)) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
