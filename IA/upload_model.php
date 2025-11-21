<?php
// Uso CLI: php upload_model.php "../base de datos/datos_entrenamiento_senas (3).json"
// También puede llamarse por POST (campo 'file_path') desde web (asegúrate de permisos y seguridad).

require_once __DIR__ . '/../conexion.php';

$path = null;
if (php_sapi_name() === 'cli') {
    $path = $argv[1] ?? null;
} else {
    // desde web
    $path = $_POST['file_path'] ?? null;
}

if (!$path) {
    fwrite(STDERR, "Usage (CLI): php upload_model.php \"/ruta/al/archivo.json\"\n");
    http_response_code(400);
    echo json_encode(['error' => 'Falta ruta del archivo']);
    exit(1);
}

// Normalizar ruta relativa desde el directorio del script
$full = $path;
if (!file_exists($full)) {
    // Intentar ruta relativa al repo
    $full = __DIR__ . '/../' . $path;
}
if (!file_exists($full)) {
    fwrite(STDERR, "Archivo no encontrado: $path\n");
    http_response_code(404);
    echo json_encode(['error' => 'Archivo no encontrado', 'path' => $path]);
    exit(1);
}

$json = file_get_contents($full);
if ($json === false) {
    fwrite(STDERR, "Error leyendo archivo: $full\n");
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo leer el archivo']);
    exit(1);
}

// Validar JSON (rápido)
if (null === json_decode($json)) {
    fwrite(STDERR, "JSON inválido en archivo: $full\n");
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit(1);
}

// Actualizar o insertar la fila id=1
$id = 1;
$stmt = $conexion->prepare('SELECT COUNT(1) FROM tb_models WHERE id = ?');
if (!$stmt) { die(json_encode(['error' => 'Error preparar SELECT'])); }
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    $stmt = $conexion->prepare('UPDATE tb_models SET model_json = ?, name = ? WHERE id = ?');
    $name = basename($full);
    $stmt->bind_param('ssi', $json, $name, $id);
    if ($stmt->execute()) {
        echo json_encode(['ok' => true, 'msg' => 'Modelo actualizado', 'id' => $id]);
        exit(0);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al actualizar', 'detail' => $stmt->error]);
        exit(1);
    }
} else {
    $stmt = $conexion->prepare('INSERT INTO tb_models (id, name, model_json) VALUES (?, ?, ?)');
    $name = basename($full);
    $stmt->bind_param('iss', $id, $name, $json);
    if ($stmt->execute()) {
        echo json_encode(['ok' => true, 'msg' => 'Modelo insertado', 'id' => $id]);
        exit(0);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al insertar', 'detail' => $stmt->error]);
        exit(1);
    }
}
?>