# main.py
from fastapi import FastAPI, File, UploadFile
from fastapi.middleware.cors import CORSMiddleware
import numpy as np
import cv2
import tensorflow as tf
from io import BytesIO
from PIL import Image
import base64

app = FastAPI()

# Configurar CORS para permitir requests desde el navegador
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

# Cargar el modelo preentrenado
model = tf.keras.models.load_model('sign_language_model.h5')
class_names = np.load('class_names.npy', allow_pickle=True)

def preprocess_image(image_data):
    # Convertir base64 a imagen
    image_data = base64.b64decode(image_data.split(',')[1])
    image = Image.open(BytesIO(image_data))
    image = np.array(image)
    
    # Preprocesamiento igual que durante el entrenamiento
    image = cv2.cvtColor(image, cv2.COLOR_RGB2BGR)
    image = cv2.resize(image, (64, 64))
    image = image / 255.0
    image = np.expand_dims(image, axis=0)
    
    return image

@app.post("/predict")
async def predict(image_data: str):
    try:
        # Preprocesar imagen
        processed_image = preprocess_image(image_data)
        
        # Realizar predicción
        predictions = model.predict(processed_image)
        predicted_class = class_names[np.argmax(predictions[0])]
        confidence = float(np.max(predictions[0]))
        
        return {
            "success": True,
            "prediction": predicted_class,
            "confidence": confidence
        }
    except Exception as e:
        return {"success": False, "error": str(e)}

@app.get("/")
async def root():
    return {"message": "Colombian Sign Language Recognition API"}