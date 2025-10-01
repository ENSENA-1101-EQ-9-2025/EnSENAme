<?php
session_start();
// Conexión a la base de datos
include "../../conexion.php";

// Verificar si se pasa el ID del usuario por GET
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Consulta para obtener los datos del usuario por ID
    $query = "SELECT * FROM tb_usuarios WHERE ID = '$userID'";
    $result = mysqli_query($conexion, $query);

    // Verificar si el usuario existe
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de usuario no proporcionado'); window.location='index.php';</script>";
    exit();
}

// Verificar si se ha enviado el formulario de edición
if (isset($_POST['btn_editar'])) {
    // Obtener los datos del formulario
    $clave = $_POST['clave'];
    $clave2 = $_POST['confirmarClave'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $primerNombre = $_POST['primerNombre'];
    $segundoNombre = $_POST['segundoNombre'];
    $primerApellido = $_POST['primerApellido'];
    $segundoApellido = $_POST['segundoApellido'];
    $idrol = $_POST['idrol'];

    // Verificar si las contraseñas coinciden
    if ($clave !== $clave2) {
        echo "<script>alert('Las contraseñas no coinciden');</script>";
    } else {
        // Encriptar la nueva contraseña
        $pass = password_hash($clave, PASSWORD_DEFAULT);

        // Actualizar los datos en la base de datos
        $update_query = "UPDATE tb_usuarios SET 
                         Tipo_Documento = '$tipoDocumento', 
                         p_nombre = '$primerNombre', 
                         s_nombre = '$segundoNombre', 
                         p_apellido = '$primerApellido', 
                         s_apellido = '$segundoApellido', 
                         Clave = '$pass', 
                         id_rol = '$idrol' 
                         WHERE ID = '$userID'";

        if (mysqli_query($conexion, $update_query)) {
            echo "<script>alert('Usuario actualizado correctamente'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el usuario');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="../assets/css/style-preset.css">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Editar Usuario</h2>

    <!-- Formulario para editar usuario -->
    <form method="POST">
        <div class="mb-3">
            <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
            <input type="text" class="form-control" id="tipoDocumento" name="tipoDocumento" value="<?= $user['Tipo_Documento'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="numeroDocumento" class="form-label">Número de Documento</label>
            <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" value="<?= $user['ID'] ?>" readonly required>
        </div>

        <div class="mb-3">
            <label for="primerNombre" class="form-label">Primer Nombre</label>
            <input type="text" class="form-control" id="primerNombre" name="primerNombre" value="<?= $user['p_nombre'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="segundoNombre" class="form-label">Segundo Nombre</label>
            <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" value="<?= $user['s_nombre'] ?>">
        </div>

        <div class="mb-3">
            <label for="primerApellido" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" id="primerApellido" name="primerApellido" value="<?= $user['p_apellido'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="segundoApellido" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" value="<?= $user['s_apellido'] ?>">
        </div>

        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
        </div>

        <div class="mb-3">
            <label for="confirmarClave" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="confirmarClave" name="confirmarClave" required>
        </div>

        <div class="mb-3">
            <label for="idrol" class="form-label">Rol</label>
            <input type="number" class="form-control" id="idrol" name="idrol" value="<?= $user['id_rol'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="btn_editar">Guardar Cambios</button>
    </form>
</div>

<script src="../assets/js/plugins/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>
