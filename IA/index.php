<?php
require_once __DIR__ . '/../includes/session.php';
if (empty($_SESSION['txtdoc'])) {
    header('Location: ../login.php');
    exit();
}
$display_name = isset($_SESSION['display_name']) && $_SESSION['display_name'] !== '' ? $_SESSION['display_name'] : 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <title>EnSEÑAme - IA Detector de LSC</title>
  <link rel="icon" href="../admin/assets/images/favisena.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link" />
  <link rel="stylesheet" href="../admin/assets/fonts/tabler-icons.min.css" />
  <link rel="stylesheet" href="../admin/assets/fonts/feather.css" />
  <link rel="stylesheet" href="../admin/assets/fonts/fontawesome.css" />
  <link rel="stylesheet" href="../admin/assets/fonts/material.css" />
  <link rel="stylesheet" href="../admin/assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="../admin/assets/css/style-preset.css" />
  <!-- Bootstrap CSS (de la plantilla) -->
  <link rel="stylesheet" href="../admin/assets/css/plugins/bootstrap.min.css" />
  <!-- Bootstrap adicional (opcional). Si usas el paquete de la plantilla, este puede omitirse -->
  <!-- <link rel="stylesheet" href="../css/bootstrap.min.css" /> -->
  <style>
    body { background:#f8f9fa; color:#333; }
    .main-container { max-width:1200px; margin: 1.5rem auto; padding: 0 20px; }
    .main-content { display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .card { border-radius: 12px; overflow: hidden; }
    .video-container { grid-column:1; }
    #video { width:100%; background:#000; min-height:280px; max-height:320px; object-fit:cover; }
    .result { grid-column:2; }
    .training-quick { grid-column:3; }
    .mode-badge { display:inline-block; margin-left:8px; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:600; background:#e6f7ff; color:#0050b3; border:1px solid #91d5ff; vertical-align:middle; }
    #confidenceBar{ width:100%; height:8px; background:#e5e7eb; border-radius:4px; margin:15px 0; overflow:hidden; }
    #confidenceLevel{ height:100%; width:0%; background:linear-gradient(to right, #1890ff, #40a9ff); transition: width .5s ease; }
    .accum-box { margin-top: 12px; text-align:left; }
    .accum-text { width:100%; resize:vertical; }
    @media (max-width: 1024px){ .main-content{ grid-template-columns: 1fr 1fr; } .training-quick{ grid-column:2; } }
    @media (max-width: 768px){ .main-content{ grid-template-columns: 1fr; } .training-quick{ grid-column:1; } }

    /*
     | Botones custom desactivados para dejar Bootstrap por defecto (visible a pedido)
     | Si quieres volver a usarlos, elimina este comentario y reactiva el bloque.
    .btn { padding:10px 20px; border-radius:8px; font-weight:500; display:inline-flex; align-items:center; gap:6px; }
    .btn-sm { padding:8px 16px; font-size:12px; }
    .btn-warning{ background:#f59e0b; color:#fff; }
    .btn-warning:hover{ background:#d97706; }
    */
  </style>
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- Preloader -->
  <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>

  <!-- Sidebar (como en user/) -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="../user/index.php" class="b-brand text-primary">
          <img src="../admin/assets/images/logoensenamenobg.png" alt="EnSEÑAme Logo" class="img-fluid" />
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item"><a href="../user/index.php" class="pc-link"><span class="pc-micon"><i class="ti ti-dashboard"></i></span><span class="pc-mtext">Inicio</span></a></li>
          <li class="pc-item"><a href="../user/producto.php" class="pc-link"><span class="pc-micon"><i class="ti ti-book"></i></span><span class="pc-mtext">Guías LSC</span></a></li>
          <li class="pc-item"><a href="../user/chatbot.php" class="pc-link"><span class="pc-micon"><i class="ti ti-robot"></i></span><span class="pc-mtext">Asistente Virtual</span></a></li>
          <li class="pc-item"><a href="../user/chat.php" class="pc-link"><span class="pc-micon"><i class="ti ti-brand-hipchat"></i></span><span class="pc-mtext">Chat</span></a></li>
          <li class="pc-item"><a href="../user/servicio.php" class="pc-link"><span class="pc-micon"><i class="ti ti-headset"></i></span><span class="pc-mtext">Servicios</span></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header (como en user/) -->
  <header class="pc-header">
    <div class="header-wrapper">
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <li class="pc-h-item pc-sidebar-collapse"><a href="#" class="pc-head-link ms-0" id="sidebar-hide"><i class="ti ti-menu-2"></i></a></li>
          <li class="pc-h-item pc-sidebar-popup"><a href="#" class="pc-head-link ms-0" id="mobile-collapse"><i class="ti ti-menu-2"></i></a></li>
        </ul>
      </div>
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
              <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
              <span><?php echo htmlspecialchars($display_name); ?></span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0"><img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35"></div>
                  <div class="flex-grow-1 ms-3"><h6 class="mb-1"><?php echo htmlspecialchars($display_name); ?></h6><span><?php echo htmlspecialchars($display_name); ?></span></div>
                </div>
              </div>
              <ul class="nav drp-tabs nav-fill nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#drp-tab-1" type="button"><i class="ti ti-user"></i> Perfil</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#drp-tab-2" type="button"><i class="ti ti-settings"></i> Configuración</button></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="drp-tab-1">
                  <a href="../user/editarperfil.php" class="dropdown-item"><i class="ti ti-edit-circle"></i><span>Editar Perfil</span></a>
                  <a href="../user/user-profile.php" class="dropdown-item"><i class="ti ti-user"></i><span>Ver Perfil</span></a>
                  <a href="../user/logout.php" class="dropdown-item"><i class="ti ti-power"></i><span>Salir</span></a>
                </div>
                <div class="tab-pane fade" id="drp-tab-2">
                  <a href="#" class="dropdown-item"><i class="ti ti-help"></i><span>Soporte</span></a>
                  <a href="../user/account-profile.php" class="dropdown-item"><i class="ti ti-user"></i><span>Configuración de Cuenta</span></a>
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
      <div class="page-header"><div class="page-block"><div class="row align-items-center"><div class="col-md-12"><ul class="breadcrumb"><li class="breadcrumb-item"><a href="../user/index.php">Home</a></li><li class="breadcrumb-item">IA</li></ul></div></div></div></div>

      <!-- Contenido IA (idéntico al index.html actual excepto head/header) -->
      <div class="main-container">
        <div class="main-content">
            <div class="card video-container">
            <div class="card-header"><h3 class="mb-0"><i class="ti ti-video"></i> Cámara en Vivo <span class="mode-badge"><i class="ti ti-wand"></i> Modo: Traducción</span></h3></div>
            <div class="card-body" style="padding:0;">
              <video id="video" autoplay playsinline></video>
              <canvas id="canvas" style="display:none;"></canvas>
            </div>
          </div>

          <div class="card result">
            <div class="card-header"><h3 class="mb-0"><i class="ti ti-eye"></i> Resultado</h3></div>
            <div class="card-body">
              <p id="predictionText">Modelo cargado. Usa los botones de arriba para interactuar.</p>
              <div id="confidenceBar"><div id="confidenceLevel"></div></div>
              <p id="confidenceValue">0%</p>
              <div class="accum-box">
                <label class="form-label"><strong>Texto</strong></label>
                <textarea id="accumulatedText" class="mono accum-text form-control" rows="3" readonly></textarea>
                <div class="mt-2 d-flex gap-2 flex-wrap">
                  <button type="button" class="btn btn-warning btn-sm" id="btnCopyAccum" title="Copiar texto acumulado"><i class="ti ti-copy"></i> Copiar</button>
                  <button type="button" class="btn btn-secondary btn-sm" id="btnClearAccum" title="Borrar texto acumulado"><i class="ti ti-trash"></i> Borrar</button>
                </div>
                <p class="text-muted mt-2" style="font-size:12px;">Enter agrega la seña actual. Espacio agrega un espacio.</p>
              </div>
            </div>
          </div>

          <div class="card training-quick">
            <div class="card-header"><h3 class="mb-0">Uso de IA</h3></div>
            <div class="card-body">
              <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
                <button type="button" class="btn btn-warning btn-sm" onclick="predictOnce()" title="Realiza una sola predicción"><i class="ti ti-bolt"></i> Predecir (1 captura)</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="startStreaming()" title="Inicia predicción continua cada segundo"><i class="ti 
 ti-player-play"></i> Iniciar continuo</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="stopStreaming()" title="Detiene la predicción continua"><i class="ti ti-player-pause"></i> Detener continuo</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="loadDefault()" title="Cargar modelo de ejemplo del servidor"><i class="ti ti-download"></i> Cargar Modelo (Defecto)</button>
                <a href="lsc_service/index_portable.html" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="ti ti-cpu"></i> LSC Portable (Web)</a>
              </div>
              <p class="text-muted text-center mb-0">Usa los botones para ejecutar predicciones sin entrenar en esta página.</p>
            </div>
          </div>
        </div>
      </div>

      <footer class="pc-footer"><div class="footer-wrapper container-fluid"><div class="row"><div class="col-sm my-1"></div><div class="col-auto my-1"></div></div></div></footer>
    </div>
  </div>

  <!-- Scripts plantilla -->
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.11.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/knn-classifier@1.2.2"></script>
  <script>
    // Variables y configuración
    let video, classifier, mobilenet; let isModelReady=false, isVideoReady=false; let streamTimer=null;
    let trainingData = { examples:{}, classNames:[] };
    let currentLabel='';
    let lastPrediction = { label:'', confidence:0, ts:0 };
    let lastEnterAt = 0;
    const MIN_CONFIDENCE = 0.5; // 50%

    const urlParams = new URLSearchParams(location.search);
    const PARAM_MODEL_URL = urlParams.get('modelUrl');
    // Fuentes remotas opcionales
    const REMOTE_CANDIDATES = [
      ...(PARAM_MODEL_URL ? [PARAM_MODEL_URL] : []),
      '../IA/get_model.php?id=1',
      'https://raw.githubusercontent.com/DanielPedraza023/InterpretacionLSC/main/datos_entrenamiento_senas.json',
      'https://raw.githubusercontent.com/DanielPedraza023/InterpretacionLSC/main/base%20de%20datos/datos_entrenamiento_senas%20(3).json'
    ];
  // Usar explícitamente el archivo de la carpeta "base de datos" como predeterminado
  // (el archivo (3) existe en el repo; (4) no estaba presente)
  const LOCAL_DEFAULT_URL = '../base%20de%20datos/datos_entrenamiento_senas%20(3).json';
    const LOCAL_FALLBACKS = [
      './lsc_service/assets/models/default_training.json',
      '../base%20de%20datos/datos_entrenamiento_senas%20(3).json',
      '../base%20de%20datos/datos_entrenamiento_senas.json'
    ];

    document.addEventListener('DOMContentLoaded', async ()=>{
      video = document.getElementById('video');
      const predictionText = document.getElementById('predictionText');
      const confidenceLevel = document.getElementById('confidenceLevel');
      const confidenceValue = document.getElementById('confidenceValue');

      classifier = knnClassifier.create();
      mobilenet = await tf.loadLayersModel('https://storage.googleapis.com/tfjs-models/tfjs/mobilenet_v1_0.25_224/model.json');
      isModelReady=true; predictionText.textContent='Modelo cargado. Usa los botones de arriba para interactuar.';
      try { const stream = await navigator.mediaDevices.getUserMedia({ video:{ width:640, height:480 } }); video.srcObject=stream; await video.play(); isVideoReady=true; }
      catch(_) { predictionText.textContent='Error: No se pudo acceder a la cámara.'; }

      function showStatus(msg){ predictionText.textContent = msg; setTimeout(()=>{ predictionText.textContent='Listo para usar'; }, 3000); }
      function getActivation(){ const img=tf.browser.fromPixels(video); const processed=tf.image.resizeBilinear(img,[224,224]); const batched=processed.expandDims(0); const act=mobilenet.predict(batched); img.dispose(); processed.dispose(); return act; }

      async function predictOnceImpl(){
        if (classifier.getNumClasses()===0){ predictionText.textContent='Primero carga un modelo por defecto'; return null; }
        const act=getActivation();
        const res=await classifier.predictClass(act);
        currentLabel=res.label||'';
        const conf=(res.confidences[res.label]||0);
        const confPct=Math.round(conf*100);
        confidenceLevel.style.width=confPct+'%';
        confidenceValue.textContent=confPct+'%';
        lastPrediction = { label: currentLabel, confidence: conf, ts: Date.now() };
        return { label: currentLabel, confidence: conf };
      }

      async function predictBurst(frames=3, gapMs=120){
        const results=[];
        for(let i=0;i<frames;i++){
          const r = await predictOnceImpl();
          if(r) results.push(r);
          if(i<frames-1) await new Promise(res=>setTimeout(res,gapMs));
        }
        if(results.length===0) return null;
        const agg={};
        for(const r of results){
          if(!r.label) continue;
          if(!agg[r.label]) agg[r.label]={sum:0,count:0};
          agg[r.label].sum += r.confidence;
          agg[r.label].count += 1;
        }
        let bestLabel=''; let bestScore=-1;
        for(const [lab,v] of Object.entries(agg)){
          const avg=v.sum/Math.max(1,v.count);
          if(avg>bestScore){ bestScore=avg; bestLabel=lab; }
        }
        if(!bestLabel) return null;
        return { label: bestLabel, confidence: bestScore };
      }

      function startStreamingImpl(){ if(streamTimer) return; streamTimer=setInterval(predictOnceImpl,1000); showStatus('Reconocimiento continuo iniciado'); }
      function stopStreamingImpl(){ if(streamTimer){ clearInterval(streamTimer); streamTimer=null; showStatus('Reconocimiento continuo detenido'); } }

      function unique(a){ return Array.from(new Set(a)); }
      function normalizeTrainingData(loaded){
        if(loaded && Array.isArray(loaded.classNames) && loaded.examples && typeof loaded.examples==='object') return loaded;
        if(loaded && Array.isArray(loaded.labels) && Array.isArray(loaded.vectors)){
          const ex={}; const names=unique(loaded.labels);
          for(let i=0;i<loaded.labels.length;i++){ const lab=String(loaded.labels[i]||''); const vec=loaded.vectors[i]; if(!Array.isArray(vec)) continue; (ex[lab] ||= []).push(vec); }
          return { classNames:names, examples:ex };
        }
        if(loaded && Array.isArray(loaded.classes) && loaded.data && typeof loaded.data==='object') return { classNames:loaded.classes, examples:loaded.data };
        if(loaded && Array.isArray(loaded.examples)){
          const ex={}; const names=[];
          for(const item of loaded.examples){ if(!item) continue; const lab=String(item.label||''); const vec=item.vector; if(!Array.isArray(vec)) continue; (ex[lab] ||= []).push(vec); names.push(lab); }
          return { classNames:unique(loaded.classNames||names), examples:ex };
        }
        throw new Error('Formato de modelo inválido');
      }

      async function fetchWithFallback(urls){
          for(const u of urls){
            try{
              const r = await fetch(u, { cache: 'no-store' });
              if(r.ok) return await r.json();
              console.warn('fetchWithFallback: recurso no OK', u, r.status);
            }catch(e){
              console.warn('fetchWithFallback: error al solicitar', u, e);
            }
          }
          throw new Error('No se pudo cargar ningún modelo');
        }

      window.loadDefault = async function(){
        try{
          const ordered = [LOCAL_DEFAULT_URL, ...LOCAL_FALLBACKS, ...REMOTE_CANDIDATES];
          const raw = await fetchWithFallback(ordered);
          const norm = normalizeTrainingData(raw);
          trainingData = norm;
          classifier.clearAllClasses();
          for(const cls of trainingData.classNames){
            const list = trainingData.examples[cls]||[];
            for(const ex of list){ const t=tf.tensor(ex,[1,1000]); classifier.addExample(t, cls); }
          }
          const total = trainingData.classNames.reduce((acc,cn)=>acc+(trainingData.examples[cn]?.length||0),0);
          showStatus('Modelo por defecto cargado: '+total+' ejemplos');
        }catch(e){
          console.error('loadDefault: fallo al cargar modelo por defecto', e);
          showStatus('No se pudo cargar el modelo por defecto');
        }
      }
      window.predictOnce = ()=>{ predictOnceImpl(); };
      window.startStreaming = ()=>startStreamingImpl();
      window.stopStreaming = ()=>stopStreamingImpl();

      // Manejo de texto acumulado y teclado (Enter/Espacio) con debounce y umbral de confianza
      const accum = document.getElementById('accumulatedText');
      document.getElementById('btnClearAccum').addEventListener('click', ()=>{ accum.value=''; showStatus('Texto borrado'); });
      document.getElementById('btnCopyAccum').addEventListener('click', async ()=>{ const txt=accum.value||''; try{ if(navigator.clipboard && window.isSecureContext){ await navigator.clipboard.writeText(txt);} else { const ta=document.createElement('textarea'); ta.value=txt; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);} showStatus('Texto copiado'); }catch(e){ showStatus('No se pudo copiar'); } });

      document.addEventListener('keydown', async (e)=>{
        const tag=(e.target && e.target.tagName)?e.target.tagName.toUpperCase():'';
        if(tag==='INPUT'||tag==='TEXTAREA'||(e.target&&e.target.isContentEditable)) return;
        const isEnter=(e.key==='Enter'||e.code==='NumpadEnter');
        const isSpace=(e.key===' '||e.code==='Space');
        if(!(isEnter||isSpace)) return;

        const now=Date.now();
        if(now-lastEnterAt<200){ e.preventDefault(); return; }
        lastEnterAt=now;

        if(isSpace){ e.preventDefault(); accum.value+=' '; return; }
        if(isEnter){
          e.preventDefault();
          const fresh=(now - lastPrediction.ts) <= 1500;
          if(fresh && lastPrediction.label && lastPrediction.confidence >= MIN_CONFIDENCE){
            accum.value += lastPrediction.label;
            showStatus('Agregado: '+lastPrediction.label);
            return;
          }
          if(classifier.getNumClasses()===0){ showStatus('Carga un modelo antes de usar Enter'); return; }
          const res = await predictBurst(3,120);
          if(res && res.label && res.confidence >= MIN_CONFIDENCE){ accum.value += res.label; showStatus('Agregado: '+res.label); }
          else { showStatus('Predicción no confiable. Intenta nuevamente.'); }
        }
      });
    });
  </script>

  <script src="../admin/assets/js/plugins/popper.min.js"></script>
  <script src="../admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
  <script src="../admin/assets/js/fonts/custom-font.js"></script>
  <script src="../admin/assets/js/pcoded.js"></script>
  <script src="../admin/assets/js/plugins/feather.min.js"></script>
  <script>layout_change('light'); change_box_container('false'); layout_rtl_change('false'); preset_change('preset-1'); font_change('Public-Sans');</script>
</body>
</html>
