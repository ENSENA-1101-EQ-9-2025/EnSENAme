<?php
// Ejecutar desde CLI: php create_needs_pw_change.php
include __DIR__ . '/../../conexion.php';

$col_check = mysqli_query($conexion, "SHOW COLUMNS FROM tb_usuarios LIKE 'needs_pw_change'");
if ($col_check && mysqli_num_rows($col_check) > 0) {
    echo "La columna needs_pw_change ya existe.\n";
    exit(0);
}

if (mysqli_query($conexion, "ALTER TABLE tb_usuarios ADD needs_pw_change TINYINT(1) DEFAULT 0")) {
    echo "Columna needs_pw_change creada correctamente.\n";
    exit(0);
} else {
    echo "Error al crear columna: " . mysqli_error($conexion) . "\n";
    exit(1);
}
?>