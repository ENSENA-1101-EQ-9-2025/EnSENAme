<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
include '../conexion.php';
$nombre = '';
if (!empty($_SESSION['txtdoc'])) {
  $doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
  $res = mysqli_query($conexion, "SELECT p_nombre FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
  if ($row = mysqli_fetch_assoc($res)) {
    $nombre = $row['p_nombre'];
  } else {
    $nombre = 'Usuario';
  }
} else {
  $nombre = 'Usuario';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>EnSEÑAme</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <link rel="icon" href="../admin/assets/images/favisena.png" type="image/x-icon"> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<link rel="stylesheet" href="../admin/assets/fonts/tabler-icons.min.css" >
<link rel="stylesheet" href="../admin/assets/fonts/feather.css" >
<link rel="stylesheet" href="../admin/assets/fonts/fontawesome.css" >
<link rel="stylesheet" href="../admin/assets/fonts/material.css" >
<link rel="stylesheet" href="../admin/assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../admin/assets/css/style-preset.css" >

</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="index.php" class="b-brand text-primary">
        <img src="../admin/assets/images/logoensename.png" class="img-fluid" alt="">
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
  <li class="pc-item">
  <a href="producto.php" class="pc-link">
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

<header class="pc-header">
  <div class="header-wrapper"> <div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
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
          <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
          <span><?php echo htmlspecialchars($nombre); ?></span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1"><?php echo htmlspecialchars($nombre); ?></h6>
              <span><?php echo htmlspecialchars($nombre); ?></span>
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
            <a href="#!" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Edit Profile</span>
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
<div class="pc-container">
    <div class="pc-content">
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Producto</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <h1>Guías</h1>     
        <div class="card mt-3">
        <div class="card-body">
          <h2>Guías de aprendizaje de LSC</h2>
          <div class="row">
            <!-- Guía 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title">1. Introducción a la LSC</h5>
                  <p class="card-text">
                    Aprende los conceptos básicos del Lenguaje de Señas Colombiano (LSC), incluyendo su historia,
                    estructura y la importancia de la comunicación visual en la comunidad sorda.
                  </p>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#guia1">
                    Ver guía
                  </button>
                </div>
              </div>
            </div>

            <!-- Guía 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title">2. Abecedario y números en LSC</h5>
                  <p class="card-text">
                    Domina el abecedario dactilológico y los números en LSC. Esta guía te proporcionará una base
                    sólida para deletrear palabras y expresar cantidades.
                  </p>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#guia2">
                    Ver guía
                  </button>
                </div>
              </div>
            </div>

            <!-- Guía 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title">3. Verbos y conversaciones cotidianas</h5>
                  <p class="card-text">
                    Expande tu vocabulario con verbos esenciales y aprende a formar oraciones simples para mantener
                    conversaciones básicas sobre temas cotidianos.
                  </p>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#guia3">
                    Ver guía
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MODALES CON VIDEOS -->

      <!-- Modal Guía 1 -->
      <div class="modal fade" id="guia1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Guía 1: Introducción a la LSC</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID1"
                title="Introducción a la LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 2 -->
      <div class="modal fade" id="guia2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Guía 2: Abecedario y números en LSC</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID2"
                title="Abecedario y números en LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 3 -->
      <div class="modal fade" id="guia3" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Guía 3: Verbos y conversaciones cotidianas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID3"
                title="Verbos y conversaciones cotidianas" frameborder="0"
                allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>
