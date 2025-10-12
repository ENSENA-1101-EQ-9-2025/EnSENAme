<?php
require_once __DIR__ . '/../includes/session.php';
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
  <link rel="icon" href="../admin/assets/images/favisena.png" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="../admin/assets/fonts/tabler-icons.min.css" >
  <link rel="stylesheet" href="../admin/assets/fonts/feather.css" >
  <link rel="stylesheet" href="../admin/assets/fonts/fontawesome.css" >
  <link rel="stylesheet" href="../admin/assets/fonts/material.css" >
  <link rel="stylesheet" href="../admin/assets/css/style.css" id="main-style-link" >
  <link rel="stylesheet" href="../admin/assets/css/style-preset.css" >
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
  <!-- [ Sidebar Menu ] end -->
  <header class="pc-header">
    <div class="header-wrapper">
      <div class="me-auto pc-mob-drp">
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
        </ul>
      </div>
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
              <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
            <span><?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : ($nombre !== '' ? $nombre : 'Usuario')); ?></span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : ($nombre !== '' ? $nombre : 'Usuario')); ?></h6>
                    <span><?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : ($nombre !== '' ? $nombre : 'Usuario')); ?></span>
                  </div>
                </div>
              </div>
              <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="drp-t1" data-bs-toggle="tab" data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1" aria-selected="true"><i class="ti ti-user"></i> Perfil</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2" type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false"><i class="ti ti-settings"></i> Configuración</button>
                </li>
              </ul>
              <div class="tab-content" id="mysrpTabContent">
                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
                  <a href="editarperfil.php" class="dropdown-item">
                    <i class="ti ti-edit-circle"></i>
                    <span>Editar Perfil</span>
                  </a>
                  <a href="logout.php" class="dropdown-item">
                    <i class="ti ti-power"></i>
                    <span>Salir</span>
                  </a>
                </div>
                <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
                  <a href="#" class="dropdown-item">
                    <i class="ti ti-help"></i>
                    <span>Support</span>
                  </a>
                  <a href="#" class="dropdown-item">
                    <i class="ti ti-user"></i>
                    <span>Account Settings</span>
                  </a>
                  <a href="#" class="dropdown-item">
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
  <div class="pc-container">
    <div class="pc-content">
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <h1>Bienvenido al Sistema</h1>
      <br><br>
      <!-- Carrusel -->
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../admin/assets/images/car1.png" style="width:800px; height:400px; object-fit:cover;" class="d-block w-100" alt="Primer slide">
            <div class="carousel-caption d-none d-md-block">
              <p>Un ejemplo de una IA de reconocimiento por parte de ultralytics.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../admin/assets/images/logoensename.PNG" style="width:800px; height:400px; object-fit:cover;" class="d-block w-100" alt="Segundo slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>Logo del proyecto</h5>
              <p>EnSEÑAme.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../admin/assets/images/car2.png" style="width:800px; height:400px; object-fit:cover;" class="d-block w-100" alt="Tercer slide">
            <div class="carousel-caption d-none d-md-block">
              <p>Muestra el impacto social de EnSEÑAme en derribar barreras comunicativas..</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </a>
      </div>
      <br><br>
      <!-- Fin Carrusel-->
      <section class="page-section" id="services">
        <div class="container">
          <div class="text-center">
            <h2 class="h3 mb-1 text-gray-800">¿Quienes somos?</h2>
            <h4> <small  class="section-subheading text-muted">Somos un equipo multidisciplinario comprometido con la inclusión y la accesibilidad.
              Nuestro objetivo principal es desarrollar una app innovadora que traduzca en tiempo real el lenguaje 
              de señas colombiano (LSC) a texto y voz, facilitando la comunicación entre personas sordas y oyentes. 
              Contamos con desarrolladores, diseñadores, lingüistas especializados en LSC y asesores de la comunidad sorda. 
              Trabajamos con enfoque humano, basados en la empatía y el respeto por la diversidad. 
              Utilizamos inteligencia artificial y visión por computadora para interpretar con precisión las señas. 
              Mantenemos una colaboración constante con usuarios reales para validar y mejorar la aplicación. Nuestro sueño es derribar barreras
              comunicativas en Colombia.
              Creemos que la tecnología debe estar al servicio de todos.</small></h4>
            <br><br>
            <div class="row text-center">
              <div class="col-md-4">
                <span class="fa-stack fa-4x">
                  <i class="fas fa-circle fa-stack-2x text-primary"></i>
                  <i class="fas fa-video fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Diseñar</h4>
                <p class="text-muted">Diseñar y entrenar un modelo de reconocimiento de gestos y movimientos asociados al lenguaje de señas.</p>
              </div>
              <div class="col-md-4">
                <span class="fa-stack fa-4x">
                  <i class="fas fa-circle fa-stack-2x text-primary"></i>
                  <i class="fas fa-clipboard fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Evaluar</h4>
                <p class="text-muted">Evaluar la precisión y eficacia del sistema en diversos contextos con diferentes dialectos de lenguaje de señas</p>
              </div>
              <div class="col-md-4">
                <span class="fa-stack fa-4x">
                  <i class="fas fa-circle fa-stack-2x text-primary"></i>
                  <i class="fas fa-hands fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Analizar</h4>
                <p class="text-muted">Analizar e identificar los gestos más comunes del lenguaje de señas</p>
              </div>
            </div>
            <section class="page-section" id="services">
              <div class="container">
                <br>
                <div class="text-center">
                  <h2 class="h3 mb-1 text-gray-800">Justificación</h2>
                  <h4 class="section-subheading text-muted">¿Por qué es importante desarrollar nuestra app?</h4>
                </div>
                <br>
                <h5><small>En la actualidad, la comunicación efectiva sigue siendo uno de los principales desafíos para las personas con discapacidades auditivas, especialmente aquellas que utilizan el lenguaje de señas como su principal medio de expresión. Esta forma de comunicación, aunque rica y compleja, no es comprendida por la mayoría de la población oyente, lo que genera una barrera significativa para la inclusión social, educativa y laboral de las personas sordas.
                  <br><br>
                  Este proyecto surge de la necesidad urgente de reducir la brecha comunicativa entre personas sordas y oyentes, promoviendo la igualdad de oportunidades y el ejercicio pleno de los derechos de comunicación e interacción. En particular, se busca diseñar una herramienta tecnológica que permita la traducción en tiempo real del lenguaje de señas a texto escrito, facilitando así una interacción más fluida, accesible y comprensible para ambas partes.
                  <br><br>
                  La implementación de una solución de este tipo tiene un gran potencial transformador en diferentes ámbitos:
                  <br>
                  En la educación, facilita la participación de estudiantes sordos en entornos inclusivos.
                  <br>
                  En el entorno laboral, contribuiría a una mayor integración de personas sordas en equipos de trabajo diversos.
                </small></h5>
                <br><br>
                <div class="card mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">% de Progreso de los avances</h6>
                  </div>
                  <div class="card-body">
                    <div class="mb-1 small">IA traductora <h4>25%</h4></div>
                    <div class="progress mb-4">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mb-1 small">Desarrollo general <h4>42%</h4></div>
                    <div class="progress progress-sm mb-2">
                      <div class="progress-bar" role="progressbar" style="width: 42%" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
      <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
          <div class="row">
            <div class="col-sm my-1"></div>
            <div class="col-auto my-1"></div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="../assets/js/plugins/apexcharts.min.js"></script>
  <script src="../assets/js/pages/dashboard-default.js"></script>
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
</body>
</html>