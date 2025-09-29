<?php
session_start();
include "conexion.php"; // Archivo con la conexión $conexion

if(isset($_POST['btningresar'])){

    $numeroDocumento = $_POST['txtdoc'];   
    $clave = $_POST['txtpass'];            
    $pass = md5($clave);                   

  // Consulta para verificar usuario y contraseña y obtener todos los datos
  $query = "SELECT * FROM tb_usuarios WHERE ID = '$numeroDocumento' AND Clave = '$pass'";
  $result = mysqli_query($conexion, $query);
//Cambio comprobar
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $_SESSION['txtdoc'] = $numeroDocumento; // Guardar sesión
    // Guardar datos del usuario en la sesión
    $_SESSION['primer_nombre'] = $row['p_nombre'];
    $_SESSION['segundo_nombre'] = $row['s_nombre'];
    $_SESSION['primer_apellido'] = $row['p_apellido'];
    $_SESSION['segundo_apellido'] = $row['s_apellido'];
    $_SESSION['id_rol'] = $row['id_rol'];
    // Redirigir según el rol
    if($row['id_rol'] == 1){
      echo "<script>window.location='admin/dashboard/index.php';</script>";
    } else {
      echo "<script>window.location='user/index.php';</script>";
    exit();
  } else {
    $message = "Usuario o contraseña incorrectos"; 
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
<link rel="stylesheet" href="admin/assets/image" >
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
          <div class="card-body"><form method="post" action="">
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
          </div>
          </form>
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
  
    
 
</body>
<!-- [Body] end -->

</html>











<style>
  .navbar {
  width: 100%;
  border-bottom: 1px solid #eee; /* línea sutil abajo */
}
</style>
