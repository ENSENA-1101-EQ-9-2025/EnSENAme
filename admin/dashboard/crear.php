<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>EnSEÑAme</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../assets/css/style-preset.css" >
<?php
session_start();
include '../../conexion.php';
?>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="../dashboard/index.php" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="../assets/images/logoensename.png" class="img-fluid" alt="">
      </a>
    </div>
    <div class="navbar-content">
    <ul class="pc-navbar">
  <li class="pc-item">
    <a href="index.php" class="pc-link">
      <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
      <span class="pc-mtext">Inicio</span>
    </a>
  </li>     
  
<li class="pc-item pc-hasmenu">
  <a href="javascript:void(0);" class="pc-link">
    <span class="pc-micon"><i class="ti ti-users"></i></span>
    <span class="pc-mtext">Usuarios</span>
    <span class="pc-arrow"><i class="ti ti-chevron-down"></i></span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item">
      <a href="crear.php" class="pc-link">
        <span class="pc-mtext">Agregar usuario</span>
      </a>
    </li>
    <li class="pc-item">
      <a href="usuarios.php" class="pc-link">
        <span class="pc-mtext">Ver Usuarios</span>
      </a>
    </li>
  </ul>
</li>

  <li class="pc-item">
      <a href="producto.html" class="pc-link">
        <span class="pc-micon"><i class="ti ti-book"></i></span>
        <span class="pc-mtext">Guias</span>
      </a>
  </li>
   <li class="pc-item">
          <a href="servicio.php" class="pc-link">
            <span class="pc-micon"><i class="ti ti-message-circle"></i></span>
            <span class="pc-mtext">Chats</span>
          </a>
        </li>
</ul>

    </div>
    
  </div>
</nav>

<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ti ti-search"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3">
          <div class="form-group mb-0 d-flex align-items-center">
            <i data-feather="search"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
          </div>
        </form>
      </div>
    </li>
    
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">    
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
        <span>Usuario</span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1"><?php echo $_SESSION['primer_nombre']; ?></h6>
              <span>Admin</span>
            </div>
            
          </div>
        </div>
        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="drp-t1"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-1"
              type="button"
              role="tab"
              aria-controls="drp-tab-1"
              aria-selected="true"
              ><i class="ti ti-user"></i> Perfil</button
            >
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="drp-t2"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-2"
              type="button"
              role="tab"
              aria-controls="drp-tab-2"
              aria-selected="false"
              ><i class="ti ti-settings"></i> Configuración</button
            >
          </li>
        </ul>
        <div class="tab-content" id="mysrpTabContent">
          <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
            <a href="logout.php" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>View Profile</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
          </div>
          <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
            <a href="#!" class="dropdown-item">
              <i class="ti ti-help"></i>
              <span>Support</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>Account Settings</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-messages"></i>
              <span>Feedback</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->

  <!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Usuario</li>
                <li class="breadcrumb-item" aria-current="page">Crear usuario</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->  
      <h1>Bienvenido al Sistema</h1>
      <a href="http://localhost/ense%C3%B1ame/admin/dashboard/index.php">Inicio</a>|<a href="usuarios.php"> Usuario</a> |
      <a href="../application/user-list.html">Producto</a> | <a href="../application/servicio.php">Servicio</a>   
        <!-- [ sample-page ] start -->
        <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Registro de Usuario</h5>
        </div>
        <div class="card-body">
          <form action="../../codigo.php" method="post" onsubmit="return validarFormulario();">
            <div class="mb-3">
              <label for="tipoDocumento" class="form-label">Tipo de Documento:</label>
              <select name="tipoDocumento" id="tipoDocumento" class="form-select" required>
                <option value="">--Seleccione--</option>
                <option value="1">TI</option>
                <option value="2">CC</option>
                <option value="3">NN</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="numeroDocumento" class="form-label">Número de Documento:</label>
              <input type="text" name="numeroDocumento" id="numeroDocumento" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="primerNombre" class="form-label">Primer Nombre:</label>
              <input type="text" name="primerNombre" id="primerNombre" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="segundoNombre" class="form-label">Segundo Nombre:</label>
              <input type="text" name="segundoNombre" id="segundoNombre" class="form-control">
            </div>

            <div class="mb-3">
              <label for="primerApellido" class="form-label">Primer Apellido:</label>
              <input type="text" name="primerApellido" id="primerApellido" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="segundoApellido" class="form-label">Segundo Apellido:</label>
              <input type="text" name="segundoApellido" id="segundoApellido" class="form-control">
            </div>

            <div class="mb-3">
              <label for="clave" class="form-label">Clave:</label>
              <input type="password" name="clave" id="clave" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="confirmarClave" class="form-label">Confirmar Clave:</label>
              <input type="password" name="confirmarClave" id="confirmarClave" class="form-control" required>
              <small id="mensajeError" class="text-danger"></small>
            </div>

            <div class="mb-3">
              <label for="idrol" class="form-label">Seleccione su Rol:</label>
              <select name="idrol" id="idrol" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="1">admin</option>
                <option value="2">user</option>
                <option value="3">Operator</option>
              </select>
            </div>

            <div class="d-grid">
              <button type="submit" name="btn_registrar" id="btn_registrar" class="btn btn-primary">Registrarse</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Validación JS -->
<script>
  function validarFormulario() {
    const clave = document.getElementById('clave').value;
    const confirmarClave = document.getElementById('confirmarClave').value;
    const mensajeError = document.getElementById('mensajeError');

    if (clave !== confirmarClave) {
      mensajeError.textContent = "Las claves no coinciden.";
      return false;
    } else {
      mensajeError.textContent = "";
      return true;
    }
  }
</script>

        
  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">          
        </div>
        <div class="col-auto my-1">          
        </div>
      </div>
    </div>
  </footer>
 






  <!-- [Page Specific JS] start -->
  <script src="../assets/js/plugins/apexcharts.min.js"></script>
  <script src="../assets/js/pages/dashboard-default.js"></script>
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>

  
  
  
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
    

</body>
<!-- [Body] end -->

</html>

