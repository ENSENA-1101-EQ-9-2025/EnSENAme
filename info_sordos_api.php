<?php
// info_sordos_api.php — archivo marcado como deprecado
// Respuesta mínima y segura para evitar que contenido corrupto rompa el sitio.

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

http_response_code(410); // Gone
echo json_encode([
    'success' => false,
    'error' => 'Endpoint unificado. Usa /chatbot_api_clean.php para consultas.',
    'endpoint_unificado' => 'chatbot_api_clean.php'
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

exit;

?>
        "congenitas" => [
            "titulo" => "Causas Congénitas (50-60% de casos)",
            "descripcion" => "Presentes desde el nacimiento, a menudo detectables en los primeros meses de vida",
            "factores" => [
                [
                    "causa" => "Genética hereditaria",
                    "porcentaje" => "50-60%",
                    "descripcion" => "Mutaciones genéticas transmitidas de padres a hijos. Más de 400 genes están relacionados con la pérdida auditiva. Puede ser sindrómica (parte de un síndrome) o no sindrómica (aislada).",
                    "tipos" => ["Síndrome de Usher (sordera + ceguera progresiva)", "Síndrome de Pendred (sordera + problemas tiroideos)", "Síndrome de Waardenburg (sordera + alteraciones pigmentarias)", "Sordera no sindrómica (70% de casos genéticos)"],
                    "herencia" => ["Autosómica recesiva (80%)", "Autosómica dominante (15%)", "Ligada al cromosoma X (2-3%)", "Mitocondrial (1%)"]
                ],
                [
                    "causa" => "Infecciones maternas durante embarazo",
                    "porcentaje" => "15-20%",
                    "descripcion" => "Infecciones virales que afectan el desarrollo auditivo del feto, especialmente durante el primer trimestre.",
                    "ejemplos" => ["Rubéola (causa más común históricamente)", "Citomegalovirus (CMV)", "Toxoplasmosis", "Herpes simple", "Sífilis", "Zika virus"],
                    "prevencion" => "Vacunación, control prenatal, evitar exposición a vectores"
                ],
                [
                    "causa" => "Complicaciones perinatales",
                    "porcentaje" => "10-15%",
                    "descripcion" => "Problemas durante el parto o primeras semanas de vida que afectan el sistema auditivo.",
                    "factores" => ["Hipoxia neonatal", "Prematuridad extrema (<32 semanas)", "Bajo peso al nacer (<1500g)", "Hiperbilirrubinemia severa", "Uso de medicamentos ototóxicos", "Meningitis bacteriana neonatal"],
                    "prevencion" => "Cuidado prenatal adecuado, control del parto, UCIN especializada"
                ]
            ]
        ],
        "adquiridas" => [
            "titulo" => "Causas Adquiridas",
            "descripcion" => "Desarrolladas después del nacimiento debido a diversos factores ambientales, médicos o traumáticos",
            "factores" => [
                [
                    "causa" => "Exposición a ruido",
                    "porcentaje" => "30-40%",
                    "descripcion" => "Daño coclear por exposición prolongada o intensa a sonidos fuertes. Tipo más prevenible de pérdida auditiva.",
                    "tipos" => ["Trauma acústico agudo (>140 dB)", "Pérdida inducida por ruido ocupacional", "Pérdida por música/auriculares", "Trauma por explosión"],
                    "niveles_peligrosos" => ["85 dB por 8 horas/día", "100 dB por 15 minutos", "110 dB por 1 minuto", "120+ dB inmediato"],
                    "prevencion" => "Protección auditiva, límites de exposición, pausas auditivas"
                ],
                [
                    "causa" => "Envejecimiento (Presbiacusia)",
                    "porcentaje" => "35-40%",
                    "descripcion" => "Deterioro gradual del sistema auditivo con la edad. Afecta especialmente frecuencias altas.",
                    "epidemiologia" => ["33% en personas >65 años", "50% en personas >75 años", "Más común en hombres", "Acelera con factores ambientales"],
                    "caracteristicas" => "Pérdida gradual, bilateral, simétrica, dificultad en ruido"
                ],
                [
                    "causa" => "Infecciones",
                    "porcentaje" => "15-20%",
                    "descripcion" => "Infecciones que dañan estructuras auditivas directa o indirectamente.",
                    "tipos" => ["Meningitis bacteriana (30% desarrolla sordera)", "Otitis media crónica", "Mastoiditis", "Laberintitis", "Neuritis vestibular", "COVID-19 (casos reportados)"],
                    "prevencion" => "Vacunación, tratamiento temprano, higiene adecuada"
                ],
                [
                    "causa" => "Medicamentos ototóxicos",
                    "porcentaje" => "10-15%",
                    "descripcion" => "Medicamentos que dañan el oído interno como efecto secundario.",
                    "categorias" => [
                        "Aminoglucósidos (gentamicina, estreptomicina)",
                        "Diuréticos de asa (furosemida)",
                        "Quimioterapia (cisplatino, carboplatino)",
                        "Antipalúdicos (cloroquina, quinina)",
                        "Salicilatos (aspirina en altas dosis)"
                    ],
                    "factores_riesgo" => "Dosis altas, uso prolongado, función renal comprometida, edad avanzada"
                ],
                [
                    "causa" => "Traumatismos",
                    "porcentaje" => "5-10%",
                    "descripcion" => "Lesiones físicas que afectan el sistema auditivo.",
                    "tipos" => ["Fractura de hueso temporal", "Perforación timpánica", "Luxación osicular", "Trauma craneoencefálico", "Barotrauma"],
                    "prevencion" => "Equipos de protección, seguridad vial, deportes seguros"
                ]
            ]
        ]
    ],
    
    "lengua_señas_colombiana" => [
        "titulo" => "Lengua de Señas Colombiana (LSC)",
        "descripcion" => "La LSC es la lengua natural de la comunidad sorda colombiana, reconocida oficialmente como lengua de las personas sordas de Colombia mediante las leyes 324 de 1996 y 982 de 2005. Es una lengua visual-espacial completa con su propia gramática, sintaxis y léxico.",
        "reconocimiento_legal" => [
            "ley_324_1996" => "Reconoce la LSC como lengua propia de la comunidad sorda",
            "ley_982_2005" => "Establece normas para equiparación de oportunidades",
            "ley_1346_2009" => "Ratifica la Convención sobre Derechos de las Personas con Discapacidad",
            "decreto_1421_2017" => "Reglamenta la educación inclusiva"
        ],
        "estadisticas" => [
            "usuarios_estimados" => "450,000-500,000 personas",
            "sordos_usuarios" => "180,000 personas sordas",
            "oyentes_usuarios" => "270,000-320,000 familiares e intérpretes",
            "interpretes_certificados" => "800+ intérpretes",
            "instituciones_educativas" => "120+ colegios con programas bilingües"
        ],
        "caracteristicas_linguisticas" => [
            "modalidad" => "Visual-espacial (no auditivo-vocal)",
            "canal" => "Gestual-visual",
            "estructura" => "Morfología, sintaxis y semántica propias",
            "iconicidad" => "Mayor que lenguas orales pero arbitraria en gran parte",
            "variacion_regional" => "Dialectos regionales (Bogotá, Medellín, Cali, Costa)"
        ],
        "componentes_señas" => [
            [
                "componente" => "Configuración de mano (Handshape)",
                "descripcion" => "Forma que adoptan los dedos y la mano al hacer una seña",
                "ejemplos" => ["Puño cerrado", "Índice extendido", "Mano abierta", "Configuración L"],
                "total_configuraciones" => "60+ configuraciones básicas en LSC"
            ],
            [
                "componente" => "Ubicación (Location)",
                "descripcion" => "Lugar del cuerpo donde se ejecuta la seña",
                "zonas" => ["Cabeza y cara", "Torso", "Brazos y manos", "Espacio neutro"],
                "precision" => "Ubicación específica afecta el significado"
            ],
            [
                "componente" => "Movimiento (Movement)",
                "descripcion" => "Tipo y dirección del movimiento de las manos",
                "tipos" => ["Rectilíneo", "Circular", "Zigzag", "Vibratorio", "Repetitivo"],
                "funciones" => "Puede indicar tiempo, aspecto, intensidad"
            ],
            [
                "componente" => "Orientación de palmas",
                "descripcion" => "Dirección hacia donde apuntan las palmas de las manos",
                "variaciones" => ["Hacia arriba", "Hacia abajo", "Hacia el cuerpo", "Hacia afuera"],
                "importancia" => "Cambios mínimos alteran completamente el significado"
            ],
            [
                "componente" => "Expresión facial y corporal",
                "descripcion" => "Elementos no manuales que aportan información gramatical",
                "funciones" => ["Preguntas (cejas arriba)", "Negación (movimiento de cabeza)", "Énfasis (inclinación corporal)", "Adjetivos (expresiones específicas)"],
                "importancia" => "Esencial para la gramática y el significado"
            ]
        ],
        "estructura_gramatical" => [
            "orden_basico" => "SOV (Sujeto-Objeto-Verbo) predominante, pero flexible",
            "clasificadores" => "Formas de mano que representan categorías de objetos",
            "uso_espacio" => "El espacio se usa gramaticalmente para referencias",
            "tiempo_verbal" => "Se marca mediante adverbios temporales y línea temporal",
            "negacion" => "Movimiento de cabeza + señas específicas de negación",
            "preguntas" => "Marcadas facialmente y con señas interrogativas"
        ],
        "variaciones_regionales" => [
            [
                "region" => "Bogotá y Cundinamarca",
                "caracteristicas" => "Considerada variedad estándar, usada en medios nacionales",
                "instituciones" => "INSOR, Instituto Pedagógico Nacional",
                "particularidades" => "Mayor influencia del español signado"
            ],
            [
                "region" => "Antioquia (Medellín)",
                "caracteristicas" => "Variaciones lexicales distintivas, ritmo diferente",
                "instituciones" => "Institución Educativa Francisco Luis Hernández Betancur",
                "particularidades" => "Señas únicas para conceptos regionales"
            ],
            [
                "region" => "Valle del Cauca (Cali)",
                "caracteristicas" => "Influencia de la cultura afrocolombiana",
                "instituciones" => "Escuela de Sordos de Cali",
                "particularidades" => "Expresiones corporales más marcadas"
            ],
            [
                "region" => "Costa Atlántica",
                "caracteristicas" => "Influencia del español costeño en algunos préstamos",
                "instituciones" => "Instituto para Sordos de Barranquilla",
                "particularidades" => "Adaptaciones culturales caribeñas"
            ]
        ]
    ],

    "cultura_sorda" => [
        "titulo" => "Cultura Sorda",
        "definicion" => "La cultura sorda es una identidad cultural única basada en la experiencia visual del mundo, la lengua de señas como lengua natural, y valores comunitarios específicos. No se define por la pérdida auditiva sino por la pertenencia cultural y lingüística.",
        "conceptos_fundamentales" => [
            [
                "concepto" => "Sordera como diferencia cultural",
                "descripcion" => "La sordera se ve como una diferencia lingüística y cultural, no como una discapacidad médica",
                "implicaciones" => "Orgullo cultural, preferencia por el término 'Sordo' con mayúscula",
                "contraste" => "Difiere del modelo médico que ve la sordera como deficiencia"
            ],
            [
                "concepto" => "Experiencia visual del mundo",
                "descripcion" => "Percepción y procesamiento principalmente visual de la información",
                "manifestaciones" => ["Comunicación visual", "Arte visual", "Arquitectura accesible", "Tecnología visual"],
                "ventajas" => "Agudeza visual superior, percepción periférica desarrollada"
            ],
            [
                "concepto" => "Comunidad y colectivismo",
                "descripcion" => "Fuerte sentido de comunidad y apoyo mutuo entre personas sordas",
                "prácticas" => ["Reuniones comunitarias", "Eventos culturales", "Apoyo intergeneracional", "Transmisión cultural"],
                "importancia" => "Red de apoyo fundamental para la identidad"
            ]
        ],
        "valores_culturales" => [
            [
                "valor" => "Información compartida",
                "descripcion" => "Tradición de compartir información extensa y detallada en la comunidad",
                "razones" => "Históricamente excluidos de información general",
                "prácticas" => "Conversaciones largas, detalles contextuales, redes informativas"
            ],
            [
                "valor" => "Franqueza y directividad",
                "descripcion" => "Comunicación directa y honesta, sin rodeos innecesarios",
                "contexto_cultural" => "La comunicación visual requiere claridad",
                "ejemplos" => "Preguntas directas sobre temas personales, feedback inmediato"
            ],
            [
                "valor" => "Respeto por los ancianos sordos",
                "descripcion" => "Veneración especial por sordos mayores como transmisores de cultura",
                "roles" => "Mentores, narradores de historia, preservadores de tradiciones",
                "importancia" => "Custodios de la LSC y tradiciones culturales"
            ],
            [
                "valor" => "Accesibilidad visual",
                "descripcion" => "Diseño de espacios y actividades pensando en la experiencia visual",
                "aplicaciones" => ["Iluminación adecuada", "Disposición circular en reuniones", "Alertas visuales", "Reducción de barreras visuales"],
                "filosofia" => "El entorno debe adaptarse a la cultura, no al revés"
            ]
        ],
        "tradiciones_y_eventos" => [
            [
                "evento" => "Semana Internacional de las Personas Sordas",
                "fecha" => "Última semana de septiembre",
                <?php
                // Endpoint seguro: archivo marcado como deprecado y unificado en chatbot_api_clean.php
                // Este archivo fue corrompido por inclusiones de contenido adicional fuera de PHP. Se mantiene una
                // respuesta mínima para evitar romper el sitio hasta que se migre o se restaure la versión completa.

                header('Content-Type: application/json; charset=utf-8');
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
                header('Access-Control-Allow-Headers: Content-Type');

                if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                    http_response_code(204);
                    exit;
                }

                http_response_code(410); // Gone
                echo json_encode([
                    'success' => false,
                    'error' => 'Este endpoint fue unificado. Usa /chatbot_api_clean.php para consultas y /chatbot_api.php o /chatbot_sordos.php para integración del chatbot.',
                    'endpoint_unificado' => 'chatbot_api_clean.php'
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

                exit;

                ?>