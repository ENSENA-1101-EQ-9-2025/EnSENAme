<?php
session_start();
// Conexión a la base de datos
include "../../conexion.php";

// Verificar si se pasa el ID del usuario por GET
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Consulta para eliminar el usuario de la base de datos
    $delete_query = "DELETE FROM tb_usuarios WHERE ID = '$userID'";

    if (mysqli_query($conexion, $delete_query)) {
        echo "<script>alert('Usuario eliminado correctamente'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('ID de usuario no proporcionado'); window.location='index.php';</script>";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
