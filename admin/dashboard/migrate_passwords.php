<?php
// Script para re-hashear contraseñas antiguas (MD5) a password_hash moderno (Argon2id si está disponible)
// Úsalo con precaución: ejecutar desde línea de comandos o protegido por acceso admin.

if (php_sapi_name() !== 'cli') {
    echo "Este script debe ejecutarse desde la línea de comandos por seguridad.\n";
    exit(1);
}

include __DIR__ . '/../../conexion.php';

// Obtener todos los usuarios
$res = mysqli_query($conexion, "SELECT ID, Clave FROM tb_usuarios");
if (!$res) {
    echo "Error al leer usuarios: " . mysqli_error($conexion) . "\n";
    exit(1);
}

$updated = 0;
$skipped = 0;
$preferredAlgo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
$options = [];
if ($preferredAlgo === PASSWORD_ARGON2ID) {
    $options = [
        'memory_cost' => 1<<17, // 128MB
        'time_cost'   => 4,
        'threads'     => 2,
    ];
}

while ($row = mysqli_fetch_assoc($res)) {
    $id = $row['ID'];
    $clave = $row['Clave'];

    // Detectar si es MD5 (32 hex chars)
    if (preg_match('/^[a-f0-9]{32}$/i', $clave)) {
        echo "Re-hasheando usuario: $id\n";
        // No podemos recuperar la contraseña original; esto solo sirve si guardaste MD5 de la contraseña
        // Por tanto, la única opción segura es forzar reseteo de contraseña por usuario.
        // Alternativa: si tienes la contraseña en texto plano en algún backup, úsala para rehasear.
        // Aquí marcamos para reseteo (ejemplo: establecer flag o enviar instrucciones).
        // Nota: No hay forma segura de convertir MD5->Argon2 sin conocer la contraseña original.

        // Marcar usuario para reset de contraseña (campo temporal 'needs_pw_reset' asumido)
        $q = "ALTER TABLE tb_usuarios ADD COLUMN IF NOT EXISTS needs_pw_reset TINYINT(1) DEFAULT 0";
        @mysqli_query($conexion, $q);
        $u = mysqli_prepare($conexion, "UPDATE tb_usuarios SET needs_pw_reset = 1 WHERE ID = ?");
        if ($u) {
            mysqli_stmt_bind_param($u, "s", $id);
            mysqli_stmt_execute($u);
            mysqli_stmt_close($u);
        }
        $updated++;
    } else {
        // Si ya es hash moderno (password_hash), lo saltamos
        $skipped++;
    }
}

echo "Terminó. Usuarios marcados para reset de contraseña: $updated. Saltados: $skipped\n";

?>
