<?php
session_start();
if (isset($_POST["btn_registrar"])) {
    include "../../conexion.php"; // Incluye el archivo de conexión

    // Capturar los datos del formulario
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
        echo "<script>
                alert('Las contraseñas no coinciden.');
                window.location='crear.php';
              </script>";
        exit();
    }

    // Encriptar la contraseña con password_hash (más seguro que md5)
    $pass = password_hash($clave, PASSWORD_DEFAULT);

    // Verificar si el número de documento ya existe (uso de consulta preparada)
    $check_query = "SELECT * FROM tb_usuarios WHERE ID = ?";
    if ($stmt = mysqli_prepare($conexion, $check_query)) {
        mysqli_stmt_bind_param($stmt, "s", $numeroDocumento);  // "s" indica que es un string
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Si el número de documento ya existe, mostrar el popup
            echo "<script>
                    alert('El usuario con este número de documento ya está registrado en el sistema.');
                    window.location='crear.php'; // Redirigir de nuevo a la página de registro
                  </script>";
            exit();
        }
        mysqli_stmt_close($stmt); // Cerrar el statement
    } else {
        // Si hubo un error al preparar la consulta
        echo "<script>
                alert('Error al verificar el documento.');
                window.location='crear.php';
              </script>";
        exit();
    }

    // Si el número de documento no está registrado, proceder a insertar el nuevo usuario
    // Ahora insertamos el número de documento como ID
    $registrar_query = "INSERT INTO `tb_usuarios` (`ID`, `Tipo_Documento`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `Clave`, `id_rol`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conexion, $registrar_query)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $numeroDocumento, $tipoDocumento, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $pass, $idrol);
        $insert_result = mysqli_stmt_execute($stmt);

        if ($insert_result) {
            echo "<script>
                    alert('Usuario registrado correctamente.');
                    window.location='crear.php'; // Redirigir al formulario después de un registro exitoso
                  </script>";
        } else {
            echo "<script>
                    alert('Hubo un error al registrar al usuario.');
                    window.location='crear.php';
                  </script>";
        }
        mysqli_stmt_close($stmt); // Cerrar el statement
    } else {
        // Si hubo un error al preparar la consulta
        echo "<script>
                alert('Error al intentar registrar el usuario.');
                window.location='crear.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Error en el envío del formulario.');
            window.location='crear.php';
          </script>";
}
?>


