// Obtener lista de usuarios (ID y nombre)
function obtenerUsuarios() {
    global $conexion;
    $res = mysqli_query($conexion, "SELECT ID, p_nombre, p_apellido FROM tb_usuarios");
    $usuarios = [];
    while($row = mysqli_fetch_assoc($res)) {
        $usuarios[] = $row;
    }
    return $usuarios;
}

// Anti-spam: verificar si el usuario envió un mensaje en los últimos 5 segundos
function puedeEnviarMensaje($de) {
    global $conexion;
    $de = intval($de);
    $sql = "SELECT fecha FROM tb_mensajes WHERE de_usuario=$de ORDER BY fecha DESC LIMIT 1";
    $res = mysqli_query($conexion, $sql);
    if($row = mysqli_fetch_assoc($res)) {
        $ultima = strtotime($row['fecha']);
        return (time() - $ultima) > 5; // 5 segundos entre mensajes
    }
    return true;
}
// --- CHAT PRIVADO ENTRE USUARIOS ---
// Requiere la tabla tb_mensajes (ver instrucciones abajo)
include_once "conexion.php";

// Guardar mensaje privado
function guardarMensaje($de, $para, $mensaje) {
    global $conexion;
    $de = intval($de);
    $para = intval($para);
    $mensaje = mysqli_real_escape_string($conexion, $mensaje);
    $sql = "INSERT INTO tb_mensajes (de_usuario, para_usuario, mensaje, fecha) VALUES ($de, $para, '$mensaje', NOW())";
    return mysqli_query($conexion, $sql);
}

// Obtener mensajes entre dos usuarios (ordenados por fecha)
function obtenerMensajes($de, $para) {
    global $conexion;
    $de = intval($de);
    $para = intval($para);
    $sql = "SELECT * FROM tb_mensajes WHERE (de_usuario=$de AND para_usuario=$para) OR (de_usuario=$para AND para_usuario=$de) ORDER BY fecha ASC";
    $res = mysqli_query($conexion, $sql);
    $mensajes = [];
    while($row = mysqli_fetch_assoc($res)) {
        $mensajes[] = $row;
    }
    return $mensajes;
}

// --- INSTRUCCIONES PARA CREAR LA TABLA EN TU LOCALHOST ---
// Ejecuta este SQL en phpMyAdmin o consola MySQL:
/*
CREATE TABLE tb_mensajes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  de_usuario INT NOT NULL,
  para_usuario INT NOT NULL,
  mensaje TEXT NOT NULL,
  fecha DATETIME NOT NULL,
  FOREIGN KEY (de_usuario) REFERENCES tb_usuarios(ID),
  FOREIGN KEY (para_usuario) REFERENCES tb_usuarios(ID)
);
*/
<?php
if(isset($_POST["btn_registrar"])){
    include "conexion.php";
    $clave=$_POST['clave'];
    $clave2=$_POST['confirmarClave'];
    if($clave==$clave2){
        $pass=md5($clave);
        $tipoDocumento    = $_POST['tipoDocumento'];
        $numeroDocumento  = $_POST['numeroDocumento'];
        $primerNombre    = $_POST['primerNombre'];
        $segundoNombre    = $_POST['segundoNombre'];
        $primerApellido  = $_POST['primerApellido'];
        $segundoApellido = $_POST['segundoApellido'];
        $idrol = $_POST['idrol'];


        $registrar= mysqli_query($conexion,"INSERT INTO `tb_usuarios` (`ID`, `Tipo_Documento`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `Clave`, `id_rol`) 
        VALUES ('$numeroDocumento', '$tipoDocumento', '$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$pass', '$idrol');");

        if($registrar){
            echo "usuario registrado con exito";
            echo "<script>window.location='login.php';</script>";
            
        }else{
            echo "error en registrar";
        }
    }
}else{
    echo"<script>window.location='error.php'</script>";
    echo "<script>alert('error')</script>";
}
?>