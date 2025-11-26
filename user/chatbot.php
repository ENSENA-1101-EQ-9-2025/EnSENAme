<?php
require_once __DIR__ . '/../includes/session.php';

// Verificar si el usuario está logueado
if (empty($_SESSION['txtdoc'])) {
    header('Location: ../login.php');
    exit();
}

include '../conexion.php';

// Obtener información del usuario desde la base de datos
$doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
$res = mysqli_query($conexion, "SELECT p_nombre, s_nombre, p_apellido, s_apellido FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
if ($row = mysqli_fetch_assoc($res)) {
    $nombre = $row['p_nombre'];
    $nombre_completo = trim($row['p_nombre'] . ' ' . $row['s_nombre'] . ' ' . $row['p_apellido'] . ' ' . $row['s_apellido']);
} else {
    $nombre = 'Usuario';
    $nombre_completo = 'Usuario';
}

if (empty($nombre)) {
    $nombre = 'Usuario';
}
if (empty($nombre_completo)) {
    $nombre_completo = 'Usuario';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>EnSEÑAme - Asistente Virtual</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Asistente Virtual EnSEÑAme - Aprende sobre sordera, LSC y la comunidad sorda.">
  <meta name="keywords" content="Chatbot, EnSEÑAme, Asistente Virtual, LSC, Lenguaje de Señas, Sordera">
  <meta name="author" content="EnSEÑAme Team">

  <link rel="icon" href="../admin/assets/images/favisena.png" type="image/x-icon"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="../admin/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="../admin/assets/fonts/feather.css">
  <link rel="stylesheet" href="../admin/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="../admin/assets/fonts/material.css">
  <link rel="stylesheet" href="../admin/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="../admin/assets/css/style-preset.css">
  
  <style>
    .chatbot-hero {
      background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
      color: white;
      border-radius: 15px;
      padding: 3rem 2rem;
      margin-bottom: 2rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    
    .chatbot-hero::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
    
    .chatbot-hero h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      position: relative;
      z-index: 1;
    }
    
    .chatbot-hero p {
      font-size: 1.2rem;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }
    
    .chat-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      overflow: hidden;
      height: 600px;
      display: flex;
      flex-direction: column;
    }
    
    .chat-header {
      background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
      color: white;
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    
    .chat-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
    }
    
    .chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 1.5rem;
      background: #f8f9fa;
    }
    
    .message {
      margin-bottom: 1rem;
      display: flex;
      gap: 0.75rem;
    }
    
    .message.user {
      flex-direction: row-reverse;
    }
    
    .message-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    
    .message.user .message-avatar {
      background: #007bff;
      color: white;
    }
    
    .message.bot .message-avatar {
      background: #4CAF50;
      color: white;
    }
    
    .message-content {
      max-width: 70%;
      padding: 0.75rem 1rem;
      border-radius: 15px;
      position: relative;
    }
    
    .message.user .message-content {
      background: #007bff;
      color: white;
      border-bottom-right-radius: 5px;
    }
    
    .message.bot .message-content {
      background: white;
      color: #333;
      border: 1px solid #e9ecef;
      border-bottom-left-radius: 5px;
    }
    
    .message-time {
      font-size: 0.75rem;
      opacity: 0.7;
      margin-top: 0.25rem;
    }
    
    .chat-input {
      padding: 1rem 1.5rem;
      background: white;
      border-top: 1px solid #e9ecef;
    }
    
    .suggestions {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-top: 1rem;
    }
    
    .suggestion-btn {
      background: rgba(76, 175, 80, 0.1);
      border: 1px solid #4CAF50;
      color: #4CAF50;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.875rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .suggestion-btn:hover {
      background: #4CAF50;
      color: white;
      transform: translateY(-2px);
    }
    
    .typing-indicator {
      display: none;
      padding: 0.5rem 1rem;
      font-style: italic;
      color: #6c757d;
    }
    
    .typing-indicator .dots::after {
      content: '';
      animation: dots 1.5s steps(3, end) infinite;
    }
    
    @keyframes dots {
      0%, 20% { content: '.'; }
      40% { content: '..'; }
      60%, 100% { content: '...'; }
    }
    
    .quick-actions {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }
    
    .quick-action-card {
      background: white;
      border-radius: 10px;
      padding: 1.5rem;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      cursor: pointer;
      border: 2px solid transparent;
    }
    
    .quick-action-card:hover {
      transform: translateY(-5px);
      border-color: #4CAF50;
      box-shadow: 0 8px 25px rgba(76, 175, 80, 0.2);
    }
    
    .quick-action-icon {
      font-size: 2.5rem;
      color: #4CAF50;
      margin-bottom: 1rem;
    }
    
    .quick-action-title {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #333;
    }
    
    .quick-action-desc {
      color: #6c757d;
      font-size: 0.9rem;
    }
  </style>
</head>

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
          <img src="../admin/assets/images/logoensenamenobg.png" class="img-fluid logo-lg" alt="EnSEÑAme" style="max-height: 40px;">
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
              <span class="pc-mtext">Guías LSC</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="chatbot.php" class="pc-link active">
              <span class="pc-micon"><i class="ti ti-robot"></i></span>
              <span class="pc-mtext">Asistente IA</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="chat.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-brand-hipchat"></i></span>
              <span class="pc-mtext">Chat Comunitario</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="servicio.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-headset"></i></span>
              <span class="pc-mtext">Servicios</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
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
                    <h6 class="mb-1"><?php echo htmlspecialchars($nombre_completo); ?></h6>
                    <span>Usuario</span>
                  </div>
                </div>
              </div>
              <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="drp-t1" data-bs-toggle="tab" data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1" aria-selected="true">
                    <i class="ti ti-user"></i> Perfil
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2" type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false">
                    <i class="ti ti-settings"></i> Configuración
                  </button>
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
                  <a href="editarperfil.php" class="dropdown-item">
                    <i class="ti ti-user"></i>
                    <span>Configuración de Cuenta</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-help"></i>
                    <span>Soporte</span>
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
              <div class="page-header-title">
                <h2 class="mb-0">Asistente IA EnSEÑAme</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <div class="col-12">
          <!-- Hero Section -->
          <div class="chatbot-hero">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h1>🤖 ¡Hola <?php echo htmlspecialchars($nombre); ?>!</h1>
                <p>Soy tu asistente IA especializado en sordera, LSC y la comunidad sorda. Tengo conocimiento avanzado y puedo responder preguntas complejas sobre estos temas.</p>
              </div>
              <div class="col-md-4 text-center">
                <div style="font-size: 5rem; opacity: 0.8;">
                  <i class="ti ti-robot"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="row">
        <div class="col-12">
          <h4 class="mb-3">¿Sobre qué te gustaría aprender?</h4>
          <div class="quick-actions">
            <div class="quick-action-card" onclick="enviarPreguntaRapida('¿Qué es la sordera?')">
              <div class="quick-action-icon">
                <i class="ti ti-ear"></i>
              </div>
              <div class="quick-action-title">¿Qué es la sordera?</div>
              <div class="quick-action-desc">Aprende sobre la definición, tipos y características de la sordera</div>
            </div>
            
            <div class="quick-action-card" onclick="enviarPreguntaRapida('¿Qué es la LSC?')">
              <div class="quick-action-icon">
                <i class="ti ti-language"></i>
              </div>
              <div class="quick-action-title">Lengua de Señas</div>
              <div class="quick-action-desc">Descubre todo sobre la Lengua de Señas Colombiana (LSC)</div>
            </div>
            
            <div class="quick-action-card" onclick="enviarPreguntaRapida('¿Cómo comunicarse con personas sordas?')">
              <div class="quick-action-icon">
                <i class="ti ti-messages"></i>
              </div>
              <div class="quick-action-title">Comunicación</div>
              <div class="quick-action-desc">Consejos para comunicarte efectivamente con personas sordas</div>
            </div>
            
            <div class="quick-action-card" onclick="enviarPreguntaRapida('Cultura de la comunidad sorda')">
              <div class="quick-action-icon">
                <i class="ti ti-users"></i>
              </div>
              <div class="quick-action-title">Cultura Sorda</div>
              <div class="quick-action-desc">Conoce la rica cultura y valores de la comunidad sorda</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Chat Interface -->
      <div class="row">
        <div class="col-12">
          <div class="chat-container">
            <div class="chat-header">
              <div class="chat-avatar">
                <i class="ti ti-robot"></i>
              </div>
              <div>
                <h5 class="mb-0">Asistente EnSEÑAme</h5>
                <small class="opacity-75">Especialista en sordera y LSC</small>
              </div>
              <div class="ms-auto">
                <button class="btn btn-light btn-sm" onclick="limpiarChat()">
                  <i class="ti ti-refresh"></i> Limpiar
                </button>
              </div>
            </div>
            
            <div class="chat-messages" id="chat-messages">
              <div class="message bot">
                <div class="message-avatar">
                  <i class="ti ti-robot"></i>
                </div>
                <div class="message-content">
                  <div>¡Hola! Soy tu asistente virtual de EnSEÑAme. Puedo ayudarte con información sobre:</div>
                  <div class="suggestions">
                    <button class="suggestion-btn" onclick="enviarPreguntaRapida('Causas de la sordera')">Causas de la sordera</button>
                    <button class="suggestion-btn" onclick="enviarPreguntaRapida('Tecnologías de apoyo')">Tecnologías de apoyo</button>
                    <button class="suggestion-btn" onclick="enviarPreguntaRapida('Mitos sobre la sordera')">Mitos y realidades</button>
                  </div>
                  <div class="message-time"><?php echo date('H:i'); ?></div>
                </div>
              </div>
            </div>
            
            <div class="typing-indicator" id="typing-indicator">
              <div class="message bot">
                <div class="message-avatar">
                  <i class="ti ti-robot"></i>
                </div>
                <div class="message-content">
                  <div>Escribiendo<span class="dots"></span></div>
                </div>
              </div>
            </div>
            
            <div class="chat-input">
              <form id="chat-form">
                <div class="input-group">
                  <input type="text" class="form-control" id="message-input" placeholder="Escribe tu pregunta aquí..." autocomplete="off">
                  <button type="submit" class="btn btn-primary">
                    <i class="ti ti-send"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">EnSEÑAme &#9829; desarrollado por el Equipo EnSEÑAme</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Required Js -->
  <script src="../admin/assets/js/plugins/popper.min.js"></script>
  <script src="../admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../admin/assets/js/fonts/custom-font.js"></script>
  <script src="../admin/assets/js/pcoded.js"></script>
  <script src="../admin/assets/js/plugins/feather.min.js"></script>

  <script>
    function enviarPreguntaRapida(pregunta) {
      document.getElementById('message-input').value = pregunta;
      document.getElementById('chat-form').dispatchEvent(new Event('submit'));
    }

    function limpiarChat() {
      const chatMessages = document.getElementById('chat-messages');
      chatMessages.innerHTML = `
        <div class="message bot">
          <div class="message-avatar">
            <i class="ti ti-robot"></i>
          </div>
          <div class="message-content">
            <div>¡Hola de nuevo! ¿En qué puedo ayudarte hoy?</div>
            <div class="suggestions">
              <button class="suggestion-btn" onclick="enviarPreguntaRapida('¿Qué es la sordera?')">¿Qué es la sordera?</button>
              <button class="suggestion-btn" onclick="enviarPreguntaRapida('¿Qué es la LSC?')">¿Qué es la LSC?</button>
              <button class="suggestion-btn" onclick="enviarPreguntaRapida('Cultura sorda')">Cultura sorda</button>
            </div>
            <div class="message-time">${new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</div>
          </div>
        </div>
      `;
    }

    function agregarMensajeUsuario(mensaje) {
      const chatMessages = document.getElementById('chat-messages');
      const tiempo = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
      
      const messageDiv = document.createElement('div');
      messageDiv.className = 'message user';
      messageDiv.innerHTML = `
        <div class="message-avatar">
          <i class="ti ti-user"></i>
        </div>
        <div class="message-content">
          <div>${mensaje}</div>
          <div class="message-time">${tiempo}</div>
        </div>
      `;
      
      chatMessages.appendChild(messageDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function agregarMensajeChatbot(respuesta, sugerencias = []) {
      const chatMessages = document.getElementById('chat-messages');
      const tiempo = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
      
      const messageDiv = document.createElement('div');
      messageDiv.className = 'message bot';
      
      let sugerenciasHtml = '';
      if (sugerencias && sugerencias.length > 0) {
        sugerenciasHtml = `
          <div class="suggestions">
            ${sugerencias.slice(0, 3).map(sugerencia => 
              `<button class="suggestion-btn" onclick="enviarPreguntaRapida('${sugerencia.replace(/'/g, "\\'")}')">${sugerencia}</button>`
            ).join('')}
          </div>
        `;
      }
      
      messageDiv.innerHTML = `
        <div class="message-avatar">
          <i class="ti ti-robot"></i>
        </div>
        <div class="message-content">
          <div>${respuesta.replace(/\n/g, '<br>')}</div>
          ${sugerenciasHtml}
          <div class="message-time">${tiempo}</div>
        </div>
      `;
      
      chatMessages.appendChild(messageDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function mostrarIndicadorEscritura() {
      document.getElementById('typing-indicator').style.display = 'block';
      const chatMessages = document.getElementById('chat-messages');
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function ocultarIndicadorEscritura() {
      document.getElementById('typing-indicator').style.display = 'none';
    }

    // Event Listeners
    document.getElementById('chat-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const messageInput = document.getElementById('message-input');
      const mensaje = messageInput.value.trim();
      
      if (!mensaje) return;
      
      // Agregar mensaje del usuario
      agregarMensajeUsuario(mensaje);
      messageInput.value = '';
      
      // Mostrar indicador de escritura
      mostrarIndicadorEscritura();
      
      // Enviar al chatbot
  fetch('../chatbot_api.php?ts=' + Date.now(), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          mensaje: mensaje,
          usuario_id: <?php echo json_encode($_SESSION['txtdoc'] ?? 0); ?>
        })
      })
      .then(response => response.json())
      .then(data => {
        ocultarIndicadorEscritura();
        
        if (data.success) {
          agregarMensajeChatbot(data.respuesta, data.sugerencias);
        } else {
          agregarMensajeChatbot('🤖 Lo siento, no pude procesar tu mensaje. ¿Podrías intentarlo de nuevo?');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        ocultarIndicadorEscritura();
        agregarMensajeChatbot('🤖 Error de conexión. Por favor, inténtalo más tarde.');
      });
    });

    // Enter para enviar mensaje
    document.getElementById('message-input').addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('chat-form').dispatchEvent(new Event('submit'));
      }
    });
  </script>

  <script>
    // scroll-block
    var tc = document.querySelectorAll('.scroll-block');
    for (var t = 0; t < tc.length; t++) {
      new SimpleBar(tc[t]);
    }
  </script>
</body>
</html>