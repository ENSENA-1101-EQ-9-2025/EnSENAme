<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Registro</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="admin/assets/images/favisena.png" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="admin/assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="admin/assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="admin/assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="admin/assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="admin/assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="admin/assets/css/style-preset.css" >

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 shadow">
          <a href="index.php"><img src="admin/assets/images/logoensenamenobg.png" alt="img"></a>
        </nav>
        
        <div class="card my-5">
          <div class="card-body"> <form action="codigo.php" method="post" onsubmit="return validarFormulario()">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><b>Registro</b></h3>
              <a href="login.php" class="link-primary">Tienes Cuenta?</a>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="numeroDocumento" class="form-label">Número de Documento</label>
                <input type="text" name="numeroDocumento" id="numeroDocumento" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                <select name="tipoDocumento" id="tipoDocumento" class="form-select" required>
                  <option value="">--Seleccione--</option>
                  <option value="1">TI</option>
                  <option value="2">CC</option>
                  <option value="3">NN</option>
                </select>
              </div>              
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label">Primer Nombre</label>
                  <input type="text" class="form-control" name="primerNombre" id="primerNombre"  placeholder="Primer Nombre"required>
                  <label class="form-label"> Primer Apellido</label>
                  <input type="text" class="form-control"name="primerApellido" id="primerApellido"  placeholder="Primer Apellido"required>
                  
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label">Segundo Nombre</label>
                  <input type="text" class="form-control" name="segundoNombre" id="segundoNombre" placeholder="Segundo Nombre">
                  <label class="form-label"> Segundo Apellido</label>
                  <input type="text" class="form-control" name="segundoApellido" id="segundoApellido" placeholder="Segundo Apellido">
                  
                </div>
              </div>
            </div>         
            
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control" required>
              </div>
              
              <div class="mb-3">
                <label for="confirmarClave" class="form-label">Confirmar Clave</label>
                <input type="password" name="confirmarClave" id="confirmarClave" class="form-control" required>
                <div id="mensajeError" class="error-message"></div>
              </div>
              <div class="mb-3">
                <label for="idrol" class="form-label">Seleccione su Rol</label>
                <select name="idrol" id="idrol" class="form-select" required>
                  <option value="">Seleccione</option>                  
                  <option value="2">User</option>                
                </select>
              </div>           
            <div class="d-grid mt-3">
              <button type="submit" name="btn_registrar" id="btn_registrar" class="btn btn-primary">Crear Cuenta</button>
            </div>          
            </form>
          </div>
        </div>        
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="admin/assets/js/plugins/popper.min.js"></script>
  <script src="admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="admin/assets/js/plugins/bootstrap.min.js"></script>
  <script src="admin/assets/js/fonts/custom-font.js"></script>
  <script src="admin/assets/js/pcoded.js"></script>
  <script src="admin/assets/js/plugins/feather.min.js"></script>

  
  
  
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
    
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
                  ><span><img src="admin/assets/images/customization/default.svg" alt="img"></span><span>Light</span></a
                >
                <a href="#!" class="" onclick="layout_change('dark')" data-value="true"
                  ><span><img src="admin/assets/images/customization/dark.svg" alt="img"></span><span>Dark</span></a
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
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 1</span></a
                >
                <a href="#!" class="" data-value="preset-2"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 2</span></a
                >
                <a href="#!" class="" data-value="preset-3"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 3</span></a
                >
                <a href="#!" class="" data-value="preset-4"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 4</span></a
                >
                <a href="#!" class="" data-value="preset-5"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 5</span></a
                >
                <a href="#!" class="" data-value="preset-6"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 6</span></a
                >
                <a href="#!" class="" data-value="preset-7"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 7</span></a
                >
                <a href="#!" class="" data-value="preset-8"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 8</span></a
                >
                <a href="#!" class="" data-value="preset-9"
                  ><span><img src="admin/assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 9</span></a
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




<style>
  .navbar {
  width: 100%;
  border-bottom: 1px solid #eee; 
}
</style>
