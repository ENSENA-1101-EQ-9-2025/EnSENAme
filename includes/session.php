<?php
// Central session include: asegura session_start() y construye display_name si falta.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Si ya existe, nada más que hacer
if (!empty($_SESSION['display_name'])) {
    return;
}

// Preferir valores ya cargados en sesión
$parts = [];
if (!empty($_SESSION['primer_nombre'])) $parts[] = trim($_SESSION['primer_nombre']);
if (!empty($_SESSION['segundo_nombre'])) $parts[] = trim($_SESSION['segundo_nombre']);
if (!empty($_SESSION['primer_apellido'])) $parts[] = trim($_SESSION['primer_apellido']);
if (!empty($_SESSION['segundo_apellido'])) $parts[] = trim($_SESSION['segundo_apellido']);

if (!empty($parts)) {
    $_SESSION['display_name'] = implode(' ', $parts);
    return;
}

// Si no hay partes en sesión, intentar obtener desde la BD si existe $conexion y txtdoc
if (!empty($_SESSION['txtdoc']) && isset($conexion) && mysqli_ping($conexion)) {
    $doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
    $res = mysqli_query($conexion, "SELECT p_nombre, s_nombre, p_apellido, s_apellido FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
    if ($res && ($row = mysqli_fetch_assoc($res))) {
        $parts = array_filter([trim($row['p_nombre'] ?? ''), trim($row['s_nombre'] ?? ''), trim($row['p_apellido'] ?? ''), trim($row['s_apellido'] ?? '')]);
        if (!empty($parts)) {
            $_SESSION['display_name'] = implode(' ', $parts);
            // Also populate individual session fields for compatibility
            if (empty($_SESSION['primer_nombre']) && !empty($row['p_nombre'])) $_SESSION['primer_nombre'] = $row['p_nombre'];
            if (empty($_SESSION['segundo_nombre']) && !empty($row['s_nombre'])) $_SESSION['segundo_nombre'] = $row['s_nombre'];
            if (empty($_SESSION['primer_apellido']) && !empty($row['p_apellido'])) $_SESSION['primer_apellido'] = $row['p_apellido'];
            if (empty($_SESSION['segundo_apellido']) && !empty($row['s_apellido'])) $_SESSION['segundo_apellido'] = $row['s_apellido'];
        }
    }
}

// Fallback to generic label
if (empty($_SESSION['display_name'])) {
    $_SESSION['display_name'] = 'Usuario';
}
