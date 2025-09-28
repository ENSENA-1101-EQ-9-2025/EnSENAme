# train_model.py
import tensorflow as tf
from tensorflow import keras
from tensorflow.keras import layers
import numpy as np
import cv2
import os

# Cargar y preprocesar dataset de imágenes de señas
def load_dataset(data_dir, img_size=(64, 64)):
    images = []
    labels = []
    label_names = []
    
    for label_idx, label_name in enumerate(sorted(os.listdir(data_dir))):
        label_names.append(label_name)
        label_dir = os.path.join(data_dir, label_name)
        
        for img_file in os.listdir(label_dir):
            img_path = os.path.join(label_dir, img_file)
            img = cv2.imread(img_path)
            img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
            img = cv2.resize(img, img_size)
            img = img / 255.0  # Normalizar
            
            images.append(img)
            labels.append(label_idx)
    
    return np.array(images), np.array(labels), label_names

# Crear modelo CNN
def create_model(input_shape, num_classes):
    model = keras.Sequential([
        layers.Conv2D(32, (3, 3), activation='relu', input_shape=input_shape),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(64, (3, 3), activation='relu'),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(64, (3, 3), activation='relu'),
        layers.Flatten(),
        layers.Dense(64, activation='relu'),
        layers.Dropout(0.5),
        layers.Dense(num_classes, activation='softmax')
    ])
    
    model.compile(optimizer='adam',
                 loss='sparse_categorical_crossentropy',
                 metrics=['accuracy'])
    
    return model

# Entrenar el modelo (esto se haría offline)
def train():
    # Cargar dataset
    X, y, class_names = load_dataset('dataset_colombian_sign_language')
    
    # Crear y entrenar modelo
    model = create_model(X[0].shape, len(class_names))
    model.fit(X, y, epochs=30, validation_split=0.2)
    
    # Guardar modelo y nombres de clases
    model.save('sign_language_model.h5')
    np.save('class_names.npy', class_names)
    
    return model, class_names