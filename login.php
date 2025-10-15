<?php
session_start();
include "conexion.php"; // Archivo con la conexión $conexion

if(isset($_POST['btningresar'])){

    $numeroDocumento = isset($_POST['txtdoc']) ? trim($_POST['txtdoc']) : '';
    $clave = isset($_POST['txtpass']) ? $_POST['txtpass'] : '';

    // Preparar consulta para obtener el usuario por ID
    $query = "SELECT * FROM tb_usuarios WHERE ID = ? LIMIT 1";
    if ($stmt = mysqli_prepare($conexion, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $numeroDocumento);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $storedHash = $row['Clave'];

            // Seleccionar algoritmo preferente (Argon2id si existe)
            $preferredAlgo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;

            $ok = false;

            // Primero intentamos password_verify (hash moderno)
            if (password_verify($clave, $storedHash)) {
                $ok = true;
            } else {
                // Soporte para hashes antiguos con MD5: si coinciden, re-hashear con algoritmo moderno
                if ($storedHash === md5($clave)) {
                    $ok = true;
                    // Re-hashear y actualizar la base de datos
                    $newHash = password_hash($clave, $preferredAlgo);
                    $updateQ = "UPDATE tb_usuarios SET Clave = ? WHERE ID = ?";
                    if ($uStmt = mysqli_prepare($conexion, $updateQ)) {
                        mysqli_stmt_bind_param($uStmt, "ss", $newHash, $numeroDocumento);
                        mysqli_stmt_execute($uStmt);
                        mysqli_stmt_close($uStmt);
                    }
                }
            }

            if ($ok) {
                // Política mínima de contraseña (coincide con register.php)
                function password_meets_policy($pw) {
                  if (!is_string($pw)) return false;
                  if (strlen($pw) < 10) return false;
                  if (!preg_match('/[A-Z]/', $pw)) return false;
                  if (!preg_match('/[a-z]/', $pw)) return false;
                  if (!preg_match('/[0-9]/', $pw)) return false;
                    if (!preg_match('/[!@#\$%\^&\*\(\)_\+\-=\[\]{};:"\'|,.<>\/\?]/', $pw)) return false;
                  return true;
                }

                // Si la contraseña no cumple la política, marcar para cambiar y redirigir
                if (!password_meets_policy($clave)) {
                  // Intentar añadir columna needs_pw_change (si no existe)
                  try {
                    $col_check = mysqli_query($conexion, "SHOW COLUMNS FROM tb_usuarios LIKE 'needs_pw_change'");
                    if (!$col_check || mysqli_num_rows($col_check) == 0) {
                      mysqli_query($conexion, "ALTER TABLE tb_usuarios ADD needs_pw_change TINYINT(1) DEFAULT 0");
                    }
                  } catch (mysqli_sql_exception $e) {
                    // Si hay un error (por ejemplo permisos), lo ignoramos; no debe bloquear el login
                  }
                  // Marcar en la base de datos
                  $uq = "UPDATE tb_usuarios SET needs_pw_change = 1 WHERE ID = ?";
                  if ($uStmt2 = mysqli_prepare($conexion, $uq)) {
                    mysqli_stmt_bind_param($uStmt2, "s", $numeroDocumento);
                    mysqli_stmt_execute($uStmt2);
                    mysqli_stmt_close($uStmt2);
                  }
                  // Forzar cambio en la sesión y redirigir al formulario
                  $_SESSION['force_pw_change'] = true;
                  // Set minimal session info so change_password.php can validate the user
                  $_SESSION['txtdoc'] = $numeroDocumento;
                  $_SESSION['id_usuario'] = $row['ID'];
                  $_SESSION['primer_nombre'] = $row['p_nombre'];
                  $_SESSION['segundo_nombre'] = $row['s_nombre'];
                  $_SESSION['primer_apellido'] = $row['p_apellido'];
                  $_SESSION['segundo_apellido'] = $row['s_apellido'];
                  // Compose a display name for UI
                  $parts = array_filter(array($row['p_nombre'], $row['s_nombre'], $row['p_apellido'], $row['s_apellido']));
                  $_SESSION['display_name'] = implode(' ', $parts);
                  $_SESSION['id_rol'] = $row['id_rol'];
                  // Redirect to an absolute path for change password page
                  header("Location: /enseñame/EnSENAme/admin/dashboard/change_password.php");
                  exit();
                }
                // Setear sesión y redirigir según rol
                $_SESSION['txtdoc'] = $numeroDocumento;
                $_SESSION['id_usuario'] = $row['ID'];
                $_SESSION['primer_nombre'] = $row['p_nombre'];
                $_SESSION['segundo_nombre'] = $row['s_nombre'];
                $_SESSION['primer_apellido'] = $row['p_apellido'];
                $_SESSION['segundo_apellido'] = $row['s_apellido'];
                // Compose a display name for UI
                $parts = array_filter(array($row['p_nombre'], $row['s_nombre'], $row['p_apellido'], $row['s_apellido']));
                $_SESSION['display_name'] = implode(' ', $parts);
                $_SESSION['id_rol'] = $row['id_rol'];

                $base = '/enseñame/EnSENAme';
                if($row['id_rol'] == 1){
                  header("Location: " . $base . "/admin/dashboard/index.php");
                  exit();
                } else {
                  header("Location: " . $base . "/user/index.php");
                  exit();
                }
            } else {
                $message = "Documento o contraseña incorrectos";
            }
        } else {
            $message = "Documento o contraseña incorrectos";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Error en la consulta a la base de datos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="admin/assets/images/favisena.png" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="admin/assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="admin/assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="admin/assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="admin/assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="admin/assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="admin/assets/css/style-preset.css" >
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>  
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">    
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 shadow">
          <a href="index.php"><img src="admin/assets/images/logoensenamenobg.png" alt="img"></a>
        </nav>
        <div class="card my-5">
          <div class="card-body">
          <?php if (!empty($message)): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>
          <form method="post" action="">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><b>Iniciar Sesión</b></h3>
              <a href="register.php" class="link-primary">No tienes Cuenta?</a>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Documento de Usuario</label>
              <input type="text" name="txtdoc" class="form-control" placeholder="Ingrese el documento de Usuario" required>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Contraseña</label>
              <input type="password" name="txtpass" placeholder="Ingrese la clave" class="form-control" Required>
            </div>
            <div class="d-flex mt-1 justify-content-between">
              <div class="form-check">
                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                <label class="form-check-label text-muted" for="customCheckc1">Mantenerme conectado</label>
              </div>              
            </div>
            <div class="d-grid mt-4">
              <button type="submit" name="btningresar" class="btn btn-primary">Iniciar Sesión</button>
            </div>
          </form>           
          </div>
        </div>
        <div class="auth-footer row">           
      
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="admin/assets/js/plugins/popper.min.js"></script>
  <script src="admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="admin/assets/js/plugins/bootstrap.min.js"></script>
  <script src="admin/assets/js/fonts/custom-font.js"></script>
  <script src="admin/assets/js/pcoded.js"></script>
  <script src="admin/assets/js/plugins/feather.min.js"></script>

  
  
  
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
  <style>
    .navbar {
      width: 100%;
      border-bottom: 1px solid #eee; /* línea sutil abajo */
    }
  </style>
</body>
<!-- [Body] end -->
</html>
