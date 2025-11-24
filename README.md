# 🤟 EnSEÑAme - Plataforma Educativa LSC

**Sistema de Gestión Educativa para la Lengua de Señas Colombiana (LSC)**

## 📋 Descripción

EnSEÑAme es una plataforma web integral diseñada para la comunidad sorda colombiana, que facilita el aprendizaje, la práctica y la gestión de recursos educativos relacionados con la Lengua de Señas Colombiana (LSC).

## 🚀 Características Principales

### 👥 Sistema de Usuarios y Seguridad
- **Roles diferenciados**: Administrador, Operador, Asesor.
- **Perfiles personalizables**: Fotos de perfil, información detallada.
- **Seguridad Avanzada**:
    - Contraseñas hasheadas con **Argon2**.
    - Sistema anti-brute force.
    - Gestión de contraseñas temporales para recuperación.
    - Validación dual (cliente + servidor).

### 💬 Sistema de Chat
- **Chat en tiempo real** entre usuarios.
- **Chatbot inteligente** con información sobre LSC.
- **Historial de conversaciones** persistente.
- **Estadísticas de uso** para administradores.

### 🤖 Inteligencia Artificial (LSC)
- **Reconocimiento en navegador**: TensorFlow.js + KNN (Sin necesidad de backend Python).
- **Versión Portable**: `IA/lsc_service/index_portable.html` para uso 100% client-side.
- **Entrenamiento personalizado**: Posibilidad de agregar nuevos ejemplos y guardar modelos.

### 🎨 Interfaz Unificada
- **Diseño responsive** con Bootstrap 5.
- **Navegación consistente** entre módulos (Usuario/Admin).
- **Visualizaciones interactivas** con Chart.js.

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8.2+**
- **MySQL/MariaDB**
- **Apache 2.4+**

### Frontend
- **HTML5 & CSS3**
- **Bootstrap 5**
- **JavaScript (ES6+)**
- **TensorFlow.js**

### Herramientas
- **XAMPP** (Entorno recomendado)
- **Git**

## 📁 Estructura del Proyecto

```
EnSENAme/
├── 📂 admin/               # Panel administrativo y assets compartidos
│   ├── 📂 dashboard/       # Dashboard principal del administrador
│   └── 📂 assets/          # CSS, JS, Imágenes compartidas
├── 📂 user/                # Panel de usuario regular
├── 📂 IA/                  # Módulo de Inteligencia Artificial
│   └── 📂 lsc_service/     # Versión portable del reconocedor
├── 📂 base de datos/       # Scripts SQL y modelos JSON
├── 📂 docs/                # Documentación técnica detallada
├── 📂 documentacion/       # Documentación de mejoras y seguridad
├── 📂 includes/            # Archivos PHP compartidos (session, etc.)
├── 📂 uploads/             # Archivos subidos por usuarios
├── 📂 css/                 # Estilos globales
├── 📂 js/                  # Scripts globales
├── index.php               # Landing page y punto de entrada
├── login.php               # Sistema de login
├── register.php            # Registro de usuarios
└── conexion.php            # Configuración de base de datos
```

## 🔧 Instalación y Despliegue

### Requisitos Previos
- XAMPP (Apache + MySQL + PHP)
- Git
- Navegador web moderno

### Pasos de Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/ENSENA-1101-EQ-9-2025/EnSENAme.git
    cd EnSENAme
    ```

2.  **Configurar XAMPP:**
    - Colocar el proyecto en `c:\xampp\htdocs\enseñame\enSENAme\EnSENAme\` (o ruta equivalente en Linux/Mac).
    - Iniciar Apache y MySQL.

3.  **Configurar Base de Datos:**
    - Crear una base de datos llamada `kaboom` (utf8mb4_spanish_ci).
    - Importar el archivo **`base de datos/kaboom.sql`**.
    - *Nota: Este archivo contiene la estructura completa y datos de ejemplo.*

4.  **Configurar Conexión:**
    - Editar `conexion.php` con tus credenciales de MySQL si son diferentes a las por defecto.

5.  **Acceder al Sistema:**
    - Abrir en el navegador: `http://localhost/enseñame/enSENAme/EnSENAme/`

## 👤 Usuarios de Prueba

| Usuario | ID | Rol | Contraseña |
| :--- | :--- | :--- | :--- |
| **Jeremy** | `1015189816` | Administrador | *(Ver base de datos)* |
| **Morita** | `123456789` | Administrador | *(Ver base de datos)* |
| **Jacob** | `1015196766` | Operador | *(Ver base de datos)* |

## 📚 Documentación Detallada

Consulta los siguientes archivos para más detalles técnicos:

### Sistema y Seguridad
- [Mejoras del Login](documentacion/MEJORAS_LOGIN.md)
- [Sistema de Contraseñas Temporales](documentacion/SISTEMA_PASSWORD_TEMPORAL.md)
- [Problemas Solucionados PHP](documentacion/PROBLEMAS_SOLUCIONADOS_PHP.md)
- [Guía de Despliegue](documentacion/GUIA_DESPLIEGUE.md)

### Funcionalidades
- [Documentación del Chat](docs/sistema/CHAT_DOCUMENTATION.md)
- [API de Información LSC](docs/api/API_INFO_SORDOS_DOCUMENTACION.md)
- [Navegación Unificada](docs/usuario/NAVEGACION_UNIFICADA.md)

### Inteligencia Artificial
- [LSC Portable README](IA/lsc_service/README.md)

## 🤝 Contribuir

1.  Fork el proyecto.
2.  Crear una rama (`git checkout -b feature/nueva-caracteristica`).
3.  Commit tus cambios (`git commit -m 'Agregar nueva característica'`).
4.  Push a la rama (`git push origin feature/nueva-caracteristica`).
5.  Abrir un Pull Request.

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

---

**Desarrollado por el Equipo EnSEÑAme (ENSENA-1101-EQ-9-2025)**
*Facilitando la comunicación y el aprendizaje de la LSC.*