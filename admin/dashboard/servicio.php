<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
include '../../conexion.php';
$nombre = '';
if (!empty($_SESSION['txtdoc'])) {
  $doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
  $res = mysqli_query($conexion, "SELECT p_nombre FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
  if ($row = mysqli_fetch_assoc($res)) {
    <?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
    include '../../conexion.php';
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
    <html lang="es">
    <head>
      <title>EnSEÑAme - Chat Admin</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
      <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
      <link rel="stylesheet" href="../assets/fonts/feather.css" >
      <link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
      <link rel="stylesheet" href="../assets/fonts/material.css" >
      <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
      <link rel="stylesheet" href="../assets/css/style-preset.css" >
    </head>
    <body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <nav class="pc-sidebar">
      <div class="navbar-wrapper">
        <div class="m-header">
          <a href="index.php" class="b-brand text-primary">
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
      <div class="header-wrapper">
        <div class="ms-auto">
          <ul class="list-unstyled">
            <li class="dropdown pc-h-item header-user-profile">
              <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
                <span><?php echo htmlspecialchars($nombre); ?></span>
              </a>
              <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-header">
                  <div class="d-flex mb-1">
                    <div class="flex-shrink-0">
                      <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h6 class="mb-1"><?php echo htmlspecialchars($nombre); ?></h6>
                      <span>Admin</span>
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
                    <a href="editarperfil.php" class="dropdown-item"><i class="ti ti-edit-circle"></i><span>Editar Perfil</span></a>
                    <a href="logout.php" class="dropdown-item"><i class="ti ti-power"></i><span>Salir</span></a>
                  </div>
                  <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
                    <a href="#" class="dropdown-item"><i class="ti ti-help"></i><span>Support</span></a>
                    <a href="#" class="dropdown-item"><i class="ti ti-user"></i><span>Account Settings</span></a>
                    <a href="#" class="dropdown-item"><i class="ti ti-messages"></i><span>Feedback</span></a>
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
        <h1>Chat en vivo (Admin)</h1>
        <div class="card">
          <div class="card-body">
            <div class="mb-3">
              <label for="usuarioDestino" class="form-label">Destino para <?php echo htmlspecialchars($nombre); ?>:</label>
              <select id="usuarioDestino" class="form-select"></select>
              <div id="errorUsuario" class="text-danger mt-1" style="display:none;"></div>
              <div id="errorSpam" class="text-danger mt-1" style="display:none;"></div>
            </div>
            <div id="chat-box" style="border:1px solid #ccc; height:400px; overflow-y:auto; padding:10px; background:#f9f9f9;"></div>
            <form id="chat-form" class="mt-3">
              <div class="input-group">
                <input type="text" name="mensaje" id="mensaje" class="form-control" placeholder="Escribe un mensaje...">
                <button class="btn btn-primary" type="submit">Enviar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
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
      setInterval(loadChat, 3000);
      loadChat();
    </script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    </body>
    </html>
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
      <div class="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="usuarioDestino" class="form-label">Destino para <?php echo htmlspecialchars($nombre); ?>:</label>
            <select id="usuarioDestino" class="form-select"></select>
            <div id="errorUsuario" class="text-danger mt-1" style="display:none;"></div>
            <div id="errorSpam" class="text-danger mt-1" style="display:none;"></div>
          </div>
          <div id="chat-box" style="border:1px solid #ccc; height:400px; overflow-y:auto; padding:10px; background:#f9f9f9;"></div>
          <form id="chat-form" class="mt-3">
            <div class="input-group">
              <input type="text" name="mensaje" id="mensaje" class="form-control" placeholder="Escribe un mensaje...">
              <button class="btn btn-primary" type="submit">Enviar</button>
            </div>
          </form>
        </div>
      </div>
      <script>
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
        setInterval(loadChat, 3000);
        loadChat();
      </script>
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
  <label for="usuarioDestino" class="form-label">Destino para <?php echo htmlspecialchars($nombre); ?>:</label>
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

>>>>>>> Stashed changes
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
  setInterval(loadChat, 3000);
  loadChat();
</script>
<script src="../assets/js/plugins/bootstrap.min.js"></script>
</body>
</html>
