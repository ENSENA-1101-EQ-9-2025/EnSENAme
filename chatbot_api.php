<?php
// chatbot_api.php (DEPRECATED)
// Endpoint unificado: use chatbot_api_clean.php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

http_response_code(410); // Gone
echo json_encode([
    'success' => false,
    'error' => 'Este endpoint fue unificado. Usa /chatbot_api_clean.php para POST {"mensaje":...} y las rutas nuevas del chatbot.',
    'endpoint_unificado' => 'chatbot_api_clean.php'
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

exit;

?>