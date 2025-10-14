$php_open = '<?php';

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
<head>
  <title>EnSEÑAme - Guías de LSC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Aprende Lenguaje de Señas Colombiano con nuestras guías interactivas. Videos educativos y contenido especializado para la comunidad sorda.">
  <meta name="keywords" content="LSC, Lenguaje de Señas Colombiano, Guías, Educación, Comunidad Sorda, EnSEÑAme">
  <meta name="author" content="EnSEÑAme Team">

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
        <img src="../admin/assets/images/logoensename.PNG" class="img-fluid" alt="">
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
          <span><?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : ($nombre !== '' ? $nombre : 'Usuario')); ?></span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1"><?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : ($nombre !== '' ? $nombre : 'Usuario')); ?></h6>
              <span><?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : ($nombre !== '' ? $nombre : 'Usuario')); ?></span>
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
            <a href="editarperfil.php" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Editar Perfil</span>
            </a>
            <a href="user-profile.php" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>Ver Perfil</span>
            </a>
            <a href="logout.php" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Cerrar Sesión</span>
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
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Guías de LSC</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="row mb-4">
        <div class="col-12">
          <div class="alert alert-info" role="alert">
            <i class="ti ti-info-circle me-2"></i>
            <strong>¡Bienvenido a nuestras guías de LSC!</strong> Aquí encontrarás contenido educativo especializado para aprender Lenguaje de Señas Colombiano paso a paso.
          </div>
        </div>
      </div>

      <h1 class="mb-4">
        <i class="ti ti-book me-2 text-primary"></i>
        Guías de Aprendizaje LSC
      </h1>     
        <div class="card mt-3">
        <div class="card-header">
          <h2 class="mb-0">
            <i class="ti ti-video me-2"></i>
            Contenido Educativo Interactivo
          </h2>
          <p class="text-muted mb-0">Aprende Lenguaje de Señas Colombiano con nuestros videos especializados</p>
        </div>
        <div class="card-body">
          <div class="row">
            <!-- Guía 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="text-center mb-3">
                    <div class="bg-primary-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                      <i class="ti ti-school text-primary fs-3"></i>
                    </div>
                  </div>
                  <h5 class="card-title text-center">1. Introducción a la LSC</h5>
                  <p class="card-text flex-grow-1">
                    Aprende los conceptos básicos del Lenguaje de Señas Colombiano (LSC), incluyendo su historia,
                    estructura y la importancia de la comunicación visual en la comunidad sorda.
                  </p>
                  <div class="mt-auto">
                    <div class="d-grid">
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#guia1">
                        <i class="ti ti-play me-2"></i>Ver guía
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Guía 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="text-center mb-3">
                    <div class="bg-success-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                      <i class="ti ti-abc text-success fs-3"></i>
                    </div>
                  </div>
                  <h5 class="card-title text-center">2. Abecedario y números en LSC</h5>
                  <p class="card-text flex-grow-1">
                    Domina el abecedario dactilológico y los números en LSC. Esta guía te proporcionará una base
                    sólida para deletrear palabras y expresar cantidades.
                  </p>
                  <div class="mt-auto">
                    <div class="d-grid">
                      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#guia2">
                        <i class="ti ti-play me-2"></i>Ver guía
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Guía 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="text-center mb-3">
                    <div class="bg-warning-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                      <i class="ti ti-message-circle text-warning fs-3"></i>
                    </div>
                  </div>
                  <h5 class="card-title text-center">3. Verbos y conversaciones cotidianas</h5>
                  <p class="card-text flex-grow-1">
                    Expande tu vocabulario con verbos esenciales y aprende a formar oraciones simples para mantener
                    conversaciones básicas sobre temas cotidianos.
                  </p>
                  <div class="mt-auto">
                    <div class="d-grid">
                      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#guia3">
                        <i class="ti ti-play me-2"></i>Ver guía
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Guía 4 - Nueva -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="text-center mb-3">
                    <div class="bg-info-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                      <i class="ti ti-users text-info fs-3"></i>
                    </div>
                  </div>
                  <h5 class="card-title text-center">4. Familia y Relaciones</h5>
                  <p class="card-text flex-grow-1">
                    Aprende las señas para referirte a miembros de la familia, relaciones personales y descripciones
                    de personas en tu entorno social.
                  </p>
                  <div class="mt-auto">
                    <div class="d-grid">
                      <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#guia4">
                        <i class="ti ti-play me-2"></i>Ver guía
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Guía 5 - Nueva -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="text-center mb-3">
                    <div class="bg-danger-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                      <i class="ti ti-mood-smile text-danger fs-3"></i>
                    </div>
                  </div>
                  <h5 class="card-title text-center">5. Emociones y Sentimientos</h5>
                  <p class="card-text flex-grow-1">
                    Expresa tus emociones y sentimientos en LSC. Aprende a comunicar estados de ánimo, 
                    reacciones y expresiones emocionales básicas.
                  </p>
                  <div class="mt-auto">
                    <div class="d-grid">
                      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#guia5">
                        <i class="ti ti-play me-2"></i>Ver guía
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Guía 6 - Nueva -->
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <div class="text-center mb-3">
                    <div class="bg-secondary-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                      <i class="ti ti-clock text-secondary fs-3"></i>
                    </div>
                  </div>
                  <h5 class="card-title text-center">6. Tiempo y Fechas</h5>
                  <p class="card-text flex-grow-1">
                    Domina las señas relacionadas con el tiempo: días de la semana, meses, horas,
                    y expresiones temporales comunes en LSC.
                  </p>
                  <div class="mt-auto">
                    <div class="d-grid">
                      <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#guia6">
                        <i class="ti ti-play me-2"></i>Ver guía
                      </button>
                    </div>
                  </div>
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
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title">
                <i class="ti ti-school me-2"></i>
                Guía 1: Introducción a la LSC
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <div class="mb-3">
                <p class="text-muted">Conceptos básicos e historia del Lenguaje de Señas Colombiano</p>
              </div>
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID1"
                title="Introducción a la LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 2 -->
      <div class="modal fade" id="guia2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-success text-white">
              <h5 class="modal-title">
                <i class="ti ti-abc me-2"></i>
                Guía 2: Abecedario y números en LSC
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <div class="mb-3">
                <p class="text-muted">Aprende el abecedario dactilológico y números básicos</p>
              </div>
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID2"
                title="Abecedario y números en LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 3 -->
      <div class="modal fade" id="guia3" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-warning text-white">
              <h5 class="modal-title">
                <i class="ti ti-message-circle me-2"></i>
                Guía 3: Verbos y conversaciones cotidianas
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <div class="mb-3">
                <p class="text-muted">Aprende verbos esenciales y mantén conversaciones básicas en LSC</p>
              </div>
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID3"
                title="Verbos y conversaciones cotidianas" frameborder="0"
                allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 4 -->
      <div class="modal fade" id="guia4" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-info text-white">
              <h5 class="modal-title">
                <i class="ti ti-users me-2"></i>
                Guía 4: Familia y Relaciones
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <div class="mb-3">
                <p class="text-muted">Señas para familia, relaciones y descripciones de personas</p>
              </div>
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID4"
                title="Familia y Relaciones en LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 5 -->
      <div class="modal fade" id="guia5" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title">
                <i class="ti ti-mood-smile me-2"></i>
                Guía 5: Emociones y Sentimientos
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <div class="mb-3">
                <p class="text-muted">Expresa emociones y sentimientos en LSC</p>
              </div>
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID5"
                title="Emociones y Sentimientos en LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Guía 6 -->
      <div class="modal fade" id="guia6" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
              <h5 class="modal-title">
                <i class="ti ti-clock me-2"></i>
                Guía 6: Tiempo y Fechas
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <div class="mb-3">
                <p class="text-muted">Aprende señas para tiempo, fechas y expresiones temporales</p>
              </div>
              <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/VIDEO_ID6"
                title="Tiempo y Fechas en LSC" frameborder="0"
                allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap JS y scripts -->
  <script src="../admin/assets/js/plugins/popper.min.js"></script>
  <script src="../admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../admin/assets/js/fonts/custom-font.js"></script>
  <script src="../admin/assets/js/pcoded.js"></script>
  <script src="../admin/assets/js/plugins/feather.min.js"></script>

  <script>
    // Configuración del tema
    layout_change('light');
    change_box_container('false');
    layout_rtl_change('false');
    preset_change("preset-1");
    font_change("Public-Sans");

    // Animación para las tarjetas
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.card');
      cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
          card.style.transition = 'all 0.5s ease';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, index * 100);
      });
    });
  </script>
</body>
</html>
