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

  <?php
  session_start();
  ?>
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
              <span><?php echo isset($_SESSION['primer_nombre']) ? htmlspecialchars($_SESSION['primer_nombre']) : 'Usuario'; ?></span>
    </div>
    <div class="navbar-content">
    <ul class="pc-navbar">
  <li class="pc-item">
    <a href="../dashboard/index.php" class="pc-link">
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
  <span><?php echo isset($_SESSION['primer_nombre']) ? htmlspecialchars($_SESSION['primer_nombre']) : 'Usuario'; ?></span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1">Usuario</h6>
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
                <li class="breadcrumb-item" aria-current="page">Chat</li>
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
      <h1>Chat interpretativo de señas</h1>
  <a href="http://localhost/ense%C3%B1ame/admin/dashboard/index.php">Inicio</a>|<a href="http://localhost/ense%C3%B1ame/admin/dashboard/usuarios.php"> <?php echo isset($_SESSION['primer_nombre']) ? htmlspecialchars($_SESSION['primer_nombre']) : 'Usuario'; ?></a> |
      <a href="../application/user-list.html">Producto</a> | <a href="../application/servicio.php">Servicio</a>   
        <!-- [ sample-page ] start -->

        <div class="card">
  <div class="card-body">
  <div class="pc-content flex-grow-1 p-3 overflow-auto">
        <div id="chat-messages" class="d-flex flex-column gap-2 mb-3">
            <div class="d-flex justify-content-end">
                <div class="bg-primary text-white p-2 rounded-3" style="max-width: 75%;">
                    Hola, ¿cómo estás?
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="bg-light p-2 rounded-3" style="max-width: 75%;">
                    ¡Todo bien! ¿Y tú?
                </div>
            </div>
        </div>
    </div>

    <div class="p-3 bg-white border-top">
        <div class="input-group">
            <span class="input-group-text bg-transparent border-0" id="camera-icon">
                <i class="fas fa-camera text-muted fs-5"></i>
            </span>
            <input type="text" class="form-control rounded-pill bg-light border-0" placeholder="Escribe un mensaje...">
            <span class="input-group-text bg-transparent border-0" id="send-icon">
                <i class="fas fa-paper-plane text-primary fs-5"></i>
            </span>
        </div>
    </div>
</div>
  </div>
  <?php
// servicio.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = htmlspecialchars($_POST['message']);
    $file = "chat.json";

    // Si hay archivo subido (imagen o video)
    $mediaPath = "";
    if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $filename = time() . "_" . basename($_FILES["media"]["name"]);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES["media"]["tmp_name"], $targetFile)) {
            $mediaPath = $targetFile;
        }
    }

    // Guardar mensaje
    $newMsg = ["user" => "Tú", "message" => $msg, "media" => $mediaPath, "time" => date("H:i")];
    $chat = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $chat[] = $newMsg;
    file_put_contents($file, json_encode($chat));
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chat en vivo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
  <style>
    #chat-box {
      border: 1px solid #ccc;
      height: 400px;
      overflow-y: auto;
      padding: 10px;
      background: #f9f9f9;
    }
    .msg {
      margin-bottom: 10px;
      padding: 8px;
      border-radius: 8px;
    }
    .me { background: #d1e7dd; text-align: right; }
    .other { background: #f8d7da; }
    img, video { max-width: 100%; margin-top: 5px; border-radius: 8px; }
  </style>
<body class="container py-4">

  <h2>Chat en vivo</h2>
  <div class="mb-3">
    <label for="usuarioDestino" class="form-label">Destino para <?php echo htmlspecialchars($_SESSION['primer_nombre']); ?>:</label>
    <select id="usuarioDestino" class="form-select"></select>
    <div id="errorUsuario" class="text-danger mt-1" style="display:none;"></div>
    <div id="errorSpam" class="text-danger mt-1" style="display:none;"></div>
  </div>
  <div id="chat-box"></div>
  <form id="chat-form" class="mt-3">
    <div class="input-group">
      <input type="text" name="mensaje" id="mensaje" class="form-control" placeholder="Escribe un mensaje...">
      <button class="btn btn-primary" type="submit">Enviar</button>
    </div>
  </form>

  <script>
    // Suponiendo que el admin tiene el ID 5555, puedes ajustar según tu sistema de login
    const usuarioActual = 5555;
    async function cargarUsuarios() {
      const res = await fetch('../../chat_api.php?get_users=1');
      const data = await res.json();
      const select = document.getElementById('usuarioDestino');
      select.innerHTML = '';
      data.forEach(u => {
        const option = document.createElement('option');
        option.value = u.ID;
        option.textContent = `${u.p_nombre} ${u.p_apellido} (ID: ${u.ID})`;
        select.appendChild(option);
      });
    }

    function getUsuarioDestino() {
      return document.getElementById("usuarioDestino").value;
    }
    async function validarUsuarioDestino(id) {
      const res = await fetch(`../../chat_api.php?check_user=1&para=${id}`);
      const data = await res.json();
      return data.exists;
    }
    async function loadChat() {
      const usuarioDestino = getUsuarioDestino();
      if (!await validarUsuarioDestino(usuarioDestino)) {
        document.getElementById("errorUsuario").style.display = "block";
        document.getElementById("errorUsuario").textContent = "El usuario destino no existe.";
        document.getElementById("chat-box").innerHTML = "";
        return;
      } else {
        document.getElementById("errorUsuario").style.display = "none";
      }
      const res = await fetch(`../../chat_api.php?para=${usuarioDestino}`);
      if (!res.ok) return;
      const data = await res.json();
      const box = document.getElementById("chat-box");
      box.innerHTML = "";
      data.forEach(msg => {
        const div = document.createElement("div");
        div.className = msg.de_usuario == usuarioActual ? "msg me" : "msg other";
        let etiqueta = msg.mensaje.startsWith('[Admin]') ? '<span class="badge bg-danger">Admin</span> ' : '';
        div.innerHTML = `${etiqueta}<strong>${msg.de_usuario == usuarioActual ? 'Tú' : 'Otro'}:</strong> ${msg.mensaje.replace('[Admin] ','')} <br><small>${msg.fecha}</small>`;
        box.appendChild(div);
      });
      box.scrollTop = box.scrollHeight;
    }

  document.getElementById("usuarioDestino").addEventListener("change", loadChat);
  cargarUsuarios();

    document.getElementById("chat-form").addEventListener("submit", async (e) => {
      e.preventDefault();
      document.getElementById("errorSpam").style.display = "none";
      const usuarioDestino = getUsuarioDestino();
      if (!await validarUsuarioDestino(usuarioDestino)) {
        document.getElementById("errorUsuario").style.display = "block";
        document.getElementById("errorUsuario").textContent = "El usuario destino no existe.";
        return;
      }
      const mensaje = document.getElementById("mensaje").value;
      if (!mensaje.trim()) return;
      const res = await fetch(`../../chat_api.php`, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `para=${usuarioDestino}&mensaje=${encodeURIComponent(mensaje)}`
      });
      const data = await res.json();
      if (!data.success && data.error) {
        document.getElementById("errorSpam").style.display = "block";
        document.getElementById("errorSpam").textContent = data.error;
        return;
      }
      e.target.reset();
      loadChat();
    });

    setInterval(loadChat, 3000); // refrescar cada 3 segundos
    loadChat();
  </script>
</body>
</html>

</div>
<!-- [ Header ] end -->



  <!-- [ Main Content ] start -->


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

    

  <!-- [Page Specific JS] start -->
  <script>
    // scroll-block
    var tc = document.querySelectorAll('.scroll-block');
    for (var t = 0; t < tc.length; t++) {
      new SimpleBar(tc[t]);
    }
  </script>
  <!-- [Page Specific JS] end -->
  <div class="offcanvas pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
    <div class="offcanvas-header bg-primary">
      <h5 class="offcanvas-title text-white">Mantis Customizer</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="pct-body" style="height: calc(100% - 60px)">
      <div class="offcanvas-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse1">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-layout-sidebar f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Theme Layout</h6>
                  <span>Choose your layout</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse1">
              <div class="pct-content">
                <div class="pc-rtl">
                  <p class="mb-1">Direction</p>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="layoutmodertl">
                    <label class="form-check-label" for="layoutmodertl">RTL</label>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse2">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-brush f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Theme Mode</h6>
                  <span>Choose light or dark mode</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse2">
              <div class="pct-content">
                <div class="theme-color themepreset-color theme-layout">
                  <a href="#!" class="active" onclick="layout_change('light')" data-value="false"
                    ><span><img src="../assets/images/customization/default.svg" alt="img"></span><span>Light</span></a
                  >
                  <a href="#!" class="" onclick="layout_change('dark')" data-value="true"
                    ><span><img src="../assets/images/customization/dark.svg" alt="img"></span><span>Dark</span></a
                  >
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse3">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-color-swatch f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Color Scheme</h6>
                  <span>Choose your primary theme color</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse3">
              <div class="pct-content">
                <div class="theme-color preset-color">
                  <a href="#!" class="active" data-value="preset-1"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 1</span></a
                  >
                  <a href="#!" class="" data-value="preset-2"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 2</span></a
                  >
                  <a href="#!" class="" data-value="preset-3"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 3</span></a
                  >
                  <a href="#!" class="" data-value="preset-4"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 4</span></a
                  >
                  <a href="#!" class="" data-value="preset-5"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 5</span></a
                  >
                  <a href="#!" class="" data-value="preset-6"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 6</span></a
                  >
                  <a href="#!" class="" data-value="preset-7"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 7</span></a
                  >
                  <a href="#!" class="" data-value="preset-8"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 8</span></a
                  >
                  <a href="#!" class="" data-value="preset-9"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 9</span></a
                  >
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item pc-boxcontainer">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse4">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-border-inner f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Layout Width</h6>
                  <span>Choose fluid or container layout</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse4">
              <div class="pct-content">
                <div class="theme-color themepreset-color boxwidthpreset theme-container">
                  <a href="#!" class="active" onclick="change_box_container('false')" data-value="false"><span><img src="../assets/images/customization/default.svg" alt="img"></span><span>Fluid</span></a>
                  <a href="#!" class="" onclick="change_box_container('true')" data-value="true"><span><img src="../assets/images/customization/container.svg" alt="img"></span><span>Container</span></a>
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse5">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-typography f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Font Family</h6>
                  <span>Choose your font family.</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse5">
              <div class="pct-content">
                <div class="theme-color fontpreset-color">
                  <a href="#!" class="active" onclick="font_change('Public-Sans')" data-value="Public-Sans"
                    ><span>Aa</span><span>Public Sans</span></a
                  >
                  <a href="#!" class="" onclick="font_change('Roboto')" data-value="Roboto"><span>Aa</span><span>Roboto</span></a>
                  <a href="#!" class="" onclick="font_change('Poppins')" data-value="Poppins"><span>Aa</span><span>Poppins</span></a>
                  <a href="#!" class="" onclick="font_change('Inter')" data-value="Inter"><span>Aa</span><span>Inter</span></a>
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="collapse show">
              <div class="pct-content">
                <div class="d-grid">
                  <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>
<!-- [Body] end -->

</html>