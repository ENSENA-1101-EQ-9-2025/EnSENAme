<?php
session_start();

// Set admin session for testing
$_SESSION['id_usuario'] = 1;
$_SESSION['p_nombre'] = 'Admin';
$_SESSION['p_apellido'] = 'Test';
$_SESSION['id_rol'] = 1;

echo "<h2>Test Admin Functions</h2>";
echo "<h3>Testing navigation paths...</h3>";

$files_to_test = [
    'index.php' => 'Dashboard principal',
    'crear.php' => 'Crear usuario',
    'usuarios.php' => 'Gestión de usuarios',
    'producto.php' => 'Guías',
    'servicio.php' => 'Servicios',
    'asistente_virtual.php' => 'Asistente Virtual',
    'chatbot_stats.php' => 'Estadísticas IA'
];

foreach ($files_to_test as $file => $description) {
    if (file_exists($file)) {
        echo "<p>✅ {$description} ({$file}) - Archivo existe</p>";
    } else {
        echo "<p>❌ {$description} ({$file}) - Archivo NO encontrado</p>";
    }
}

echo "<h3>Testing API files...</h3>";

$api_files = [
    '../../chatbot_api.php' => 'Chatbot API (clean)',
    '../../info_sordos_api.php' => 'Info Sordos API'
];

foreach ($api_files as $file => $description) {
    if (file_exists($file)) {
        echo "<p>✅ {$description} - API disponible</p>";
    } else {
        echo "<p>❌ {$description} - API NO encontrada</p>";
    }
}

echo "<h3>Testing database connection...</h3>";
include "../../conexion.php";

if ($conexion) {
    echo "<p>✅ Conexión a base de datos exitosa</p>";
    
    // Test chatbot logs table
    $test_query = "SHOW TABLES LIKE 'tb_chatbot_logs'";
    $result = mysqli_query($conexion, $test_query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<p>✅ Tabla tb_chatbot_logs existe</p>";
    } else {
        echo "<p>❌ Tabla tb_chatbot_logs NO existe</p>";
    }
} else {
    echo "<p>❌ Error de conexión a base de datos</p>";
}

echo "<h3>Testing session data...</h3>";
echo "<p>Usuario ID: " . (isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 'No definido') . "</p>";
echo "<p>Nombre: " . (isset($_SESSION['p_nombre']) ? $_SESSION['p_nombre'] : 'No definido') . "</p>";
echo "<p>Rol: " . (isset($_SESSION['id_rol']) ? $_SESSION['id_rol'] : 'No definido') . "</p>";

echo "<h3>Enlaces de navegación:</h3>";
echo '<ul>';
echo '<li><a href="asistente_virtual.php">Asistente Virtual</a></li>';
echo '<li><a href="chatbot_stats.php">Estadísticas del Chatbot</a></li>';
echo '<li><a href="../../IA/index.php" target="_blank">Sistema IA</a></li>';
echo '</ul>';

echo "<p style='margin-top: 20px;'><strong>Prueba completada.</strong></p>";
?>