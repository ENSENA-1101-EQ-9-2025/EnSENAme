<?php
session_start();

if (empty($_SESSION['txtdoc'])) {
    header('Location: ../../login.php');
    exit();
}

include "../../conexion.php";

// Verificar si el usuario es administrador
$doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
$query = "SELECT p.*, r.nombre_rol FROM tb_usuarios p LEFT JOIN tbl_rol r ON p.id_rol = r.id WHERE p.ID = '$doc' AND p.id_rol = 1 LIMIT 1";
$result = mysqli_query($conexion, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: ../../error.php');
    exit();
}

$admin = mysqli_fetch_assoc($result);
$nombre_admin = $admin['p_nombre'] . ' ' . $admin['p_apellido'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>EnSEÑAme - Asistente Virtual Administrativo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Panel de administración - Asistente Virtual EnSEÑAme">
    <meta name="keywords" content="Admin, Chatbot, EnSEÑAme, Asistente Virtual, Panel de Control">
    <meta name="author" content="EnSEÑAme Team">

    <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="../assets/fonts/feather.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="../assets/fonts/material.css">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="../assets/css/style-preset.css">
    
    <style>
        .admin-hero {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            color: white;
            border-radius: 15px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .admin-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        
        .admin-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .admin-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #1976d2;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1976d2;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .admin-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .admin-action-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .admin-action-card:hover {
            transform: translateY(-5px);
            border-color: #1976d2;
            box-shadow: 0 8px 25px rgba(25, 118, 210, 0.2);
        }
        
        .admin-action-icon {
            font-size: 2.5rem;
            color: #1976d2;
            margin-bottom: 1rem;
        }
        
        .chat-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            height: 500px;
            display: flex;
            flex-direction: column;
        }
        
        .chat-header {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
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
        
        .message.admin {
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
        
        .message.admin .message-avatar {
            background: #1976d2;
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
        
        .message.admin .message-content {
            background: #1976d2;
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .message.bot .message-content {
            background: white;
            color: #333;
            border: 1px solid #e9ecef;
            border-bottom-left-radius: 5px;
        }
        
        .admin-badge {
            background: linear-gradient(45deg, #ff9800, #f57c00);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
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
                    <img src="../assets/images/logoensenamenobg.png" class="img-fluid logo-lg" alt="EnSEÑAme" style="max-height: 40px;">
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
                        <ul class="pc-submenu" style="display: none;">
                            <li class="pc-item"><a href="crear.php" class="pc-link"><span class="pc-mtext">Agregar usuario</span></a></li>
                            <li class="pc-item"><a href="usuarios.php" class="pc-link"><span class="pc-mtext">Ver usuarios</span></a></li>
                        </ul>
                    </li>
                    <li class="pc-item">
                        <a href="producto.php" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-book"></i></span>
                            <span class="pc-mtext">Guías</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="asistente_virtual.php" class="pc-link active">
                            <span class="pc-micon"><i class="ti ti-robot"></i></span>
                            <span class="pc-mtext">Asistente Virtual</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="chat.php" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-brand-hipchat"></i></span>
                            <span class="pc-mtext">Chat</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="chatbot_stats.php" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-chart-line"></i></span>
                            <span class="pc-mtext">Estadísticas IA</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="servicio.php" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-message-circle"></i></span>
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
                            <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar">
                            <span><?php echo htmlspecialchars($nombre_admin); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <h6>Administrador</h6>
                                <span><?php echo htmlspecialchars($nombre_admin); ?></span>
                            </div>
                            <a href="logout.php" class="dropdown-item">
                                <i class="ti ti-power"></i>
                                <span>Cerrar Sesión</span>
                            </a>
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
                                <h2 class="mb-0">Asistente Virtual Administrativo</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-12">
                    <!-- Admin Hero Section -->
                    <div class="admin-hero">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1>👨‍💼 Panel de Administración</h1>
                                <p>Acceso completo al asistente virtual con funciones administrativas avanzadas y monitoreo del sistema.</p>
                                <span class="admin-badge">MODO ADMINISTRADOR</span>
                            </div>
                            <div class="col-md-4 text-center">
                                <div style="font-size: 5rem; opacity: 0.8;">
                                    <i class="ti ti-shield-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-3">Estadísticas del Sistema</h4>
                    <div class="admin-stats" id="admin-stats">
                        <div class="stat-card">
                            <div class="stat-number" id="total-usuarios">-</div>
                            <div class="stat-label">Total Usuarios</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="interacciones-hoy">-</div>
                            <div class="stat-label">Consultas Hoy</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="total-interacciones">-</div>
                            <div class="stat-label">Total Interacciones</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="usuarios-activos">-</div>
                            <div class="stat-label">Usuarios Activos</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-3">Consultas Administrativas</h4>
                    <div class="admin-actions">
                        <div class="admin-action-card" onclick="enviarConsultaAdmin('Ayuda administrativa')">
                            <div class="admin-action-icon">
                                <i class="ti ti-help-circle"></i>
                            </div>
                            <div class="admin-action-title">Ayuda del Sistema</div>
                            <div class="admin-action-desc">Obtener ayuda sobre funciones administrativas</div>
                        </div>
                        
                        <div class="admin-action-card" onclick="enviarConsultaAdmin('Estado de usuarios')">
                            <div class="admin-action-icon">
                                <i class="ti ti-users"></i>
                            </div>
                            <div class="admin-action-title">Gestión de Usuarios</div>
                            <div class="admin-action-desc">Información sobre usuarios registrados</div>
                        </div>
                        
                        <div class="admin-action-card" onclick="enviarConsultaAdmin('Logs del sistema')">
                            <div class="admin-action-icon">
                                <i class="ti ti-file-text"></i>
                            </div>
                            <div class="admin-action-title">Logs del Chatbot</div>
                            <div class="admin-action-desc">Revisar registros de interacciones</div>
                        </div>
                        
                        <div class="admin-action-card" onclick="enviarConsultaAdmin('¿Qué es la sordera?')">
                            <div class="admin-action-icon">
                                <i class="ti ti-brain"></i>
                            </div>
                            <div class="admin-action-title">Consulta Educativa</div>
                            <div class="admin-action-desc">Acceso a toda la base de conocimientos</div>
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
                                <h5 class="mb-0">Asistente EnSEÑAme - Modo Administrador</h5>
                                <small class="opacity-75">Acceso completo a funciones educativas y administrativas</small>
                            </div>
                            <div class="ms-auto">
                                <span class="admin-badge">ADMIN</span>
                                <button class="btn btn-light btn-sm ms-2" onclick="limpiarChat()">
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
                                    <div>👨‍💼 <strong>¡Bienvenido al panel administrativo!</strong><br><br>
                                    Como administrador, tienes acceso a:<br>
                                    • Todas las funciones educativas estándar<br>
                                    • Información administrativa del sistema<br>
                                    • Estadísticas y logs de usuarios<br>
                                    • Monitoreo de interacciones del chatbot</div>
                                    <div class="message-time"><?php echo date('H:i'); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="typing-indicator" id="typing-indicator" style="display: none;">
                            <div class="message bot">
                                <div class="message-avatar">
                                    <i class="ti ti-robot"></i>
                                </div>
                                <div class="message-content">
                                    <div>Procesando consulta administrativa<span class="dots">...</span></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="chat-input">
                            <form id="chat-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="message-input" placeholder="Escribe tu consulta administrativa o educativa..." autocomplete="off">
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
                    <p class="m-0">EnSEÑAme &#9829; Panel de Administración</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>

    <script>
        // Cargar estadísticas al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarEstadisticas();
        });

        function cargarEstadisticas() {
            // Simulamos la carga de estadísticas
            // En una implementación real, esto vendría de una API
            
            // Total usuarios
            fetch('../../conexion.php')
                .then(() => {
                    // Simular datos
                    document.getElementById('total-usuarios').textContent = '<?php
                        $count_users = mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_usuarios");
                        echo mysqli_fetch_assoc($count_users)["total"];
                    ?>';
                    
                    document.getElementById('interacciones-hoy').textContent = '<?php
                        $logs_check = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_chatbot_logs'");
                        if (mysqli_num_rows($logs_check) > 0) {
                            $today_logs = mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE DATE(fecha) = CURDATE()");
                            echo mysqli_fetch_assoc($today_logs)["total"];
                        } else {
                            echo "0";
                        }
                    ?>';
                    
                    document.getElementById('total-interacciones').textContent = '<?php
                        if (mysqli_num_rows($logs_check) > 0) {
                            $total_logs = mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs");
                            echo mysqli_fetch_assoc($total_logs)["total"];
                        } else {
                            echo "0";
                        }
                    ?>';
                    
                    document.getElementById('usuarios-activos').textContent = '<?php
                        $active_users = mysqli_query($conexion, "SELECT COUNT(DISTINCT ID) as total FROM tb_usuarios WHERE DATE(CURDATE()) = CURDATE()");
                        echo mysqli_fetch_assoc($active_users)["total"];
                    ?>';
                })
                .catch(() => {
                    // Valores por defecto si hay error
                    document.getElementById('total-usuarios').textContent = '0';
                    document.getElementById('interacciones-hoy').textContent = '0';
                    document.getElementById('total-interacciones').textContent = '0';
                    document.getElementById('usuarios-activos').textContent = '0';
                });
        }

        function enviarConsultaAdmin(consulta) {
            document.getElementById('message-input').value = consulta;
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
                        <div>👨‍💼 <strong>Panel administrativo reiniciado.</strong><br><br>¿En qué puedo ayudarte como administrador?</div>
                        <div class="message-time">${new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</div>
                    </div>
                </div>
            `;
        }

        function agregarMensajeAdmin(mensaje) {
            const chatMessages = document.getElementById('chat-messages');
            const tiempo = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message admin';
            messageDiv.innerHTML = `
                <div class="message-avatar">
                    <i class="ti ti-user-shield"></i>
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
                    <div class="mt-2">
                        <small class="text-muted">Sugerencias:</small><br>
                        ${sugerencias.slice(0, 3).map(sugerencia => 
                            `<button class="btn btn-outline-primary btn-sm me-1 mt-1" onclick="enviarConsultaAdmin('${sugerencia.replace(/'/g, "\\'")}')">${sugerencia}</button>`
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
            
            // Agregar mensaje del admin
            agregarMensajeAdmin(mensaje);
            messageInput.value = '';
            
            // Mostrar indicador de escritura
            mostrarIndicadorEscritura();
            
            // Enviar al chatbot con modo admin
            fetch('../../chatbot_api.php?ts=' + Date.now(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    mensaje: mensaje,
                    usuario_id: <?php echo json_encode($_SESSION['txtdoc'] ?? 0); ?>,
                    es_admin: true
                })
            })
                        .then(async response => {
                            const text = await response.text();
                            try { return JSON.parse(text); } catch (e) { console.error('Respuesta no JSON:', text); throw e; }
                        })
            .then(data => {
                ocultarIndicadorEscritura();
                
                if (data.success) {
                    agregarMensajeChatbot(data.respuesta, data.sugerencias);
                } else {
                    agregarMensajeChatbot('🤖 Lo siento, no pude procesar tu consulta administrativa. ¿Podrías intentarlo de nuevo?');
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
</body>
</html>