<?php
// Endpoint sencillo para devolver un modelo JSON almacenado en la BD
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$stmt = $conexion->prepare('SELECT model_json FROM tb_models WHERE id = ? LIMIT 1');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la consulta preparar']);
    exit;
}
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($model_json);
if ($stmt->fetch()) {
    // Devolver el JSON tal cual (asumimos que model_json es JSON válido)
    echo $model_json;
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Modelo no encontrado']);
}
$stmt->close();
?>