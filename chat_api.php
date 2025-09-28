<?php
session_start();
include_once "conexion.php";
include_once "codigo.php";
header('Content-Type: application/json');

// Debes tener el ID del usuario logueado en $_SESSION['txtdoc']
$usuarioActual = isset($_SESSION['txtdoc']) ? intval($_SESSION['txtdoc']) : 0;


// El ID del usuario destino debe enviarse por POST o GET
$usuarioDestino = isset($_POST['para']) ? intval($_POST['para']) : (isset($_GET['para']) ? intval($_GET['para']) : 0);


// Obtener lista de usuarios
if (isset($_GET['get_users'])) {
    $usuarios = obtenerUsuarios();
    echo json_encode($usuarios);
    exit;
}

// Verificar si el usuario destino existe
if (isset($_GET['check_user']) && $usuarioDestino) {
    $res = mysqli_query($conexion, "SELECT ID FROM tb_usuarios WHERE ID = $usuarioDestino LIMIT 1");
    echo json_encode(["exists" => mysqli_num_rows($res) > 0]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Enviar mensaje
    $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';
    if ($usuarioActual && $usuarioDestino && $mensaje) {
        // Anti-spam: no permitir enviar si fue enviado hace menos de 5 segundos
        if (!puedeEnviarMensaje($usuarioActual)) {
            echo json_encode(["success" => false, "error" => "No puedes enviar mensajes tan rápido. Espera unos segundos."]);
            exit;
        }
        // Etiqueta admin si el usuario actual es admin
        $isAdmin = false;
        $res = mysqli_query($conexion, "SELECT id_rol FROM tb_usuarios WHERE ID = $usuarioActual LIMIT 1");
        if ($row = mysqli_fetch_assoc($res)) {
            $isAdmin = ($row['id_rol'] == 1);
        }
        if ($isAdmin) {
            $mensaje = '[Admin] ' . $mensaje;
        }
        guardarMensaje($usuarioActual, $usuarioDestino, $mensaje);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Datos incompletos"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener mensajes
    if ($usuarioActual && $usuarioDestino) {
        $mensajes = obtenerMensajes($usuarioActual, $usuarioDestino);
        echo json_encode($mensajes);
    } else {
        echo json_encode([]);
    }
    exit;
}

// Si no es GET ni POST
http_response_code(405);
echo json_encode(["error" => "Método no permitido"]);
