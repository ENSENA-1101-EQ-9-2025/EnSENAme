<?php
session_start();
require_once '../../conexion.php';
if (!isset($_SESSION['id_usuario'])) {
  header('Location: ../../login.php');
  exit();
}
$id_usuario = $_SESSION['id_usuario'];
// Obtener datos del usuario activo
$sql = "SELECT * FROM usuarios WHERE id_usuario='$id_usuario'";
$res = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Usuario</title>
  <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon">
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
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fb;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      display: flex;
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }

    /* Lado izquierdo */
    .profile-sidebar {
      background: #eaf6ff;
      text-align: center;
      padding: 30px 20px;
      width: 300px;
    }

    .profile-sidebar img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    .profile-sidebar h2 {
      margin: 10px 0 5px;
    }

    .profile-sidebar p {
      color: #666;
      margin: 5px 0 20px;
    }

    .btn-change {
      background: #00bcd4;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
    }

    /* Lado derecho */
    .profile-form {
      flex: 1;
      padding: 30px;
    }

    .profile-form h3 {
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #444;
    }

    .form-group input, 
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    #fileInput {
  display: none;
}

  .btn-ir {
      background: #00bcd4;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
    }


  </style>
</head>
<body>

  <div class="profile-container">
    <!-- Perfil -->
    <div class="profile-sidebar">
      <img id="profileImage" src="../assets/images/user/avatar-2.jpg" alt="user-image">
  <h2><?php echo htmlspecialchars($usuario['primer_nombre']); ?></h2>
  <p><?php echo htmlspecialchars($usuario['primer_nombre']); ?></p>
      <button class="btn-change" onclick="document.getElementById('fileInput').click();">Cambiar Imagen</button>
      <input type="file" id="fileInput" accept="image/*" onchange="previewImage(event)">
    </div>

    <!-- Formulario -->
    <div class="profile-form">
      <h3>Información Personal</h3>
      
      <form method="post" action="editarperfil.php">
        <div class="form-group">
          <label for="tipo-doc">Tipo de Documento:</label>
          <select id="tipo-doc" name="tipo_doc">
            <option value="">Seleccione</option>
            <option value="C.C" <?php if($usuario['tipo_doc']==='C.C') echo 'selected'; ?>>C.C</option>
            <option value="T.I" <?php if($usuario['tipo_doc']==='T.I') echo 'selected'; ?>>T.I</option>
            <option value="N.N" <?php if($usuario['tipo_doc']==='N.N') echo 'selected'; ?>>N.N</option>
          </select>
        </div>
        <div class="form-group">
          <label for="num-doc">Número de Documento:</label>
          <input type="text" id="num-doc" name="num_doc" value="<?php echo htmlspecialchars($usuario['num_doc']); ?>">
        </div>
        <div class="form-group">
          <label for="primer-nombre">Primer Nombre:</label>
          <input type="text" id="primer-nombre" name="primer_nombre" value="<?php echo htmlspecialchars($usuario['primer_nombre']); ?>">
        </div>
        <div class="form-group">
          <label for="segundo-nombre">Segundo Nombre:</label>
          <input type="text" id="segundo-nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($usuario['segundo_nombre']); ?>">
        </div>
        <div class="form-group">
          <label for="primer-apellido">Primer Apellido:</label>
          <input type="text" id="primer-apellido" name="primer_apellido" value="<?php echo htmlspecialchars($usuario['primer_apellido']); ?>">
        </div>
        <div class="form-group">
          <label for="segundo-apellido">Segundo Apellido:</label>
          <input type="text" id="segundo-apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($usuario['segundo_apellido']); ?>">
        </div>
        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
        <br>
        <button type="submit" class="btn-ir">Guardar cambios</button>
      </form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario']) && $_POST['id_usuario'] == $id_usuario) {
  $tipo_doc = mysqli_real_escape_string($conexion, $_POST['tipo_doc']);
  $num_doc = mysqli_real_escape_string($conexion, $_POST['num_doc']);
  $primer_nombre = mysqli_real_escape_string($conexion, $_POST['primer_nombre']);
  $segundo_nombre = mysqli_real_escape_string($conexion, $_POST['segundo_nombre']);
  $primer_apellido = mysqli_real_escape_string($conexion, $_POST['primer_apellido']);
  $segundo_apellido = mysqli_real_escape_string($conexion, $_POST['segundo_apellido']);

  $sql_update = "UPDATE usuarios SET tipo_doc='$tipo_doc', num_doc='$num_doc', primer_nombre='$primer_nombre', segundo_nombre='$segundo_nombre', primer_apellido='$primer_apellido', segundo_apellido='$segundo_apellido' WHERE id_usuario='$id_usuario'";
  if (mysqli_query($conexion, $sql_update)) {
    $_SESSION['primer_nombre'] = $primer_nombre;
    $_SESSION['segundo_nombre'] = $segundo_nombre;
    $_SESSION['primer_apellido'] = $primer_apellido;
    $_SESSION['segundo_apellido'] = $segundo_apellido;
    echo '<script>alert("Datos actualizados correctamente");window.location.reload();</script>';
  } else {
    echo '<script>alert("Error al actualizar los datos");</script>';
  }
}
?>
    </div>
    <div style="text-align:center; margin-top:20px;">
      <a href="logout.php" class="btn-ir" style="background:#dc3545;">Cerrar sesión</a>
    </div>
  </div>

</body>
</html>

<script>
    function previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profileImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    }
  </script>