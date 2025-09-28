// Variables globales
let video;
let classifier;
let mobilenet;
let isModelReady = false;
let isVideoReady = false;
let examplesAdded = 0;

// Cuando la página se carga completamente
document.addEventListener('DOMContentLoaded', function() {
    // Configurar elementos de la interfaz
    video = document.getElementById('video');
    const startBtn = document.getElementById('startBtn');
    const captureBtn = document.getElementById('captureBtn');
    const trainBtn = document.getElementById('trainBtn');
    const addExampleBtn = document.getElementById('addExampleBtn');
    const classNameInput = document.getElementById('className');
    const predictionText = document.getElementById('predictionText');
    const confidenceLevel = document.getElementById('confidenceLevel');
    const confidenceValue = document.getElementById('confidenceValue');
    const exampleCount = document.getElementById('exampleCount');
    
    // Inicializar el clasificador
    classifier = knnClassifier.create();
    
    // Cargar el modelo MobileNet
    mobilenet = tf.loadLayersModel('https://storage.googleapis.com/tfjs-models/tfjs/mobilenet_v1_0.25_224/model.json').then(model => {
        mobilenet = model;
        isModelReady = true;
        console.log('Modelo MobileNet cargado');
        
        if (isVideoReady) {
            captureBtn.disabled = false;
            trainBtn.disabled = false;
        }
    });
    
    // Evento para iniciar la cámara
    startBtn.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { width: 640, height: 480 } 
            });
            video.srcObject = stream;
            video.play();
            
            isVideoReady = true;
            startBtn.disabled = true;
            
            if (isModelReady) {
                captureBtn.disabled = false;
                trainBtn.disabled = false;
            }
            
            console.log('Cámara iniciada correctamente');
        } catch (error) {
            console.error('Error al acceder a la cámara:', error);
            predictionText.textContent = 'Error: No se pudo acceder a la cámara. Asegúrate de dar los permisos necesarios.';
        }
    });
    
    // Evento para agregar ejemplos de entrenamiento
    addExampleBtn.addEventListener('click', () => {
        const className = classNameInput.value.trim();
        if (className && isModelReady && isVideoReady) {
            addExample(className);
            examplesAdded++;
            exampleCount.textContent = `${examplesAdded} ejemplos agregados`;
            classNameInput.value = '';
        }
    });
    
    // Habilitar el botón de agregar cuando se escribe un nombre de clase
    classNameInput.addEventListener('input', () => {
        addExampleBtn.disabled = !classNameInput.value.trim();
    });
    
    // Evento para entrenar el modelo
    trainBtn.addEventListener('click', () => {
        if (classifier.getNumClasses() > 0) {
            predictionText.textContent = 'Entrenando modelo...';
            setTimeout(predict, 1000); // Empezar a predecir después de entrenar
        } else {
            predictionText.textContent = 'Primero agrega algunos ejemplos para entrenar';
        }
    });
    
    // Evento para capturar y predecir
    captureBtn.addEventListener('click', predict);
    
    // Función para agregar ejemplos al clasificador
    async function addExample(className) {
        // Capturar el frame actual del video
        const img = tf.browser.fromPixels(video);
        const processedImg = tf.image.resizeBilinear(img, [224, 224]);
        const batchedImg = processedImg.expandDims(0);
        
        // Obtener las activaciones de MobileNet
        const activation = mobilenet.predict(batchedImg);
        
        // Agregar el ejemplo al clasificador
        classifier.addExample(activation, className);
        
        // Liberar memoria
        img.dispose();
        processedImg.dispose();
        batchedImg.dispose();
        
        console.log(`Ejemplo agregado para la clase: ${className}`);
    }
    
    // Función para predecir la seña
    async function predict() {
        if (classifier.getNumClasses() === 0) {
            predictionText.textContent = 'Primero entrena el modelo con algunas señas';
            return;
        }
        
        // Capturar el frame actual del video
        const img = tf.browser.fromPixels(video);
        const processedImg = tf.image.resizeBilinear(img, [224, 224]);
        const batchedImg = processedImg.expandDims(0);
        
        // Obtener las activaciones de MobileNet
        const activation = mobilenet.predict(batchedImg);
        
        // Predecir la clase
        const result = await classifier.predictClass(activation);
        
        // Mostrar el resultado
        predictionText.textContent = `Seña: ${result.label}`;
        const confidence = Math.round(result.confidences[result.label] * 100);
        confidenceLevel.style.width = `${confidence}%`;
        confidenceValue.textContent = `${confidence}% de confianza`;
        
        // Liberar memoria
        img.dispose();
        processedImg.dispose();
        batchedImg.dispose();
        
        // Continuar prediciendo
        setTimeout(predict, 1000);
    }
});