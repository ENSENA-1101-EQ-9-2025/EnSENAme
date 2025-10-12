<?php
// El chat ahora funciona con chat_api.php y la base de datos
// Debes tener $_SESSION['txtdoc'] con el ID del usuario actual
// El ID del usuario destino se puede definir por GET o por defecto (ejemplo: admin = 5555)
session_start();
$usuarioActual = isset($_SESSION['txtdoc']) ? intval($_SESSION['txtdoc']) : 0;
$usuarioDestino = isset($_GET['para']) ? intval($_GET['para']) : 5555; // Cambia 5555 por el ID destino real
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
  <div class="mb-2">
    <span class="fw-bold">Bienvenido, <?php echo isset($_SESSION['display_name']) ? htmlspecialchars($_SESSION['display_name']) : (isset($_SESSION['primer_nombre']) ? htmlspecialchars($_SESSION['primer_nombre']) : 'Usuario'); ?></span>
  </div>
  <div class="mb-3">
  <label for="usuarioDestino" class="form-label">Destino para <?php echo htmlspecialchars(isset($_SESSION['display_name']) ? $_SESSION['display_name'] : (isset($_SESSION['primer_nombre']) ? $_SESSION['primer_nombre'] : 'Usuario')); ?>:</label>
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
        div.innerHTML = `<strong>${msg.de_usuario == usuarioActual ? 'Tú' : 'Otro'}:</strong> ${msg.mensaje} <br><small>${msg.fecha}</small>`;
        box.appendChild(div);
      });
      box.scrollTop = box.scrollHeight;
    }
    // Evento: cambiar usuario destino recarga el chat
    document.getElementById("usuarioDestino").addEventListener("change", loadChat);
    // Cargar usuarios al iniciar
    cargarUsuarios();

    // Evento: enviar mensaje
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
      // Limpiar el input y recargar el chat
      e.target.reset();
      actualizarChat();
    });

    // Función para actualizar el chat periódicamente
    function actualizarChat() {
      loadChat();
    }
    // Recargar el chat cada 3 segundos
    setInterval(actualizarChat, 3000); // refresca cada 3 segundos
    // Cargar el chat al abrir la página
    actualizarChat();
  </script>
</body>
</html>
