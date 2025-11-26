<?php
session_start();
include "conexion.php"; // Archivo con la conexión $conexion

// Variables para mensajes de error específicos
$message = '';
$message_type = '';

// Sistema de límite de intentos fallidos
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = 0;
}

// Limpiar intentos después de 15 minutos
if (time() - $_SESSION['last_attempt_time'] > 900) { // 15 minutos
    $_SESSION['login_attempts'] = 0;
}

// Verificar si está bloqueado por muchos intentos
$max_attempts = 5;
$block_time = 900; // 15 minutos

if ($_SESSION['login_attempts'] >= $max_attempts) {
    $time_remaining = $block_time - (time() - $_SESSION['last_attempt_time']);
    if ($time_remaining > 0) {
        $minutes_remaining = ceil($time_remaining / 60);
        $message = "Demasiados intentos fallidos. Por favor, espere $minutes_remaining minutos antes de intentar nuevamente.";
        $message_type = "danger";
    } else {
        $_SESSION['login_attempts'] = 0;
    }
}

// Debug: Mostrar todos los POST recibidos
if (!empty($_POST)) {
    error_log("DEBUG: POST recibido: " . print_r($_POST, true));
}

// Manejo de solicitud de contraseña temporal
if(isset($_POST['solicitar_temp_password'])) {
    error_log("DEBUG: Solicitud de contraseña temporal recibida"); // Debug temporal
    $numeroDocumento = isset($_POST['doc_temp']) ? trim($_POST['doc_temp']) : '';
    
    if(empty($numeroDocumento)) {
        $message = "Por favor, ingrese su número de documento.";
        $message_type = "warning";
    } elseif(!is_numeric($numeroDocumento)) {
        $message = "El número de documento debe contener solo números.";
        $message_type = "warning";
    } else {
        // Verificar si el usuario existe
        $query = "SELECT ID, p_nombre, p_apellido FROM tb_usuarios WHERE ID = ? LIMIT 1";
        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $numeroDocumento);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Generar contraseña temporal segura
                $tempPassword = generarPasswordTemporal();
                
                // Hashear la contraseña temporal
                $preferredAlgo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
                $newHash = password_hash($tempPassword, $preferredAlgo);
                
                // Actualizar la contraseña y marcar para cambio obligatorio
                $updateQ = "UPDATE tb_usuarios SET Clave = ?, needs_pw_change = 1 WHERE ID = ?";
                if ($updateStmt = mysqli_prepare($conexion, $updateQ)) {
                    mysqli_stmt_bind_param($updateStmt, "ss", $newHash, $numeroDocumento);
                    if (mysqli_stmt_execute($updateStmt)) {
                        $message = "
                        <div class='mb-3'>
                            <strong><i class='ti ti-check-circle me-2'></i>¡Contraseña temporal generada exitosamente!</strong>
                        </div>
                        <div class='temp-password-display'>
                            <strong id='tempPasswordText'>$tempPassword</strong>
                            <div class='mt-2'>
                                <button type='button' class='btn btn-sm btn-outline-primary' onclick='copyTempPassword()'>
                                    <i class='ti ti-copy me-1'></i>Copiar Contraseña
                                </button>
                            </div>
                        </div>
                        <div class='temp-password-warning'>
                            <i class='ti ti-alert-triangle me-1'></i>
                            <strong>Importante:</strong> 
                            <ul class='mb-0 mt-2'>
                                <li>Anote esta contraseña en un lugar seguro</li>
                                <li>Esta contraseña es temporal y debe cambiarse al iniciar sesión</li>
                                <li>El sistema le solicitará cambiarla por una nueva al ingresar</li>
                            </ul>
                        </div>";
                        $message_type = "success";
                    } else {
                        $message = "Error al generar la contraseña temporal. Intente más tarde.";
                        $message_type = "danger";
                    }
                    mysqli_stmt_close($updateStmt);
                } else {
                    $message = "Error en el sistema. Intente más tarde.";
                    $message_type = "danger";
                }
            } else {
                $message = "No se encontró un usuario registrado con el documento: " . htmlspecialchars($numeroDocumento);
                $message_type = "warning";
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "Error en la conexión con la base de datos.";
            $message_type = "danger";
        }
    }
}

// Función para generar contraseña temporal segura
function generarPasswordTemporal() {
    $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$%&*';
    $password = '';
    
    // Asegurar que tenga al menos una mayúscula, minúscula, número y símbolo
    $password .= 'ABCDEFGHJKLMNPQRSTUVWXYZ'[random_int(0, 24)]; // Mayúscula
    $password .= 'abcdefghijkmnpqrstuvwxyz'[random_int(0, 24)];  // Minúscula  
    $password .= '23456789'[random_int(0, 7)];                    // Número
    $password .= '!@#$%&*'[random_int(0, 6)];                    // Símbolo
    
    // Completar hasta 12 caracteres
    for ($i = 4; $i < 12; $i++) {
        $password .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    
    // Mezclar los caracteres
    return str_shuffle($password);
}

// Política mínima de contraseña (coincide con register.php)
function password_meets_policy($pw) {
    if (!is_string($pw)) return false;
    if (strlen($pw) < 10) return false;
    if (!preg_match('/[A-Z]/', $pw)) return false;
    if (!preg_match('/[a-z]/', $pw)) return false;
    if (!preg_match('/[0-9]/', $pw)) return false;
    // Verificar caracteres especiales de forma más simple
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:"\'|,.<>\/?]/', $pw)) return false;
    return true;
}

if(isset($_POST['btningresar']) && $_SESSION['login_attempts'] < $max_attempts){

    $numeroDocumento = isset($_POST['txtdoc']) ? trim($_POST['txtdoc']) : '';
    $clave = isset($_POST['txtpass']) ? $_POST['txtpass'] : '';

    // Validaciones del lado servidor
    if(empty($numeroDocumento)) {
        $message = "📋 Por favor, ingrese su número de documento para continuar.";
        $message_type = "warning";
    } elseif(empty($clave)) {
        $message = "🔒 Por favor, ingrese su contraseña para continuar.";
        $message_type = "warning";
    } elseif(!is_numeric($numeroDocumento)) {
        $message = "🔢 El número de documento debe contener solo números. Por favor, verifique los datos ingresados.";
        $message_type = "warning";
    } else {
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
                        // Login exitoso - limpiar intentos fallidos
                        $_SESSION['login_attempts'] = 0;

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
                  header("Location: admin/dashboard/change_password.php");
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

                if($row['id_rol'] == 1){
                  header("Location: admin/dashboard/index.php");
                  exit();
                } else {
                  header("Location: user/index.php");
                  exit();
                }
                } else {
                    // Login fallido - incrementar contador
                    $_SESSION['login_attempts']++;
                    $_SESSION['last_attempt_time'] = time();
                    
                    $remaining_attempts = $max_attempts - $_SESSION['login_attempts'];
                    if ($remaining_attempts > 0) {
                        $message = "❌ La contraseña ingresada es incorrecta. Revise sus datos y vuelva a intentar. Intentos restantes: $remaining_attempts de $max_attempts.";
                        $message_type = "danger";
                    } else {
                        $message = "❌ La contraseña es incorrecta. Ha alcanzado el límite máximo de intentos ($max_attempts). Por seguridad, deberá esperar 15 minutos antes de intentar nuevamente.";
                        $message_type = "danger";
                    }
                }
            } else {
                // Usuario no encontrado - también incrementar contador por seguridad
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time();
                
                $remaining_attempts = $max_attempts - $_SESSION['login_attempts'];
                if ($remaining_attempts > 0) {
                    $message = "👤 No se encontró un usuario registrado con el documento: " . htmlspecialchars($numeroDocumento) . ". Verifique el número de documento. Intentos restantes: $remaining_attempts de $max_attempts.";
                    $message_type = "warning";
                } else {
                    $message = "👤 Usuario no encontrado. Ha alcanzado el límite de intentos ($max_attempts). Por seguridad, deberá esperar 15 minutos.";
                    $message_type = "danger";
                }
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = "Error en la conexión con la base de datos. Por favor, intente más tarde.";
            $message_type = "danger";
        }
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
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
              <i class="ti ti-alert-circle me-2"></i>
              <strong>
                <?php if($message_type == 'danger'): ?>
                  Error:
                <?php elseif($message_type == 'warning'): ?>
                  Atención:
                <?php elseif($message_type == 'success'): ?>
                  Éxito:
                <?php else: ?>
                  Información:
                <?php endif; ?>
              </strong>
              <div class="mt-2">
                <?php echo $message; ?>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <form method="post" action="" id="loginForm" onsubmit="return validarFormularioLogin()">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><b>Iniciar Sesión</b></h3>
              <a href="register.php" class="link-primary">No tienes Cuenta?</a>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Documento de Usuario</label>
              <input type="text" name="txtdoc" id="txtdoc" class="form-control" placeholder="Ingrese el documento de Usuario" required>
              <div class="invalid-feedback" id="errorDoc"></div>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Contraseña</label>
              <div class="input-group">
                <input type="password" name="txtpass" id="txtpass" placeholder="Ingrese la clave" class="form-control" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                  <i class="ti ti-eye" id="eyeIcon"></i>
                </button>
              </div>
              <div class="invalid-feedback" id="errorPass"></div>
            </div>
            <div class="d-flex mt-1 justify-content-between">
              <div class="form-check">
                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                <label class="form-check-label text-muted" for="customCheckc1">Mantenerme conectado</label>
              </div>              
            </div>
            <div class="d-grid mt-4">
              <?php if ($_SESSION['login_attempts'] >= $max_attempts): ?>
                <button type="submit" name="btningresar" class="btn btn-secondary" disabled>
                  <i class="ti ti-lock me-2"></i>Cuenta Bloqueada Temporalmente
                </button>
                <small class="text-muted text-center mt-2">
                  <i class="ti ti-info-circle me-1"></i>
                  Espere antes de intentar nuevamente
                </small>
              <?php else: ?>
                <button type="submit" name="btningresar" class="btn btn-primary" id="loginBtn">
                  <i class="ti ti-login me-2"></i>Iniciar Sesión
                </button>
                <?php if ($_SESSION['login_attempts'] > 0): ?>
                  <small class="text-warning text-center mt-2">
                    <i class="ti ti-alert-triangle me-1"></i>
                    Intentos restantes: <?php echo $max_attempts - $_SESSION['login_attempts']; ?>
                  </small>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </form>
          
          <!-- Sección de ayuda -->
          <div class="text-center mt-4">
            <div class="dropdown">
              <a class="btn btn-link text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-help-circle me-1"></i>¿Problemas para iniciar sesión?
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="mostrarAyuda('documento')">
                  <i class="ti ti-id me-2"></i>¿Olvidaste tu documento?
                </a></li>
                <li><a class="dropdown-item" href="#" onclick="mostrarAyuda('password')">
                  <i class="ti ti-key me-2"></i>¿Olvidaste tu contraseña?
                </a></li>
                <li><a class="dropdown-item" href="#" onclick="mostrarAyuda('bloqueo')">
                  <i class="ti ti-lock me-2"></i>Cuenta bloqueada
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="register.php">
                  <i class="ti ti-user-plus me-2"></i>Crear nueva cuenta
                </a></li>
              </ul>
            </div>
          </div>
          
          <!-- Modal de ayuda -->
          <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="helpModalLabel">Ayuda</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="helpModalBody">
                  <!-- Contenido dinámico -->
                </div>
                <div class="modal-footer" id="helpModalFooter">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal para solicitar contraseña temporal -->
          <div class="modal fade" id="tempPasswordModal" tabindex="-1" aria-labelledby="tempPasswordModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="tempPasswordModalLabel">
                    <i class="ti ti-key me-2"></i>Solicitar Contraseña Temporal
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" id="tempPasswordForm">
                  <div class="modal-body">
                    <div class="alert alert-info">
                      <i class="ti ti-info-circle me-2"></i>
                      <strong>Importante:</strong> Se generará una contraseña temporal que deberás cambiar en tu primer inicio de sesión.
                    </div>
                    
                    <div class="mb-3">
                      <label for="doc_temp" class="form-label">Número de Documento</label>
                      <input type="text" name="doc_temp" id="doc_temp" class="form-control" 
                             placeholder="Ingrese su número de documento" required>
                      <div class="form-text">Ingrese el documento con el que se registró en el sistema</div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="solicitar_temp_password" class="btn btn-primary">
                      <i class="ti ti-send me-2"></i>Generar Contraseña Temporal
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>           
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
  <script>
    // Validación del formulario de login
    function validarFormularioLogin() {
      const documento = document.getElementById('txtdoc');
      const password = document.getElementById('txtpass');
      const errorDoc = document.getElementById('errorDoc');
      const errorPass = document.getElementById('errorPass');
      
      let isValid = true;
      
      // Limpiar errores previos
      documento.classList.remove('is-invalid');
      password.classList.remove('is-invalid');
      errorDoc.textContent = '';
      errorPass.textContent = '';
      
      // Validar documento
      if (!documento.value.trim()) {
        documento.classList.add('is-invalid');
        errorDoc.textContent = 'Por favor, ingrese su número de documento.';
        isValid = false;
      } else if (!/^\d+$/.test(documento.value.trim())) {
        documento.classList.add('is-invalid');
        errorDoc.textContent = 'El documento debe contener solo números.';
        isValid = false;
      }
      
      // Validar contraseña
      if (!password.value) {
        password.classList.add('is-invalid');
        errorPass.textContent = 'Por favor, ingrese su contraseña.';
        isValid = false;
      }
      
      return isValid;
    }
    
    // Funcionalidad consolidada al cargar el DOM
    document.addEventListener('DOMContentLoaded', function() {
      // ===== FUNCIONALIDAD PARA MOSTRAR/OCULTAR CONTRASEÑA =====
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('txtpass');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          
          // Cambiar el ícono
          if (type === 'text') {
            eyeIcon.className = 'ti ti-eye-off';
          } else {
            eyeIcon.className = 'ti ti-eye';
          }
        });
      }
      
      // ===== VALIDACIÓN EN TIEMPO REAL PARA EL DOCUMENTO =====
      const docInput = document.getElementById('txtdoc');
      const errorDoc = document.getElementById('errorDoc');
      
      if (docInput && errorDoc) {
        docInput.addEventListener('input', function() {
          const value = this.value;
          
          if (value && !/^\d+$/.test(value)) {
            this.classList.add('is-invalid');
            errorDoc.textContent = 'Solo se permiten números.';
          } else {
            this.classList.remove('is-invalid');
            errorDoc.textContent = '';
          }
        });
      }
      
      // ===== VALIDACIÓN PARA EL FORMULARIO DE CONTRASEÑA TEMPORAL =====
      const tempPasswordForm = document.getElementById('tempPasswordForm');
      const docTempInput = document.getElementById('doc_temp');
      
      if (tempPasswordForm && docTempInput) {
        // Validación en tiempo real para el documento temporal
        docTempInput.addEventListener('input', function() {
          const value = this.value;
          
          if (value && !/^\d+$/.test(value)) {
            this.classList.add('is-invalid');
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
              const errorDiv = document.createElement('div');
              errorDiv.className = 'invalid-feedback';
              errorDiv.textContent = 'Solo se permiten números.';
              this.parentNode.insertBefore(errorDiv, this.nextElementSibling);
            }
          } else {
            this.classList.remove('is-invalid');
            const errorDiv = this.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
              errorDiv.remove();
            }
          }
        });
        
        // Validación al enviar el formulario temporal
        tempPasswordForm.addEventListener('submit', function(e) {
          console.log('Formulario de contraseña temporal enviado'); // Debug
          const docValue = docTempInput.value.trim();
          
          if (!docValue) {
            e.preventDefault();
            docTempInput.classList.add('is-invalid');
            alert('Por favor, ingrese su número de documento.');
            return false;
          }
          
          if (!/^\d+$/.test(docValue)) {
            e.preventDefault();
            docTempInput.classList.add('is-invalid');
            alert('El documento debe contener solo números.');
            return false;
          }
          
          // Si llegamos aquí, el formulario es válido
          return true;
        });
      }
    });
    
    // Función para mostrar ayuda
    function mostrarAyuda(tipo) {
      const modal = new bootstrap.Modal(document.getElementById('helpModal'));
      const title = document.getElementById('helpModalLabel');
      const body = document.getElementById('helpModalBody');
      
      switch(tipo) {
        case 'documento':
          title.textContent = 'Documento de Usuario';
          body.innerHTML = `
            <div class="alert alert-info">
              <i class="ti ti-info-circle me-2"></i>
              <strong>Tu documento de usuario es:</strong>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">• El número de identificación que registraste al crear tu cuenta</li>
              <li class="list-group-item">• Puede ser Cédula de Ciudadanía (CC), Tarjeta de Identidad (TI) o Número Nacional (NN)</li>
              <li class="list-group-item">• Solo debe contener números, sin puntos ni guiones</li>
            </ul>
            <div class="mt-3">
              <strong>¿Aún no recuerdas?</strong> Contacta al administrador del sistema.
            </div>
          `;
          break;
          
        case 'password':
          // Para contraseña, mostrar el modal de solicitud de contraseña temporal
          const tempModal = new bootstrap.Modal(document.getElementById('tempPasswordModal'));
          tempModal.show();
          return; // Salir temprano para no mostrar el modal de ayuda normal
          
        case 'bloqueo':
          title.textContent = 'Cuenta Bloqueada';
          body.innerHTML = `
            <div class="alert alert-danger">
              <i class="ti ti-lock me-2"></i>
              <strong>Tu cuenta está temporalmente bloqueada</strong>
            </div>
            <p>Esto ocurre por seguridad después de varios intentos fallidos de inicio de sesión.</p>
            <div class="bg-light p-3 rounded">
              <h6>¿Qué puedes hacer?</h6>
              <ul>
                <li><strong>Esperar:</strong> El bloqueo se levanta automáticamente después de 15 minutos</li>
                <li><strong>Verificar:</strong> Asegúrate de estar usando las credenciales correctas</li>
                <li><strong>Contactar:</strong> Si el problema persiste, contacta al administrador</li>
              </ul>
            </div>
          `;
          break;
      }
      
      modal.show();
    }
    
    // Hacer la función global
    window.mostrarAyuda = mostrarAyuda;
    
    // Función para copiar contraseña temporal al portapapeles
    function copyTempPassword() {
      const tempPasswordText = document.getElementById('tempPasswordText');
      if (tempPasswordText) {
        const password = tempPasswordText.textContent.trim();
        
        // Crear un elemento temporal para copiar
        const tempInput = document.createElement('input');
        tempInput.value = password;
        document.body.appendChild(tempInput);
        tempInput.select();
        
        try {
          document.execCommand('copy');
          // Cambiar el botón temporalmente para indicar éxito
          const copyBtn = tempPasswordText.parentNode.querySelector('button');
          const originalContent = copyBtn.innerHTML;
          copyBtn.innerHTML = '<i class="ti ti-check me-1"></i>¡Copiado!';
          copyBtn.classList.remove('btn-outline-primary');
          copyBtn.classList.add('btn-success');
          
          setTimeout(() => {
            copyBtn.innerHTML = originalContent;
            copyBtn.classList.remove('btn-success');
            copyBtn.classList.add('btn-outline-primary');
          }, 2000);
          
        } catch (err) {
          alert('No se pudo copiar automáticamente. Por favor, copie la contraseña manualmente.');
        }
        
        document.body.removeChild(tempInput);
      }
    }
    
    // Hacer la función global
    window.copyTempPassword = copyTempPassword;
  </script>
  
  <style>
    .navbar {
      width: 100%;
      border-bottom: 1px solid #eee; /* línea sutil abajo */
    }
    
    /* Estilos adicionales para mejor UX */
    .alert {
      border-left: 4px solid;
    }
    
    .alert-danger {
      border-left-color: #dc3545;
      background-color: #f8d7da;
    }
    
    .alert-warning {
      border-left-color: #ffc107;
      background-color: #fff3cd;
    }
    
    .alert-info {
      border-left-color: #0dcaf0;
      background-color: #d1ecf1;
    }
    
    .input-group .btn {
      border-left: 0;
    }
    
    .invalid-feedback {
      display: block;
    }
    
    /* Estilos específicos para contraseña temporal */
    .temp-password-display {
      background-color: #f8f9fa;
      border: 2px dashed #28a745;
      border-radius: 8px;
      padding: 15px;
      margin: 10px 0;
      font-family: 'Courier New', monospace;
      font-size: 1.1em;
      text-align: center;
      word-break: break-all;
    }
    
    .temp-password-warning {
      background-color: #fff3cd;
      border-left: 4px solid #ffc107;
      padding: 10px;
      margin-top: 10px;
      border-radius: 4px;
    }
    
    /* Mejorar el modal de contraseña temporal */
    #tempPasswordModal .modal-dialog {
      max-width: 500px;
    }
    
    #tempPasswordModal .alert-info {
      border-left: 4px solid #0dcaf0;
    }
  </style>
</body>
<!-- [Body] end -->
</html>
