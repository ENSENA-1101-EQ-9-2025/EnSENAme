<?php

/**
 * Chatbot API Mejorado - EnSEÑAme
 * API inteligente para asistente virtual sobre sordera, LSC y cultura sorda
 */

// Logging
function chatbot_log($msg)
{
    $ts = date('Y-m-d H:i:s');
    @file_put_contents(__DIR__ . '/chatbot_debug.log', "[$ts] $msg" . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// Headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    chatbot_log('OPTIONS preflight');
    http_response_code(204);
    exit;
}

// Base de conocimientos expandida
$KNOWLEDGE_BASE = [
    'sordera' => [
        'definicion' => 'La sordera es la pérdida total o parcial de la capacidad auditiva. Puede ser congénita (de nacimiento) o adquirida a lo largo de la vida.',
        'tipos' => [
            'Conductiva' => 'Problema en oído externo o medio que impide la transmisión del sonido',
            'Neurosensorial' => 'Daño en el oído interno o nervio auditivo',
            'Mixta' => 'Combinación de conductiva y neurosensorial'
        ],
        'grados' => [
            'Leve (21-40 dB)' => 'Dificultad para oír susurros o conversaciones lejanas',
            'Moderada (41-70 dB)' => 'Dificultad para seguir conversaciones normales',
            'Severa (71-90 dB)' => 'Solo se oyen sonidos muy fuertes',
            'Profunda (91+ dB)' => 'No se perciben la mayoría de sonidos'
        ],
        'causas' => [
            'Genéticas' => '50-60% de casos congénitos',
            'Infecciones maternas' => 'Rubéola, CMV durante embarazo',
            'Prematuridad' => 'Complicaciones en el parto',
            'Ruido intenso' => 'Exposición prolongada a sonidos fuertes',
            'Medicamentos ototóxicos' => 'Algunos antibióticos y quimioterapias',
            'Envejecimiento' => 'Presbiacusia, pérdida natural con la edad',
            'Infecciones' => 'Meningitis, otitis crónica'
        ]
    ],
    'lsc' => [
        'definicion' => 'La Lengua de Señas Colombiana (LSC) es una lengua visual-espacial con gramática propia, reconocida oficialmente por las leyes 324 de 1996 y 982 de 2005.',
        'caracteristicas' => [
            'Visual-espacial' => 'Usa el espacio y movimientos corporales',
            'Gramática propia' => 'No es español signado, tiene su propia estructura',
            'Expresiones faciales' => 'Parte fundamental de la gramática',
            'Clasificadores' => 'Formas de mano que representan objetos y acciones'
        ],
        'usuarios' => 'Aproximadamente 450,000 personas en Colombia',
        'recursos' => [
            'INSOR' => 'Instituto Nacional para Sordos',
            'FENASCOL' => 'Federación Nacional de Sordos de Colombia',
            'Apps' => 'Hetah, Spread Signs, SignSchool'
        ]
    ],
    'cultura_sorda' => [
        'definicion' => 'La cultura sorda es una identidad cultural basada en la lengua de señas, valores comunitarios y una perspectiva visual del mundo.',
        'valores' => [
            'Identidad visual' => 'Percepción del mundo a través de la vista',
            'Comunidad' => 'Sentido de pertenencia y apoyo mutuo',
            'Lengua de señas' => 'Elemento central de identidad',
            'Arte sordo' => 'Teatro, poesía visual, narrativa en señas'
        ],
        'eventos' => 'Encuentros deportivos, festivales culturales, conferencias',
        'organizaciones' => 'Asociaciones de sordos locales y nacionales'
    ],
    'tecnologias' => [
        'auditivas' => [
            'Audífonos' => 'BTE (detrás oreja), ITE (en oreja), ITC (en canal), CIC (completamente en canal)',
            'Implantes cocleares' => 'Dispositivo electrónico que estimula el nervio auditivo',
            'Sistemas FM' => 'Transmisión directa de voz del hablante al audífono',
            'Bucles magnéticos' => 'Sistemas de inducción para audífonos'
        ],
        'comunicacion' => [
            'Apps voz-texto' => 'Google Live Transcribe, Ava, RogerVoice',
            'Videollamadas' => 'Para comunicación en lengua de señas',
            'Subtítulos' => 'En TV, cine, plataformas streaming'
        ],
        'alertas' => [
            'Visuales' => 'Luces intermitentes para timbre, alarmas',
            'Vibratorias' => 'Relojes despertadores, notificaciones móvil'
        ]
    ],
    'educacion' => [
        'enfoques' => [
            'Bilingüe-bicultural' => 'LSC como primera lengua, español como segunda',
            'Inclusión' => 'Estudiantes sordos en aulas regulares con apoyo',
            'Escuelas especiales' => 'Enfocadas en estudiantes sordos'
        ],
        'apoyos' => [
            'Intérpretes LSC' => 'En aulas y eventos educativos',
            'Material visual' => 'Videos, infografías, presentaciones',
            'Tecnología' => 'Subtítulos, apps educativas'
        ],
        'derechos' => 'Decreto 1421 de 2017 sobre educación inclusiva'
    ],
    'comunicacion' => [
        'consejos' => [
            'Contacto visual' => 'Mirar a la persona al hablar',
            'Hablar claro' => 'Sin exagerar, velocidad normal',
            'Buena iluminación' => 'Facilita lectura labial',
            'No gritar' => 'No ayuda y puede molestar',
            'Usar gestos naturales' => 'Ayudan a la comprensión',
            'Escribir si es necesario' => 'Papel, celular, pizarra'
        ],
        'lectura_labial' => 'Solo capta 30-40% del mensaje, no es suficiente sola',
        'estrategias' => 'Parafrasear, confirmar comprensión, ser paciente'
    ],
    'derechos' => [
        'legislacion' => [
            'Ley 324 de 1996' => 'Reconoce LSC como lengua oficial',
            'Ley 982 de 2005' => 'Normas para equiparación de oportunidades',
            'Ley 1618 de 2013' => 'Derechos de personas con discapacidad',
            'Decreto 1421 de 2017' => 'Educación inclusiva'
        ],
        'servicios' => [
            'Intérpretes' => 'En servicios públicos, salud, justicia',
            'Subtítulos' => 'En medios de comunicación',
            'Accesibilidad' => 'En espacios públicos y privados'
        ]
    ]
];

class ImprovedChatbot
{
    private $kb;

    public function __construct($knowledge_base)
    {
        $this->kb = $knowledge_base;
    }

    // Normalizar texto
    private function normalize($text)
    {
        $text = mb_strtolower($text, 'UTF-8');
        // Remover tildes
        $text = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n'],
            $text
        );
        // Remover puntuación
        $text = preg_replace('/[^\w\s]/u', ' ', $text);
        // Normalizar espacios
        $text = preg_replace('/\s+/', ' ', trim($text));
        return $text;
    }

    // Detectar intención con mejor precisión
    private function detectIntent($message)
    {
        $norm = $this->normalize($message);
        $scores = [];

        // Patrones de intención
        $patterns = [
            'sordera' => ['sordera', 'sordo', 'sorda', 'perdida auditiva', 'hipoacusia', 'no oye', 'no escucha', 'deficiencia auditiva', 'que es sordera', 'tipos de sordera', 'grados', 'causas'],
            'lsc' => ['lsc', 'lengua de senas', 'lenguaje de senas', 'senas', 'gestos', 'comunicacion visual', 'como comunicarse', 'aprender senas'],
            'cultura_sorda' => ['cultura sorda', 'comunidad sorda', 'identidad sorda', 'valores', 'arte sordo', 'eventos'],
            'tecnologias' => ['audifonos', 'implante coclear', 'tecnologia', 'dispositivos', 'apps', 'aplicaciones', 'ayudas tecnicas', 'sistemas fm', 'alertas'],
            'educacion' => ['educacion', 'escuela', 'colegio', 'universidad', 'estudiar', 'aprender', 'inclusion', 'interprete', 'maestro'],
            'comunicacion' => ['como hablar', 'como comunicar', 'lectura labial', 'consejos', 'hablar con sordo', 'comunicarse'],
            'derechos' => ['derechos', 'ley', 'legislacion', 'normas', 'decreto', 'accesibilidad', 'servicios']
        ];

        foreach ($patterns as $intent => $keywords) {
            $score = 0;
            foreach ($keywords as $keyword) {
                if (strpos($norm, $keyword) !== false) {
                    $score += mb_strlen($keyword);
                }
            }
            if ($score > 0) {
                $scores[$intent] = $score;
            }
        }

        if (empty($scores)) {
            return null;
        }

        arsort($scores);
        return key($scores);
    }

    // Generar respuesta
    public function respond($message)
    {
        $intent = $this->detectIntent($message);

        if (!$intent) {
            return $this->fallbackResponse();
        }

        if (!isset($this->kb[$intent])) {
            return $this->fallbackResponse();
        }

        return $this->formatResponse($intent, $this->kb[$intent]);
    }

    // Formatear respuesta según intención
    private function formatResponse($intent, $data)
    {
        $response = '';

        switch ($intent) {
            case 'sordera':
                $response = "🔍 **Sobre la Sordera**\n\n";
                $response .= $data['definicion'] . "\n\n";
                $response .= "**Tipos:**\n";
                foreach ($data['tipos'] as $tipo => $desc) {
                    $response .= "• $tipo: $desc\n";
                }
                $response .= "\n**Grados de pérdida auditiva:**\n";
                foreach ($data['grados'] as $grado => $desc) {
                    $response .= "• $grado: $desc\n";
                }
                break;

            case 'lsc':
                $response = "🤟 **Lengua de Señas Colombiana (LSC)**\n\n";
                $response .= $data['definicion'] . "\n\n";
                $response .= "**Características:**\n";
                foreach ($data['caracteristicas'] as $car => $desc) {
                    $response .= "• $car: $desc\n";
                }
                $response .= "\n📊 Usuarios: " . $data['usuarios'];
                break;

            case 'cultura_sorda':
                $response = "👥 **Cultura Sorda**\n\n";
                $response .= $data['definicion'] . "\n\n";
                $response .= "**Valores fundamentales:**\n";
                foreach ($data['valores'] as $valor => $desc) {
                    $response .= "• $valor: $desc\n";
                }
                break;

            case 'tecnologias':
                $response = "🔧 **Tecnologías de Apoyo**\n\n";
                $response .= "**Dispositivos auditivos:**\n";
                foreach ($data['auditivas'] as $tech => $desc) {
                    $response .= "• $tech: $desc\n";
                }
                $response .= "\n**Comunicación:**\n";
                foreach ($data['comunicacion'] as $tech => $desc) {
                    $response .= "• $tech: $desc\n";
                }
                break;

            case 'educacion':
                $response = "📚 **Educación Inclusiva**\n\n";
                $response .= "**Enfoques educativos:**\n";
                foreach ($data['enfoques'] as $enf => $desc) {
                    $response .= "• $enf: $desc\n";
                }
                $response .= "\n**Apoyos necesarios:**\n";
                foreach ($data['apoyos'] as $apoyo => $desc) {
                    $response .= "• $apoyo: $desc\n";
                }
                break;

            case 'comunicacion':
                $response = "💬 **Comunicación Efectiva**\n\n";
                $response .= "**Consejos para comunicarte:**\n";
                foreach ($data['consejos'] as $consejo) {
                    $response .= "• $consejo\n";
                }
                $response .= "\n⚠️ Importante: " . $data['lectura_labial'];
                break;

            case 'derechos':
                $response = "⚖️ **Derechos y Legislación**\n\n";
                $response .= "**Marco legal en Colombia:**\n";
                foreach ($data['legislacion'] as $ley => $desc) {
                    $response .= "• $ley: $desc\n";
                }
                break;
        }

        return $response;
    }

    // Respuesta por defecto
    private function fallbackResponse()
    {
        return "🤔 No estoy seguro de entender tu pregunta.\n\n" .
            "Puedo ayudarte con información sobre:\n" .
            "• Sordera (tipos, causas, grados)\n" .
            "• Lengua de Señas Colombiana (LSC)\n" .
            "• Cultura sorda\n" .
            "• Tecnologías de apoyo\n" .
            "• Educación inclusiva\n" .
            "• Comunicación efectiva\n" .
            "• Derechos y legislación\n\n" .
            "¿Sobre qué te gustaría saber más?";
    }

    // Sugerencias inteligentes
    public function getSuggestions()
    {
        return [
            "¿Qué es la sordera?",
            "¿Cuáles son las causas de la sordera?",
            "¿Qué es la LSC?",
            "¿Cómo comunicarse con personas sordas?",
            "Tecnologías de apoyo auditivo",
            "Educación inclusiva",
            "Derechos de personas sordas"
        ];
    }
}

// Procesar solicitud
try {
    chatbot_log('Nueva solicitud: ' . $_SERVER['REQUEST_METHOD'] . ' IP ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode([
            'success' => true,
            'message' => 'API Chatbot EnSEÑAme',
            'version' => '2.0',
            'temas_disponibles' => array_keys($KNOWLEDGE_BASE)
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'error' => 'Método no permitido'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $raw = file_get_contents('php://input');
    chatbot_log('Body: ' . substr($raw, 0, 200));
    $data = $raw ? json_decode($raw, true) : null;

    $mensaje = $data['mensaje'] ?? ($_POST['mensaje'] ?? '');

    if (empty($mensaje)) {
        echo json_encode([
            'success' => false,
            'error' => 'Mensaje vacío'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    chatbot_log('Mensaje: ' . $mensaje);

    $bot = new ImprovedChatbot($KNOWLEDGE_BASE);
    $respuesta = $bot->respond($mensaje);

    $payload = [
        'success' => true,
        'respuesta' => $respuesta,
        'sugerencias' => $bot->getSuggestions(),
        'timestamp' => date('Y-m-d H:i:s')
    ];

    chatbot_log('OK respuesta: ' . substr($respuesta, 0, 120));
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    chatbot_log('ERROR: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error interno'
    ], JSON_UNESCAPED_UNICODE);
}
