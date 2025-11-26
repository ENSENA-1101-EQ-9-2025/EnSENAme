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

// Crear tabla de logs si no existe
$createTable = "CREATE TABLE IF NOT EXISTS `tb_chatbot_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `pregunta` TEXT NOT NULL,
    `respuesta` TEXT NOT NULL,
    `es_admin` BOOLEAN DEFAULT FALSE,
    `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_usuario_fecha` (`usuario_id`, `fecha`),
    INDEX `idx_admin` (`es_admin`, `fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci";

mysqli_query($conexion, $createTable);

// Obtener estadísticas
$stats = [];

// Total de usuarios
$query = "SELECT COUNT(*) as total FROM tb_usuarios";
$result = mysqli_query($conexion, $query);
$stats['total_usuarios'] = mysqli_fetch_assoc($result)['total'];

// Total de interacciones del chatbot
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs";
$result = mysqli_query($conexion, $query);
$stats['total_interacciones'] = mysqli_fetch_assoc($result)['total'];

// Interacciones de hoy
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE DATE(timestamp) = CURDATE()";
$result = mysqli_query($conexion, $query);
$stats['interacciones_hoy'] = mysqli_fetch_assoc($result)['total'];

// Interacciones de esta semana
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE WEEK(timestamp) = WEEK(NOW()) AND YEAR(timestamp) = YEAR(NOW())";
$result = mysqli_query($conexion, $query);
$stats['interacciones_semana'] = mysqli_fetch_assoc($result)['total'];

// Usuarios administradores
$query = "SELECT COUNT(*) as total FROM tb_usuarios WHERE id_rol = 1";
$result = mysqli_query($conexion, $query);
$stats['total_admins'] = mysqli_fetch_assoc($result)['total'];

// Consultas administrativas
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE origen = 'admin'";
$result = mysqli_query($conexion, $query);
$stats['consultas_admin'] = mysqli_fetch_assoc($result)['total'];

// Preguntas más frecuentes (top 5)
$query = "SELECT mensaje_usuario, COUNT(*) as frecuencia FROM tb_chatbot_logs GROUP BY mensaje_usuario ORDER BY frecuencia DESC LIMIT 5";
$result = mysqli_query($conexion, $query);
$preguntas_frecuentes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $preguntas_frecuentes[] = $row;
}

// Actividad por horas (últimas 24 horas)
$query = "SELECT HOUR(timestamp) as hora, COUNT(*) as total FROM tb_chatbot_logs WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY HOUR(timestamp) ORDER BY hora";
$result = mysqli_query($conexion, $query);
$actividad_hora = [];
for ($i = 0; $i < 24; $i++) {
    $actividad_hora[$i] = 0;
}
while ($row = mysqli_fetch_assoc($result)) {
    $actividad_hora[$row['hora']] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>EnSEÑAme - Estadísticas del Chatbot</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Panel de administración - Estadísticas del Chatbot EnSEÑAme">
    <meta name="keywords" content="Admin, Estadísticas, Chatbot, EnSEÑAme, Analytics">
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
        .stats-hero {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #28a745;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #28a745;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            position: relative;
            height: 400px; /* Altura fija para la gráfica */
        }
        
        .chart-container canvas {
            max-height: 300px !important;
            height: 300px !important;
        }
        
        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .frequent-questions {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .question-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid #28a745;
        }
        
        .question-text {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.25rem;
        }
        
        .question-count {
            color: #28a745;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .refresh-btn {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .refresh-btn:hover {
            transform: scale(1.05);
        }
        
        /* Responsive design para móviles */
        @media (max-width: 768px) {
            .chart-container {
                padding: 1rem;
                height: 350px;
            }
            
            .chart-wrapper {
                height: 250px;
            }
            
            .chart-container canvas {
                max-height: 250px !important;
                height: 250px !important;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .chart-container {
                padding: 0.75rem;
                height: 300px;
            }
            
            .chart-wrapper {
                height: 200px;
            }
            
            .chart-container canvas {
                max-height: 200px !important;
                height: 200px !important;
            }
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
                        <a href="asistente_virtual.php" class="pc-link">
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
                        <a href="chatbot_stats.php" class="pc-link active">
                            <span class="pc-micon"><i class="ti ti-chart-line"></i></span>
                            <span class="pc-mtext">Estadísticas IA</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="servicio.php" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-headset"></i></span>
                            <span class="pc-mtext">Servicios</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="../../IA/index.php" class="pc-link" target="_blank">
                            <span class="pc-micon"><i class="ti ti-brain"></i></span>
                            <span class="pc-mtext">Sistema IA</span>
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
                                <h2 class="mb-0">Estadísticas del Chatbot</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-12">
                    <!-- Stats Hero Section -->
                    <div class="stats-hero">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1>📊 Panel de Estadísticas</h1>
                                <p>Monitoreo completo del asistente virtual EnSEÑAme y análisis de interacciones.</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <button class="refresh-btn" onclick="location.reload()">
                                    <i class="ti ti-refresh"></i> Actualizar Datos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Generales -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['total_usuarios']; ?></div>
                        <div class="stat-label">Total Usuarios</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['total_interacciones']; ?></div>
                        <div class="stat-label">Total Interacciones</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['interacciones_hoy']; ?></div>
                        <div class="stat-label">Consultas Hoy</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['interacciones_semana']; ?></div>
                        <div class="stat-label">Esta Semana</div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['total_admins']; ?></div>
                        <div class="stat-label">Administradores</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['consultas_admin']; ?></div>
                        <div class="stat-label">Consultas Admin</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['total_usuarios'] - $stats['total_admins']; ?></div>
                        <div class="stat-label">Usuarios Regulares</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['total_interacciones'] - $stats['consultas_admin']; ?></div>
                        <div class="stat-label">Consultas Regulares</div>
                    </div>
                </div>
            </div>

            <!-- Actividad por Hora -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="chart-container">
                        <h4 class="mb-3">Actividad por Hora (Últimas 24h)</h4>
                        <div class="chart-wrapper">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preguntas Frecuentes -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="frequent-questions">
                        <h4 class="mb-3">Preguntas Más Frecuentes</h4>
                        <?php if (empty($preguntas_frecuentes)): ?>
                            <div class="text-center py-4">
                                <i class="ti ti-message-circle f-48 text-muted mb-3"></i>
                                <h5>No hay interacciones registradas</h5>
                                <p class="text-muted">Las estadísticas aparecerán cuando los usuarios comiencen a interactuar con el chatbot.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($preguntas_frecuentes as $pregunta): ?>
                                <div class="question-item">
                                    <div class="question-text"><?php echo htmlspecialchars($pregunta['mensaje_usuario']); ?></div>
                                    <div class="question-count"><?php echo $pregunta['frecuencia']; ?> veces</div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Logs Recientes -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Interacciones Recientes</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Pregunta</th>
                                            <th>Tipo</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT l.*, u.p_nombre, u.p_apellido FROM tb_chatbot_logs l 
                                                 LEFT JOIN tb_usuarios u ON l.usuario_id = u.ID 
                                                 ORDER BY l.timestamp DESC LIMIT 10";
                                        $result = mysqli_query($conexion, $query);
                                        
                                        if (mysqli_num_rows($result) > 0):
                                            while ($log = mysqli_fetch_assoc($result)):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($log['p_nombre'] . ' ' . $log['p_apellido']); ?></td>
                                                <td><?php echo htmlspecialchars(substr($log['mensaje_usuario'], 0, 50)) . (strlen($log['mensaje_usuario']) > 50 ? '...' : ''); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $log['origen'] == 'admin' ? 'warning' : 'primary'; ?>">
                                                        <?php echo $log['origen'] == 'admin' ? 'Admin' : 'Usuario'; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($log['timestamp'])); ?></td>
                                            </tr>
                                        <?php 
                                            endwhile;
                                        else:
                                        ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No hay interacciones registradas</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Crear gráfico de actividad por hora
        const ctx = document.getElementById('activityChart').getContext('2d');
        const activityData = <?php echo json_encode(array_values($actividad_hora)); ?>;
        const hours = <?php echo json_encode(array_keys($actividad_hora)); ?>;
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: hours.map(h => h + ':00'),
                datasets: [{
                    label: 'Interacciones',
                    data: activityData,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            maxTicksLimit: 6
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#28a745',
                        borderWidth: 1
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    }
                }
            }
        });

        // Auto-refresh cada 5 minutos
        setTimeout(function() {
            location.reload();
        }, 300000);
    </script>
</body>
</html>