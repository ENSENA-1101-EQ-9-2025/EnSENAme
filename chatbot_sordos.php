<?php

/**
 * ChatbotSordos - versión limpia y compacta
 * Provee detección sencilla de intención por palabras clave y respuestas predefinidas.
 */

class ChatbotSordos {
    private $contexto = [];
    private $ultimo_tema = null;
    private $contador = 0;

    private $palabras_clave = [
        'causas_principales' => ['causas','causa','por que','origen','genet','congenit','heredit','infeccion','ruido','medicamento','traumatismo','meningitis','otitis','ototox'],
        'definicion' => ['qué es','definición','concepto','tipos','sordera','pérdida auditiva','hipoacusia','anacusia','deficiencia auditiva'],
        'lengua_senas_colombiana' => ['lsc','lengua de senas','senas','lenguaje de senas','gestos','comunicacion visual','senas colombianas'],
        'cultura_sorda' => ['cultura sorda','comunidad sorda','identidad sorda','valores','tradiciones','arte sordo','teatro sordo'],
        'tecnologias_apoyo' => ['audifonos','implante coclear','tecnolog','dispositivos','apps','aplicaciones','ayudas tecnicas','sistemas fm']
    ];

    private $respuestas = [
        'causas_principales' => "Principales causas de sordera:\n- Congenitas (geneticas, infecciones maternas)\n- Adquiridas (ruido, infecciones, medicamentos ototoxicos, traumatismos, envejecimiento).\n¿Quieres detalles de alguna causa?",
        'definicion' => "🔍 ¿Qué es la sordera?\nLa sordera es la pérdida total o parcial de la audición.\nTipos por intensidad: leve (20-40 dB), moderada (40-70), severa (70-90), profunda (90+).\nTipos por localización: conductiva, neurosensorial y mixta.",
        'lengua_senas_colombiana' => "Lengua de Senas Colombiana (LSC): lengua visual-espacial con gramática propia. Organizaciones: INSOR, FENASCOL.",
        'cultura_sorda' => "Cultura sorda: identidad visual, lengua de senas como base, valores comunitarios, expresiones artísticas y eventos comunitarios.",
        'tecnologias_apoyo' => "Tecnologias de apoyo: audifonos, implantes cocleares, apps de transcripcion, videollamadas LSC y alertas visuales."
    ];

    public function __construct() {
        $this->debug_log('ChatbotSordos iniciado');
    }

    public function procesarMensaje($mensaje, $usuario_id = null) {
        $this->contador++;
        $msg = trim((string)$mensaje);
        if ($this->esSaludo($msg)) return $this->saludo();
        if ($this->esDespedida($msg)) return $this->despedida();
        if ($this->esAgradecimiento($msg)) return $this->agradecimiento();

        $sec = $this->detectarSeccion($msg);
        if ($sec && isset($this->respuestas[$sec])) {
            $this->ultimo_tema = $sec;
            $this->contexto[] = ['m'=>$msg,'t'=>$sec,'ts'=>time()];
            return $this->respuestas[$sec];
        }

        return $this->fallback();
    }

    private function esSaludo($m){
        $m = mb_strtolower($m,'UTF-8');
        foreach(['hola','buenos dias','buenas tardes','buenas noches','hey','hi'] as $w){
            if(mb_strpos($m,$w)!==false) return true;
        }
        return false;
    }

    private function esDespedida($m){
        $m = mb_strtolower($m,'UTF-8');
        foreach(['adios','hasta luego','nos vemos','chao','bye'] as $w){
            if(mb_strpos($m,$w)!==false) return true;
        }
        return false;
    }

    private function esAgradecimiento($m){
        $m = mb_strtolower($m,'UTF-8');
        foreach(['gracias','muchas gracias','te agradezco','thanks'] as $w){
            if(mb_strpos($m,$w)!==false) return true;
        }
        return false;
    }

    private function detectarSeccion($m){
        $m = mb_strtolower($m,'UTF-8');
        $scores = [];
        foreach($this->palabras_clave as $sec=>$pal){
            $s = 0;
            foreach($pal as $p){
                if(mb_strpos($m, mb_strtolower($p,'UTF-8')) !== false) {
                    $s += mb_strlen($p,'UTF-8');
                }
            }
            if($s>0) $scores[$sec] = $s;
        }
        if($scores){
            arsort($scores);
            reset($scores);
            return key($scores);
        }
        return null;
    }

    private function saludo(){
        return "¡Hola! 👋 Puedo ayudarte con: causas de sordera, LSC, cultura sorda, tecnologías de apoyo y educación inclusiva. ¿Sobre qué te gustaría aprender?";
    }

    private function despedida(){ return "¡Hasta luego! 👋 Vuelve cuando quieras para saber más sobre sordera o LSC."; }
    private function agradecimiento(){ return "¡De nada! 😊 ¿Quieres profundizar en algún tema?"; }
    private function fallback(){ return "No estoy seguro de entender tu pregunta. Puedo ayudarte con: causas de sordera, LSC, cultura sorda, tecnologías de apoyo y educación inclusiva. ¿Podrías ser más específico?"; }

    public function obtenerSugerencias(){
        return ["¿Qué es la sordera?","¿Cuáles son las causas de la sordera?","¿Qué es la LSC?","¿Cómo comunicarse con personas sordas?","Tecnologías de apoyo auditivo"];
    }

    private function debug_log($mensaje){
        $ts = date('Y-m-d H:i:s');
        @file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'chatbot_debug.log', "[$ts] $mensaje".PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

?>

        }                         "**🌟 Características principales:**\n" .    ];

        

        // Respuesta por defecto                         "• **Identidad visual:** El mundo se percibe principalmente por la vista\n" .    

        $this->debug_log("Respuesta por defecto - no se detectó tema específico");

        return $this->obtenerRespuestaDefault();                         "• **Lengua de señas:** Base fundamental de la comunicación\n" .    private $respuestas_generales = [

    }

                         "• **Valores comunitarios:** Solidaridad y apoyo mutuo\n" .        'saludo' => '¡Hola! Soy el asistente de EnSEÑAme. Puedo ayudarte con información sobre sordera, LSC y la comunidad sorda. ¿En qué te puedo ayudar?',

    /**

     * Detectar si es saludo                         "• **Arte y expresión:** Teatro, poesía visual, narrativa en señas\n\n" .        'despedida' => '¡Hasta luego! Recuerda que siempre puedes preguntarme sobre sordera y lengua de señas. ¡Que tengas un buen día!',

     */

    private function esSaludo($mensaje) {                         "**🎨 Manifestaciones culturales:**\n" .        'no_entiendo' => 'No estoy seguro de entender tu pregunta. Puedo ayudarte con información sobre: causas de sordera, LSC, cultura sorda, tecnologías de apoyo, educación inclusiva y más. ¿Podrías ser más específico?',

        $saludos = ['hola', 'buenos días', 'buenas tardes', 'buenas noches', 'hey', 'hi'];

        $mensaje_lower = strtolower($mensaje);                         "• Festivales de arte sordo\n" .        'agradecimiento' => '¡De nada! Me alegra poder ayudarte a aprender más sobre la comunidad sorda y la LSC. ¿Hay algo más en lo que pueda ayudarte?'

        

        foreach ($saludos as $saludo) {                         "• Competencias deportivas (Sordolimpicos)\n" .    ];

            if (strpos($mensaje_lower, $saludo) !== false) {

                return true;                         "• Literatura y poesía en LSC\n" .    

            }

        }                         "• Teatro y performance visual\n\n" .    private $preguntas_frecuentes = [

        return false;

    }                         "**🏛️ Organizaciones importantes:**\n" .        // Preguntas básicas sobre sordera



    /**                         "• FENASCOL a nivel nacional\n" .        'es lo mismo sordo que mudo' => [

     * Detectar si es despedida

     */                         "• Asociaciones regionales\n" .            'respuesta' => "❌ **No, sordo y mudo NO es lo mismo**\n\n" .

    private function esDespedida($mensaje) {

        $despedidas = ['adiós', 'hasta luego', 'nos vemos', 'chao', 'bye'];                         "• Clubes deportivos y culturales\n\n" .                          "• **Sordo:** Persona con pérdida auditiva\n" .

        $mensaje_lower = strtolower($mensaje);

                                 "¿Quieres conocer eventos o actividades específicas?",                          "• **Mudo:** Persona que no puede hablar (muy raro)\n\n" .

        foreach ($despedidas as $despedida) {

            if (strpos($mensaje_lower, $despedida) !== false) {                                                   "**Error común:** Decir 'sordomudo'\n" .

                return true;

            }        'tecnologias_apoyo' => "🔧 **Tecnologías de Apoyo Auditivo**\n\n" .                          "**Correcto:** Persona sorda\n\n" .

        }

        return false;                             "**🦻 Audífonos:**\n" .                          "La mayoría de personas sordas SÍ pueden hablar, pero prefieren la lengua de señas como su forma natural de comunicación.",

    }

                             "• Retroauriculares (BTE)\n" .            'tags' => ['sordomudo', 'mudo', 'hablar', 'voz']

    /**

     * Detectar si es agradecimiento                             "• Intraauriculares (ITE, ITC, CIC)\n" .        ],

     */

    private function esAgradecimiento($mensaje) {                             "• Con conexión Bluetooth\n" .        

        $agradecimientos = ['gracias', 'muchas gracias', 'te agradezco', 'thanks'];

        $mensaje_lower = strtolower($mensaje);                             "• Costo: $800,000 - $8,000,000 COP\n\n" .        'pueden conducir los sordos' => [

        

        foreach ($agradecimientos as $agradecimiento) {                             "**🧠 Implantes Cocleares:**\n" .            'respuesta' => "✅ **¡Por supuesto que SÍ pueden conducir!**\n\n" .

            if (strpos($mensaje_lower, $agradecimiento) !== false) {

                return true;                             "• Para sorderas severas/profundas\n" .                          "• **Legalmente:** Permitido en Colombia y todo el mundo\n" .

            }

        }                             "• Estimulación directa del nervio auditivo\n" .                          "• **Estadísticamente:** Son conductores MÁS seguros\n" .

        return false;

    }                             "• Proceso quirúrgico + rehabilitación\n" .                          "• **Ventaja:** Agudeza visual superior\n" .



    /**                             "• Cubierto por sistema de salud en casos elegibles\n\n" .                          "• **Compensación:** Mayor atención a señales visuales\n\n" .

     * Detectar sección usando palabras clave

     */                             "**📱 Apps y Tecnología:**\n" .                          "**Adaptaciones disponibles:**\n" .

    private function detectarSeccion($mensaje) {

        $mensaje_lower = strtolower($mensaje);                             "• Transcripción en tiempo real\n" .                          "• Espejos adicionales\n" .

        $coincidencias = [];

                                     "• Videollamadas para LSC\n" .                          "• Alertas visuales\n" .

        foreach ($this->palabras_clave as $seccion => $palabras) {

            $score = 0;                             "• Alertas visuales y vibratorias\n" .                          "• Sistemas de vibración\n\n" .

            foreach ($palabras as $palabra) {

                if (strpos($mensaje_lower, strtolower($palabra)) !== false) {                             "• Amplificadores de sonido portátiles\n\n" .                          "La conducción NO requiere audición, solo atención visual.",

                    $score += strlen($palabra);

                }                             "¿Necesitas información específica sobre alguna tecnología?"            'tags' => ['conducir', 'manejar', 'licencia', 'carro', 'auto']

            }

            if ($score > 0) {    ];        ],

                $coincidencias[$seccion] = $score;

            }            

        }

            // Respuestas conversacionales        'cuánto cuesta un audífono' => [

        if (!empty($coincidencias)) {

            $mejor_seccion = array_keys($coincidencias, max($coincidencias))[0];    private $respuestas_conversacion = [            'respuesta' => "💰 **Costos de audífonos en Colombia (2024):**\n\n" .

            $this->debug_log("Mejor coincidencia: $mejor_seccion (score: {$coincidencias[$mejor_seccion]})");

            return $mejor_seccion;        'saludo' => "¡Hola! 👋 Soy tu asistente especializado en información sobre sordera y LSC. " .                          "**🟢 Básicos:** $800,000 - $2,000,000 COP\n" .

        }

                           "Puedo ayudarte con temas como:\n\n" .                          "• Amplificación simple\n" .

        return null;

    }                   "• Causas y tipos de sordera\n" .                          "• Funciones básicas\n" .



    /**                   "• Lengua de Señas Colombiana\n" .                          "• Duración: 3-5 años\n\n" .

     * Respuesta de saludo

     */                   "• Cultura sorda\n" .                          "**🟡 Intermedios:** $2,000,000 - $4,000,000 COP\n" .

    private function obtenerSaludo() {

        return "¡Hola! 👋 Soy tu asistente especializado en información sobre sordera y LSC.\n\n" .                   "• Tecnologías de apoyo\n" .                          "• Reducción de ruido\n" .

               "Puedo ayudarte con:\n" .

               "• Causas y tipos de sordera\n" .                   "• Educación inclusiva\n\n" .                          "• Conectividad Bluetooth\n" .

               "• Lengua de Señas Colombiana\n" .

               "• Cultura sorda\n" .                   "¿Sobre qué te gustaría aprender hoy?",                          "• Programas múltiples\n\n" .

               "• Tecnologías de apoyo\n" .

               "• Educación inclusiva\n\n" .                                             "**🔴 Avanzados:** $4,000,000 - $8,000,000 COP\n" .

               "¿Sobre qué te gustaría aprender hoy?";

    }        'despedida' => "¡Hasta luego! 👋 Espero haber sido de ayuda. " .                          "• IA y procesamiento avanzado\n" .



    /**                      "Recuerda que siempre puedes volver a consultarme sobre sordera, LSC o cultura sorda. " .                          "• Recargables\n" .

     * Respuesta de despedida

     */                      "¡Que tengas un excelente día! 🌟",                          "• Apps móviles\n\n" .

    private function obtenerDespedida() {

        return "¡Hasta luego! 👋 Espero haber sido de ayuda.\n" .                                                "**💡 Financiación:**\n" .

               "Recuerda que siempre puedes consultarme sobre sordera, LSC o cultura sorda.\n" .

               "¡Que tengas un excelente día! 🌟";        'agradecimiento' => "¡De nada! 😊 Me alegra poder ayudarte. " .                          "• EPS: Cubre según criterios médicos\n" .

    }

                          "Si tienes más preguntas sobre sordera, LSC o cualquier tema relacionado, " .                          "• Cuotas: Disponibles en audiológicas\n" .

    /**

     * Respuesta de agradecimiento                          "no dudes en preguntarme. ¡Estoy aquí para apoyarte! 💪",                          "• Fundaciones: Programas de apoyo",

     */

    private function obtenerAgradecimiento() {                                      'tags' => ['precio', 'costo', 'cuánto vale', 'financiar', 'pagar']

        return "¡De nada! 😊 Me alegra poder ayudarte.\n" .

               "Si tienes más preguntas sobre sordera, LSC o cualquier tema relacionado, " .        'no_entiendo' => "No estoy seguro de entender tu pregunta. " .        ],

               "no dudes en preguntarme. ¡Estoy aquí para apoyarte! 💪";

    }                        "Puedo ayudarte con información sobre:\n" .        



    /**                        "• Causas de sordera\n• LSC\n• Cultura sorda\n• Tecnologías de apoyo\n• Educación inclusiva\n\n" .        'cómo aprender lengua de señas' => [

     * Respuesta por defecto

     */                        "¿Podrías ser más específico?"            'respuesta' => "📚 **Cómo aprender Lengua de Señas Colombiana:**\n\n" .

    private function obtenerRespuestaDefault() {

        return "No estoy seguro de entender tu pregunta. " .    ];                          "**🏫 Presencial:**\n" .

               "Puedo ayudarte con información sobre:\n" .

               "• Causas de sordera\n" .                          "• INSOR (Bogotá) - Cursos oficiales\n" .

               "• LSC\n" .

               "• Cultura sorda\n" .    /**                          "• FENASCOL - Programas comunitarios\n" .

               "• Tecnologías de apoyo\n" .

               "• Educación inclusiva\n\n" .     * Constructor de la clase                          "• Universidad Pedagógica - Diplomados\n" .

               "¿Podrías ser más específico?";

    }     */                          "• Asociaciones locales de sordos\n\n" .



    /**    public function __construct() {                          "**💻 Virtual:**\n" .

     * Obtener sugerencias

     */        $this->debug_log("ChatbotSordos iniciado correctamente");                          "• Plataforma INSOR online\n" .

    public function obtenerSugerencias() {

        return [    }                          "• Apps: LSC Colombia, Sign School\n" .

            "¿Qué es la sordera?",

            "¿Cuáles son las causas de la sordera?",                          "• YouTube: Canales especializados\n" .

            "¿Qué es la LSC?",

            "¿Cómo comunicarse con personas sordas?",    /**                          "• Zoom con instructores sordos\n\n" .

            "¿Los sordos pueden conducir?",

            "¿Cuánto cuesta un audífono?",     * Método principal para procesar mensajes                          "**⏱️ Tiempos:**\n" .

            "¿Cómo aprender lengua de señas?",

            "¿Qué es un implante coclear?",     */                          "• Básico: 6-12 meses\n" .

            "Cultura de la comunidad sorda",

            "Tecnologías de apoyo auditivo"    public function procesarMensaje($mensaje, $usuario_id = null) {                          "• Conversacional: 1-2 años\n" .

        ];

    }        $this->contador_preguntas++;                          "• Fluidez: 3-5 años\n\n" .



    /**        $mensaje = trim($mensaje);                          "**💡 Consejo:** Practica con la comunidad sorda local",

     * Función de debug

     */                    'tags' => ['curso', 'estudiar', 'enseñar', 'donde', 'cómo']

    private function debug_log($mensaje) {

        $timestamp = date('Y-m-d H:i:s');        $this->debug_log("Procesando mensaje #{$this->contador_preguntas}: $mensaje");        ],

        $log_entry = "[$timestamp] $mensaje" . PHP_EOL;

        file_put_contents('chatbot_debug.log', $log_entry, FILE_APPEND | LOCK_EX);                

    }

}        // Manejar casos especiales        'qué es un implante coclear' => [

?>
        if ($this->esSaludo($mensaje)) {            'respuesta' => "🔬 **Implante Coclear - Guía completa:**\n\n" .

            return $this->respuestas_conversacion['saludo'];                          "**¿Qué es?**\n" .

        }                          "Dispositivo electrónico que estimula directamente el nervio auditivo, 'saltándose' el oído dañado.\n\n" .

                                  "**¿Para quién?**\n" .

        if ($this->esDespedida($mensaje)) {                          "• Pérdida severa-profunda\n" .

            return $this->respuestas_conversacion['despedida'];                          "• Poco beneficio de audífonos\n" .

        }                          "• Nervio auditivo funcional\n" .

                                  "• Motivación para rehabilitación\n\n" .

        if ($this->esAgradecimiento($mensaje)) {                          "**Proceso:**\n" .

            return $this->respuestas_conversacion['agradecimiento'];                          "1. Evaluación médica completa\n" .

        }                          "2. Cirugía (2-3 horas)\n" .

                                  "3. Activación (4-6 semanas después)\n" .

        // Detectar sección del mensaje                          "4. Rehabilitación auditiva (meses)\n\n" .

        $seccion = $this->detectarSeccion($mensaje);                          "**Resultados esperados:**\n" .

        $this->debug_log("Sección detectada: $seccion");                          "• Detección de sonidos ambientales\n" .

                                  "• Comprensión del habla\n" .

        if ($seccion && isset($this->respuestas_base[$seccion])) {                          "• Uso del teléfono (muchos casos)\n" .

            $this->ultimo_tema = $seccion;                          "• Disfrute de música\n\n" .

            $this->contexto_conversacion[] = [                          "**💰 Costo:** $35-60 millones COP (cubierto por POS según criterios)",

                'mensaje' => $mensaje,            'tags' => ['implante', 'cirugía', 'operación', 'electrodo']

                'tema' => $seccion,        ],

                'timestamp' => time()        

            ];        'sordos pueden tener hijos sordos' => [

                        'respuesta' => "🧬 **Genética y sordera:**\n\n" .

            $this->debug_log("Devolviendo respuesta para sección: $seccion");                          "**Probabilidades reales:**\n" .

            return $this->respuestas_base[$seccion];                          "• Padres sordos → hijo sordo: **10-25%**\n" .

        }                          "• Padres oyentes → hijo sordo: **0.1-0.3%**\n" .

                                  "• Un padre sordo → hijo sordo: **5-15%**\n\n" .

        // Si no encuentra sección específica, respuesta por defecto                          "**Factores determinantes:**\n" .

        $this->debug_log("No se encontró sección específica, devolviendo respuesta por defecto");                          "• Tipo de sordera (genética vs adquirida)\n" .

        return $this->respuestas_conversacion['no_entiendo'];                          "• Patrón de herencia familiar\n" .

    <?php

    /**
     * ChatbotSordos - versión limpia y compacta
     * Provee detección sencilla de intención por palabras clave y respuestas predefinidas.
     */

    class ChatbotSordos {
        private $contexto = [];
        private $ultimo_tema = null;
        private $contador = 0;

        private $palabras_clave = [
            'causas_principales' => ['causas','causa','por que','origen','genet','congenit','heredit','infeccion','ruido','medicamento','traumatismo','meningitis','otitis','ototox'],
            'definicion' => ['que es','definicion','concepto','tipos','sordera','perdida auditiva','hipoacusia','anacusia'],
            'lengua_senas_colombiana' => ['lsc','lengua de senas','senas','lenguaje de senas','gestos','comunicacion visual','senas colombianas'],
            'cultura_sorda' => ['cultura sorda','comunidad sorda','identidad sorda','valores','tradiciones','arte sordo','teatro sordo'],
            'tecnologias_apoyo' => ['audifonos','implante coclear','tecnolog','dispositivos','apps','aplicaciones','ayudas tecnicas','sistemas fm']
        ];

        private $respuestas = [
            'causas_principales' => "Principales causas de sordera:\n- Congenitas (geneticas, infecciones maternas)\n- Adquiridas (ruido, infecciones, medicamentos ototoxicos, traumatismos, envejecimiento).\n¿Quieres detalles de alguna causa?",
            'definicion' => "¿Qué es la sordera?\nLa sordera es la perdida total o parcial de la audicion. Tipos por intensidad: leve, moderada, severa, profunda. Tipos por localizacion: conductiva, neurosensorial, mixta.",
            'lengua_senas_colombiana' => "Lengua de Senas Colombiana (LSC): lengua visual-espacial con gramática propia. Organizaciones: INSOR, FENASCOL.",
            'cultura_sorda' => "Cultura sorda: identidad visual, lengua de senas como base, valores comunitarios, expresiones artísticas y eventos comunitarios.",
            'tecnologias_apoyo' => "Tecnologias de apoyo: audifonos, implantes cocleares, apps de transcripcion, videollamadas LSC y alertas visuales."
        ];

        public function __construct() {
            $this->debug_log('ChatbotSordos iniciado');
        }

        public function procesarMensaje($mensaje, $usuario_id = null) {
            $this->contador++;
            $msg = trim((string)$mensaje);
            if ($this->esSaludo($msg)) return $this->saludo();
            if ($this->esDespedida($msg)) return $this->despedida();
            if ($this->esAgradecimiento($msg)) return $this->agradecimiento();

            $sec = $this->detectarSeccion($msg);
            if ($sec && isset($this->respuestas[$sec])) {
                $this->ultimo_tema = $sec;
                $this->contexto[] = ['m'=>$msg,'t'=>$sec,'ts'=>time()];
                return $this->respuestas[$sec];
            }

            return $this->fallback();
        }

        private function esSaludo($m){
            $m = mb_strtolower($m,'UTF-8');
            foreach(['hola','buenos dias','buenas tardes','buenas noches','hey','hi'] as $w){
                if(mb_strpos($m,$w)!==false) return true;
            }
            return false;
        }

        private function esDespedida($m){
            $m = mb_strtolower($m,'UTF-8');
            foreach(['adios','hasta luego','nos vemos','chao','bye'] as $w){
                if(mb_strpos($m,$w)!==false) return true;
            }
            return false;
        }

        private function esAgradecimiento($m){
            $m = mb_strtolower($m,'UTF-8');
            foreach(['gracias','muchas gracias','te agradezco','thanks'] as $w){
                if(mb_strpos($m,$w)!==false) return true;
            }
            return false;
        }

        private function detectarSeccion($m){
            $m = mb_strtolower($m,'UTF-8');
            $scores = [];
            foreach($this->palabras_clave as $sec=>$pal){
                $s = 0;
                foreach($pal as $p){
                    if(mb_strpos($m, mb_strtolower($p,'UTF-8')) !== false) {
                        $s += mb_strlen($p,'UTF-8');
                    }
                }
                if($s>0) $scores[$sec] = $s;
            }
            if($scores){
                arsort($scores);
                reset($scores);
                return key($scores);
            }
            return null;
        }

        private function saludo(){
            return "¡Hola! 👋 Puedo ayudarte con: causas de sordera, LSC, cultura sorda, tecnologías de apoyo y educación inclusiva. ¿Sobre qué te gustaría aprender?";
        }

        private function despedida(){ return "¡Hasta luego! 👋 Vuelve cuando quieras para saber más sobre sordera o LSC."; }
        private function agradecimiento(){ return "¡De nada! 😊 ¿Quieres profundizar en algún tema?"; }
        private function fallback(){ return "No estoy seguro de entender tu pregunta. Puedo ayudarte con: causas de sordera, LSC, cultura sorda, tecnologías de apoyo y educación inclusiva. ¿Podrías ser más específico?"; }

        public function obtenerSugerencias(){
            return ["¿Qué es la sordera?","¿Cuáles son las causas de la sordera?","¿Qué es la LSC?","¿Cómo comunicarse con personas sordas?","Tecnologías de apoyo auditivo"];
        }

        private function debug_log($mensaje){
            $ts = date('Y-m-d H:i:s');
            @file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'chatbot_debug.log', "[$ts] $mensaje".PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    ?>
        $log_entry = "[$timestamp] $mensaje" . PHP_EOL;            'más detalles', 'explicar mejor', 'más sobre', 'continuar'

        file_put_contents('chatbot_debug.log', $log_entry, FILE_APPEND | LOCK_EX);        ];

    }        

}        foreach ($palabras_seguimiento as $palabra) {

            if (strpos($mensaje, $palabra) !== false) {

/**                return true;

 * Función helper para detectar mensajes del chatbot            }

 */        }

function esMensajeChatbot($mensaje, $usuario_id = null) {        

    // Palabras que activan el chatbot        return false;

    $palabras_activacion = [    }

        'sordera', 'sordo', 'sorda', 'lsc', 'señas', 'cultura sorda',     

        'audífono', 'implante', 'pérdida auditiva', 'hipoacusia'    private function manejarSeguimiento($mensaje) {

    ];        if ($this->ultimo_tema) {

                $this->debug_log("Detectado seguimiento para tema: {$this->ultimo_tema}");

    $mensaje_lower = strtolower($mensaje);            

                // Proporcionar información adicional del último tema

    // Verificar palabras de activación            switch ($this->ultimo_tema) {

    foreach ($palabras_activacion as $palabra) {                case 'lengua_señas_colombiana':

        if (strpos($mensaje_lower, $palabra) !== false) {                    return $this->informacionAdicionalLSC();

            return true;                case 'tecnologias_apoyo':

        }                    return $this->informacionAdicionalTecnologia();

    }                case 'cultura_sorda':

                        return $this->informacionAdicionalCultura();

    // Activar también con preguntas generales                case 'inclusion_educativa':

    if (strpos($mensaje_lower, '?') !== false ||                     return $this->informacionAdicionalEducacion();

        strpos($mensaje_lower, 'qué') !== false ||                default:

        strpos($mensaje_lower, 'cómo') !== false ||                    return $this->informacionGenericaAdicional($this->ultimo_tema);

        strpos($mensaje_lower, 'por qué') !== false) {            }

        return true;        }

    }        

            return "Para darte más información específica, ¿podrías decirme sobre qué tema quieres profundizar? " .

    return false;               "Puedo ampliar información sobre LSC, tecnologías, cultura sorda, educación, etc.";

}    }

    

/**    private function sugerirTemasPopulares() {

 * Función principal para usar el chatbot en otras partes del sistema        return "\n\n💡 **Temas populares hoy:**\n" .

 */               "• ¿Cómo aprender lengua de señas?\n" .

function procesarMensajeChatbot($mensaje, $usuario_id = null) {               "• ¿Qué tecnologías ayudan a personas sordas?\n" .

    if (!esMensajeChatbot($mensaje, $usuario_id)) {               "• ¿Cómo comunicarme respetuosamente?\n" .

        return null;               "• ¿Cuáles son los mitos sobre la sordera?";

    }    }

        

    $chatbot = new ChatbotSordos();    private function sugerirContinuacion() {

    $respuesta = $chatbot->procesarMensaje($mensaje, $usuario_id);        if ($this->ultimo_tema) {

                return "\n\n¿Te gustaría profundizar más en el tema de " . 

    return [                   $this->nombreAmigableTema($this->ultimo_tema) . 

        'es_bot' => true,                   " o prefieres explorar otro aspecto?";

        'respuesta' => $respuesta,        }

        'sugerencias' => $chatbot->obtenerSugerencias()        

    ];        return "\n\n¿Hay algún otro aspecto sobre la comunidad sorda que te interese conocer?";

}    }

    

// Prueba directa si se llama el archivo    private function nombreAmigableTema($tema) {

if (isset($_GET['test'])) {        $nombres = [

    header('Content-Type: application/json; charset=utf-8');            'lengua_señas_colombiana' => 'lengua de señas colombiana',

                'tecnologias_apoyo' => 'tecnologías de apoyo',

    $chatbot = new ChatbotSordos();            'cultura_sorda' => 'cultura sorda',

    $mensaje = $_GET['mensaje'] ?? '¿Qué es la sordera?';            'inclusion_educativa' => 'educación inclusiva',

                'causas_principales' => 'causas de la sordera',

    $respuesta = $chatbot->procesarMensaje($mensaje);            'grados_perdida' => 'grados de pérdida auditiva',

                'mitos_realidades' => 'mitos y realidades',

    echo json_encode([            'como_comunicarse' => 'comunicación efectiva',

        'mensaje' => $mensaje,            'prevencion_salud' => 'prevención y salud auditiva',

        'respuesta' => $respuesta,            'investigacion_avances' => 'investigación y avances'

        'sugerencias' => $chatbot->obtenerSugerencias()        ];

    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);        

}        return $nombres[$tema] ?? $tema;

?>    }
    
    private function informacionAdicionalLSC() {
        return "📚 **Información adicional sobre LSC:**\n\n" .
               "**🎓 Dónde aprender LSC en Colombia:**\n" .
               "• INSOR - Cursos oficiales en Bogotá\n" .
               "• FENASCOL - Programas comunitarios\n" .
               "• Universidades: Pedagógica Nacional, Minuto de Dios\n" .
               "• Apps móviles: LSC Colombia, Sign School\n" .
               "• YouTube: Canales especializados en LSC\n\n" .
               "**⏱️ Tiempo de aprendizaje:**\n" .
               "• Básico conversacional: 6-12 meses\n" .
               "• Intermedio: 1-2 años\n" .
               "• Fluidez: 3-5 años de práctica constante\n\n" .
               "**💰 Costos aproximados:**\n" .
               "• Cursos presenciales: $200,000-500,000 COP\n" .
               "• Cursos virtuales: $100,000-300,000 COP\n" .
               "• Apps premium: $50,000-100,000 COP/año\n\n" .
               "¿Te interesa información sobre algún curso específico o metodología de aprendizaje?";
    }
    
    private function informacionAdicionalTecnologia() {
        return "🔧 **Información adicional sobre tecnologías:**\n\n" .
               "**💰 Costos en Colombia (2024):**\n" .
               "• Audífonos básicos: $800,000-2,000,000 COP\n" .
               "• Audífonos avanzados: $3,000,000-8,000,000 COP\n" .
               "• Implante coclear: $35,000,000-60,000,000 COP\n" .
               "• Sistemas FM: $1,500,000-4,000,000 COP\n\n" .
               "**🏥 Cobertura de salud:**\n" .
               "• EPS: Cubre audífonos según criterios médicos\n" .
               "• POS: Incluye implantes cocleares para candidatos\n" .
               "• Entidades territoriales: Apoyo adicional\n" .
               "• Fundaciones: Programas de donación\n\n" .
               "**📱 Apps gratuitas recomendadas:**\n" .
               "• Google Live Transcribe (subtítulos en vivo)\n" .
               "• Ava (conversaciones grupales)\n" .
               "• Sound Amplifier (amplificación personalizada)\n" .
               "• Be My Eyes (asistencia visual)\n\n" .
               "¿Necesitas información sobre el proceso para acceder a alguna tecnología específica?";
    }
    
    private function informacionAdicionalCultura() {
        return "👥 **Más sobre la cultura sorda:**\n\n" .
               "**🎭 Eventos culturales en Colombia:**\n" .
               "• Festival Nacional de Arte y Cultura Sorda (anual)\n" .
               "• Semana Internacional de las Personas Sordas (septiembre)\n" .
               "• Encuentros deportivos sordos regionales\n" .
               "• Obras de teatro en LSC en ciudades principales\n\n" .
               "**🏛️ Organizaciones principales:**\n" .
               "• FENASCOL: Federación nacional\n" .
               "• ASONAL: Asociación de jóvenes sordos\n" .
               "• Organizaciones regionales en cada departamento\n" .
               "• Clubes deportivos sordos locales\n\n" .
               "**🎨 Expresiones artísticas únicas:**\n" .
               "• Poesía visual en LSC\n" .
               "• Teatro con narrativa visual\n" .
               "• Danza e interpretación corporal\n" .
               "• Arte visual con temática sorda\n\n" .
               "**📅 Cómo participar:**\n" .
               "• Seguir redes sociales de FENASCOL\n" .
               "• Asistir a eventos públicos\n" .
               "• Aprender LSC básica\n" .
               "• Mostrar respeto y interés genuino\n\n" .
               "¿Te gustaría información sobre eventos específicos en tu ciudad?";
    }
    
    private function informacionAdicionalEducacion() {
        return "🎓 **Más sobre educación inclusiva:**\n\n" .
               "**🏫 Instituciones destacadas en Colombia:**\n" .
               "• Instituto Pedagógico Nacional (Bogotá)\n" .
               "• Escuela de Sordos de Cali\n" .
               "• Instituto para Sordos de Barranquilla\n" .
               "• Institución Educativa Francisco Luis Hernández (Medellín)\n\n" .
               "**📊 Modalidades educativas:**\n" .
               "• **Bilingüe-bicultural:** LSC como L1, español escrito como L2\n" .
               "• **Inclusión con apoyo:** Aula regular + intérprete\n" .
               "• **Educación especial:** Instituciones especializadas\n" .
               "• **Virtual:** Plataformas accesibles con LSC\n\n" .
               "**👨‍🏫 Formación de docentes:**\n" .
               "• Especializaciones en educación bilingüe\n" .
               "• Cursos de LSC para docentes\n" .
               "• Diplomados en inclusión educativa\n" .
               "• Intercambios con países líderes\n\n" .
               "**📚 Materiales adaptados:**\n" .
               "• Libros con ilustraciones y LSC\n" .
               "• Videos educativos subtitulados\n" .
               "• Plataformas interactivas visuales\n" .
               "• Diccionarios LSC-español\n\n" .
               "¿Te interesa información sobre alguna institución específica o modalidad educativa?";
    }
    
    private function informacionGenericaAdicional($tema) {
        return "📖 Para profundizar en " . $this->nombreAmigableTema($tema) . 
               ", puedo proporcionarte información más específica. " .
               "¿Qué aspecto particular te interesa más? Por ejemplo:\n\n" .
               "• Detalles técnicos\n" .
               "• Experiencias personales\n" .
               "• Recursos y enlaces\n" .
               "• Estadísticas actualizadas\n" .
               "• Casos de éxito\n\n" .
               "También puedo conectarte con expertos o recursos adicionales según tu interés.";
    }
    
    private function esSaludo($mensaje) {
        $saludos = ['hola', 'buenos días', 'buenas tardes', 'buenas noches', 'hey', 'hi'];
        foreach ($saludos as $saludo) {
            if (strpos($mensaje, $saludo) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function esDespedida($mensaje) {
        $despedidas = ['adiós', 'chao', 'hasta luego', 'nos vemos', 'bye', 'gracias'];
        foreach ($despedidas as $despedida) {
            if (strpos($mensaje, $despedida) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function esAgradecimiento($mensaje) {
        $agradecimientos = ['gracias', 'thank you', 'excelente', 'perfecto', 'muy bien'];
        foreach ($agradecimientos as $agradecimiento) {
            if (strpos($mensaje, $agradecimiento) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function detectarSeccion($mensaje) {
        foreach ($this->palabras_clave as $seccion => $palabras) {
            foreach ($palabras as $palabra) {
                if (strpos($mensaje, $palabra) !== false) {
                    return $seccion;
                }
            }
        }
        return null;
    }
    
    private function obtenerInformacion($seccion, $mensaje_original = '') {
        try {
            // Detectar nivel de detalle solicitado
            $nivel = $this->detectarNivelDetalle($mensaje_original);
            $this->debug_log("Nivel de detalle detectado: $nivel para sección: $seccion");
            
            $this->debug_log("Obteniendo información de la sección: $seccion");
            
            // En lugar de incluir el archivo con headers, obtenemos los datos directamente
            $response = $this->obtenerDatosSeccion($seccion);
            $this->debug_log("Datos obtenidos para sección $seccion");
            
            $data = json_decode($response, true);
            
            if ($data && $data['success']) {
                return $this->formatearRespuesta($seccion, $data['data'], $mensaje_original, $nivel);
            }
        } catch (Exception $e) {
            // Fallback si no se puede acceder a la API
            return $this->obtenerRespuestaFallback($seccion);
        }
        
        return $this->respuestas_generales['no_entiendo'];
    }
    
    private function detectarNivelDetalle($mensaje) {
        $this->debug_log("Detectando nivel de detalle para: $mensaje");
        $palabras_basico = ['básico', 'simple', 'fácil', 'rápido', 'resumen', 'breve', 'qué es'];
        $palabras_intermedio = ['explicar', 'detalles', 'cómo', 'por qué', 'información'];
        $palabras_avanzado = ['profundo', 'completo', 'técnico', 'especializado', 'investigación', 'todo sobre', 'ampliar'];
        
        $mensaje_lower = strtolower($mensaje);
        
        foreach ($palabras_avanzado as $palabra) {
            if (strpos($mensaje_lower, $palabra) !== false) {
                return 'avanzado';
            }
        }
        
        foreach ($palabras_intermedio as $palabra) {
            if (strpos($mensaje_lower, $palabra) !== false) {
                return 'intermedio';
            }
        }
        
        foreach ($palabras_basico as $palabra) {
            if (strpos($mensaje_lower, $palabra) !== false) {
                return 'basico';
            }
        }
        
        // Detectar por contexto de conversación
        $nivel_final = '';
        if ($this->contador_preguntas <= 2) {
            $nivel_final = 'basico'; // Usuarios nuevos
        } elseif ($this->contador_preguntas <= 5) {
            $nivel_final = 'intermedio';
        } else {
            $nivel_final = 'avanzado'; // Usuarios experimentados
        }
        
        $this->debug_log("Nivel detectado: $nivel_final (contador: {$this->contador_preguntas})");
        return $nivel_final;
    }
    
    private function formatearRespuesta($seccion, $data, $mensaje_original, $nivel) {
        $this->debug_log("Formateando respuesta nivel: $nivel, sección: $seccion");
        
        // Respuestas adaptadas por nivel
        switch ($nivel) {
            case 'basico':
                $this->debug_log("Generando respuesta básica");
                return $this->respuestaBasica($seccion, $data);
            case 'intermedio':
                $this->debug_log("Generando respuesta intermedia");
                return $this->respuestaIntermedia($seccion, $data, $mensaje_original);
            case 'avanzado':
                $this->debug_log("Generando respuesta avanzada");
                return $this->respuestaAvanzada($seccion, $data, $mensaje_original);
            default:
                return $this->respuestaIntermedia($seccion, $data, $mensaje_original);
        }
    }
    
    private function respuestaBasica($seccion, $data) {
        $this->debug_log("Ejecutando respuestaBasica para sección: $seccion");
        switch ($seccion) {
            case 'definicion':
                return "🔍 **¿Qué es la sordera?**\n\n" .
                       "La sordera es cuando una persona no puede escuchar bien o nada. " .
                       "Afecta a millones de personas en el mundo.\n\n" .
                       "**Tipos principales:**\n" .
                       "• **Leve:** Escucha poco\n" .
                       "• **Moderada:** Necesita audífonos\n" .
                       "• **Severa:** Usa señas o implantes\n" .
                       "• **Profunda:** Comunidad sorda\n\n" .
                       "💡 *¿Quieres saber más detalles?*";
            
            case 'lengua_señas_colombiana':
                return "🤟 **Lengua de Señas Colombiana (LSC)**\n\n" .
                       "Es el idioma oficial de las personas sordas en Colombia. " .
                       "Se habla con las manos, expresiones faciales y movimientos del cuerpo.\n\n" .
                       "**Datos clave:**\n" .
                       "• 450,000 personas la usan\n" .
                       "• Es un idioma completo como el español\n" .
                       "• Se puede aprender en cursos\n" .
                       "• Tiene gramática propia\n\n" .
                       "💡 *¿Te interesa aprender LSC?*";
            
            case 'tecnologias_apoyo':
                return "🔧 **Tecnologías que ayudan**\n\n" .
                       "**Audífonos:** Amplifican el sonido\n" .
                       "**Implantes cocleares:** Cirugía para escuchar\n" .
                       "**Apps móviles:** Traducen voz a texto\n" .
                       "**Alertas visuales:** Luces en vez de sonidos\n\n" .
                       "💰 Costos van desde $800,000 hasta $8,000,000 COP\n\n" .
                       "💡 *¿Quieres saber sobre alguna tecnología específica?*";
            
            default:
                return "📚 Información básica sobre " . $this->nombreAmigableTema($seccion) . 
                       " disponible. ¿Quieres que te explique con más detalle?";
        }
    }
    
    private function respuestaIntermedia($seccion, $data, $mensaje_original) {
        // Usar las respuestas existentes (que ya son de nivel intermedio)
        return $this->formatearRespuestaOriginal($seccion, $data, $mensaje_original);
    }
    
    private function respuestaAvanzada($seccion, $data, $mensaje_original) {
        switch ($seccion) {
            case 'definicion':
                return "🔬 **Sordera: Análisis Técnico Completo**\n\n" .
                       "**Definición audiológica:** La hipoacusia o sordera se define como la pérdida de la función auditiva en grados variables, medida a través de umbrales auditivos en decibelios de nivel de audición (dB HL).\n\n" .
                       "**Clasificación etiológica:**\n" .
                       "• **Conductiva:** Alteración en oído externo/medio (cerumen, otosclerosis, malformaciones)\n" .
                       "• **Neurosensorial:** Daño coclear o retrococlear (presbiacusia, ototoxicidad, neuropatía)\n" .
                       "• **Mixta:** Combinación de ambas\n\n" .
                       "**Epidemiología (datos OMS 2024):**\n" .
                       "• Prevalencia global: 5.5% (430M personas)\n" .
                       "• Pérdida incapacitante: 1.5% (115M)\n" .
                       "• Proyección 2050: 900M afectados\n" .
                       "• Carga de enfermedad: 25M AVAD\n\n" .
                       "**Factores de riesgo principales:**\n" .
                       "• Genéticos: >400 genes identificados (GJB2, SLC26A4, MT-RNR1)\n" .
                       "• Ambientales: Ototoxicidad, traumatismo acústico, infecciones\n" .
                       "• Congénitos: TORCH, hiperbilirrubinemia, prematuridad\n\n" .
                       "**Avances recientes:** Terapia génica con vectores AAV, organoides cocleares, optogenética\n\n" .
                       "¿Deseas profundizar en aspectos específicos como fisiopatología, genética molecular o nuevas terapias?";
            
            case 'tecnologias_apoyo':
                return "⚡ **Tecnologías Asistivas: Estado del Arte**\n\n" .
                       "**Audífonos digitales avanzados:**\n" .
                       "• **Procesamiento:** DSP con algoritmos IA para separación de fuentes\n" .
                       "• **Conectividad:** Bluetooth 5.0, streaming directo, IoT integration\n" .
                       "• **Adaptabilidad:** Machine learning para preferencias del usuario\n" .
                       "• **Batería:** Li-ion recargables, 24-30h autonomía\n\n" .
                       "**Implantes cocleares (IC) modernos:**\n" .
                       "• **Electrodos:** Matrices de 12-22 contactos, estimulación bipolar/monopolar\n" .
                       "• **Procesadores:** Estrategias CIS, ACE, FSP con >8000 Hz bandwidth\n" .
                       "• **Compatibilidad:** MRI 3T safe, wireless programming\n" .
                       "• **Outcomes:** 80-90% comprensión en silencio, 60-70% en ruido\n\n" .
                       "**Desarrollos emergentes:**\n" .
                       "• **Implantes totalmente implantables:** Envoy Medical Esteem\n" .
                       "• **Interfaces cerebro-computadora:** Neuroprótesis auditivas\n" .
                       "• **Realidad aumentada:** Subtítulos en tiempo real (Microsoft HoloLens)\n" .
                       "• **Apps con IA:** Real-time transcription, sound recognition\n\n" .
                       "**Investigación actual Colombia:**\n" .
                       "• UN: Prótesis auditivas de bajo costo\n" .
                       "• Javeriana: Interfaces adaptativas\n" .
                       "• ANDI: Desarrollo de dispositivos nacionales\n\n" .
                       "¿Te interesa algún aspecto técnico específico o desarrollo en investigación?";
            
            default:
                $this->debug_log("Sección no encontrada en respuestaBasica: $seccion");
                return "🤖 No estoy seguro de entender tu pregunta. Puedo ayudarte con información sobre: causas de sordera, LSC, cultura sorda, tecnologías de apoyo, educación inclusiva y más. ¿Podrías ser más específico?";
        }
    }
    
    private function formatearRespuestaOriginal($seccion, $data, $mensaje_original) {
        switch ($seccion) {
            case 'definicion':
                return "🔍 **¿Qué es la sordera?**\n\n" . 
                       $data['descripcion'] . "\n\n" .
                       "**Tipos principales:**\n" .
                       "• " . implode("\n• ", array_column($data['tipos'], 'tipo')) . "\n\n" .
                       "¿Te gustaría saber más sobre algún tipo específico?";
            
            case 'causas_principales':
                $this->debug_log("Generando respuesta para causas_principales");
                return "📊 **Principales causas de sordera:**\n\n" .
                       "**Congénitas (desde nacimiento):**\n" .
                       "• Genética: 50-60% de los casos\n" .
                       "• Infecciones maternas: 15-20%\n" .
                       "• Complicaciones perinatales: 10-15%\n\n" .
                       "**Adquiridas (desarrolladas después):**\n" .
                       "• Exposición a ruido intenso\n" .
                       "• Infecciones (meningitis, otitis crónica)\n" .
                       "• Medicamentos ototóxicos\n" .
                       "• Traumatismos\n" .
                       "• Envejecimiento\n\n" .
                       "¿Quieres información específica sobre alguna causa?";
            
            case 'lengua_señas_colombiana':
                return "🤟 **Lengua de Señas Colombiana (LSC)**\n\n" .
                       "• **Reconocida oficialmente** por las leyes 324/1996 y 982/2005\n" .
                       "• **Usuarios:** Aproximadamente 450,000 personas en Colombia\n" .
                       "• **Características:** Lengua visual-espacial completa con gramática propia\n\n" .
                       "**Componentes de las señas:**\n" .
                       "• Configuración de mano\n" .
                       "• Ubicación en el cuerpo\n" .
                       "• Movimiento\n" .
                       "• Orientación de palmas\n" .
                       "• Expresión facial\n\n" .
                       "¿Te interesa aprender más sobre algún aspecto específico de la LSC?";
            
            case 'cultura_sorda':
                return "👥 **Cultura Sorda**\n\n" .
                       $data['definicion'] . "\n\n" .
                       "**Valores principales:**\n" .
                       "• Comunidad y apoyo mutuo\n" .
                       "• Orgullo por la lengua de señas\n" .
                       "• La sordera como diferencia cultural (no discapacidad)\n" .
                       "• Preferencia por comunicación visual\n" .
                       "• Importancia de la educación bilingüe\n\n" .
                       "La comunidad sorda tiene una rica tradición cultural. ¿Quieres saber más?";
            
            case 'tecnologias_apoyo':
                return "🔧 **Tecnologías de Apoyo**\n\n" .
                       "**Audífonos:** Amplifican el sonido (pérdida leve a severa)\n" .
                       "**Implantes cocleares:** Estimulan directamente el nervio auditivo (pérdida severa-profunda)\n" .
                       "**Sistemas FM:** Transmiten sonido directo (ideal para aulas)\n" .
                       "**Apps móviles:** Traductores voz-texto, videollamadas, alertas visuales\n\n" .
                       "Cada tecnología es útil según el grado de pérdida auditiva. ¿Necesitas información específica?";
            
            case 'mitos_realidades':
                return "💡 **Mitos y Realidades sobre la Sordera**\n\n" .
                       "**MITO:** Las personas sordas no pueden conducir\n" .
                       "**REALIDAD:** Son conductores muy seguros gracias a su aguda percepción visual\n\n" .
                       "**MITO:** Todas las personas sordas leen labios\n" .
                       "**REALIDAD:** Solo 30-40% del español es visible en labios\n\n" .
                       "**MITO:** La lengua de señas es universal\n" .
                       "**REALIDAD:** Cada país tiene su propia lengua de señas\n\n" .
                       "¿Hay algún otro mito que hayas escuchado?";
            
            case 'como_comunicarse':
                return "💬 **Cómo comunicarse con personas sordas**\n\n" .
                       "**SÍ hacer:**\n" .
                       "✅ Establecer contacto visual\n" .
                       "✅ Hablar de frente\n" .
                       "✅ Usar gestos naturales\n" .
                       "✅ Ser paciente y respetuoso\n" .
                       "✅ Preguntar su método preferido\n\n" .
                       "**NO hacer:**\n" .
                       "❌ Gritar (no ayuda)\n" .
                       "❌ Cubrir la boca al hablar\n" .
                       "❌ Dar la espalda\n" .
                       "❌ Asumir que leen labios\n\n" .
                       "La clave es el respeto y la paciencia. ¿Tienes alguna situación específica en mente?";
            
            case 'prevencion_salud':
                return "🛡️ **Prevención y Salud Auditiva**\n\n" .
                       "**🤰 Durante el embarazo:**\n" .
                       "• Vacunación contra rubéola, CMV, toxoplasmosis\n" .
                       "• Control prenatal regular\n" .
                       "• Evitar medicamentos ototóxicos\n" .
                       "• Nutrición con ácido fólico\n\n" .
                       "**👶 En la infancia:**\n" .
                       "• Tamizaje auditivo neonatal universal\n" .
                       "• Vacunación completa (especialmente meningitis)\n" .
                       "• Protección contra traumatismos\n" .
                       "• Detección temprana de otitis\n\n" .
                       "**👥 En adultos:**\n" .
                       "• Protección auditiva en ambientes ruidosos (>85 dB)\n" .
                       "• Límites de exposición a música alta\n" .
                       "• Uso responsable de auriculares (regla 60-60: 60% volumen, 60 minutos máximo)\n" .
                       "• Chequeos auditivos regulares\n\n" .
                       "**⚠️ Señales de alerta:**\n" .
                       "• Dificultad para entender conversaciones\n" .
                       "• Necesidad de subir volumen TV/radio\n" .
                       "• Zumbido persistente en oídos (tinnitus)\n" .
                       "• Sensación de oído tapado\n\n" .
                       "¿Quieres información específica sobre algún aspecto de la prevención?";
            
            case 'investigacion_avances':
                return "🔬 **Avances e Investigación en Audiología**\n\n" .
                       "**🧬 Terapias emergentes:**\n" .
                       "• **Terapia génica:** Introducción de genes para regenerar células ciliadas\n" .
                       "• **Células madre:** Regeneración de estructuras auditivas\n" .
                       "• **Farmacología regenerativa:** Medicamentos que estimulan regeneración natural\n\n" .
                       "**🤖 Tecnología avanzada:**\n" .
                       "• **Inteligencia Artificial:** Procesamiento mejorado en audífonos e implantes\n" .
                       "• **Realidad Aumentada:** Subtítulos en tiempo real con gafas inteligentes\n" .
                       "• **IoT:** Dispositivos conectados para mejor accesibilidad\n" .
                       "• **Blockchain:** Historiales médicos seguros y compartidos\n\n" .
                       "**🇨🇴 Investigación en Colombia:**\n" .
                       "• Universidad Nacional: Estudios en genética de sordera\n" .
                       "• Universidad Javeriana: Desarrollo de tecnologías asistivas\n" .
                       "• INSOR: Investigación en LSC y educación bilingüe\n\n" .
                       "**📅 Perspectivas futuras:**\n" .
                       "• Terapias regenerativas: 5-10 años para aplicaciones clínicas\n" .
                       "• Implantes más avanzados: 2-3 años\n" .
                       "• Tratamientos genéticos: En ensayos clínicos\n\n" .
                       "¿Te interesa alguna línea específica de investigación?";
                       
            case 'datos_estadisticos':
                return "📊 **Estadísticas sobre Sordera**\n\n" .
                       "**🌍 Datos mundiales (OMS 2024):**\n" .
                       "• **2.5 mil millones** de personas tendrán pérdida auditiva en 2050\n" .
                       "• **630 millones** actualmente tienen pérdida auditiva\n" .
                       "• **430 millones** requieren servicios de rehabilitación\n" .
                       "• **34 millones** de niños tienen pérdida auditiva\n\n" .
                       "**🇨🇴 Colombia:**\n" .
                       "• **1.2 millones** de personas con limitación auditiva\n" .
                       "• **450,000** usuarios de LSC\n" .
                       "• **2.4%** de la población total\n" .
                       "• **60%** en áreas urbanas, **40%** rurales\n\n" .
                       "**📈 Distribución por grados:**\n" .
                       "• Leve: 35% • Moderada: 30% • Severa: 20% • Profunda: 15%\n\n" .
                       "**🎓 Educación:**\n" .
                       "• Solo **15%** de niños sordos accede a educación bilingüe\n" .
                       "• **120+** instituciones con programas especializados\n" .
                       "• **800+** intérpretes de LSC certificados\n\n" .
                       "**💼 Empleo:**\n" .
                       "• **40%** de tasa de empleo en población sorda\n" .
                       "• **25%** subempleo\n" .
                       "• Sectores principales: tecnología, arte, educación\n\n" .
                       "¿Necesitas estadísticas específicas de alguna región o aspecto?";

            case 'grados_perdida':
                return "📏 **Grados de Pérdida Auditiva**\n\n" .
                       "La pérdida auditiva se mide en **decibelios (dB HL)** y se clasifica según el umbral auditivo:\n\n" .
                       "**🟢 Audición Normal (0-20 dB)**\n" .
                       "• Sin dificultades significativas\n" .
                       "• Escucha susurros y sonidos suaves\n" .
                       "• No requiere apoyo\n\n" .
                       "**🟡 Pérdida Leve (21-40 dB)**\n" .
                       "• Dificultad con sonidos suaves\n" .
                       "• Problemas en ambientes ruidosos\n" .
                       "• Puede afectar desarrollo del habla en niños\n" .
                       "• **Apoyo:** Audífonos, sistemas FM\n\n" .
                       "**🟠 Pérdida Moderada (41-70 dB)**\n" .
                       "• Dificultad para conversaciones normales\n" .
                       "• Necesita que hablen más fuerte\n" .
                       "• Impacto significativo en comunicación\n" .
                       "• **Apoyo:** Audífonos obligatorios, terapia de habla\n\n" .
                       "**🔴 Pérdida Severa (71-90 dB)**\n" .
                       "• Solo escucha sonidos muy fuertes\n" .
                       "• Conversación normal inaudible\n" .
                       "• Dependencia visual para comunicación\n" .
                       "• **Apoyo:** Audífonos potentes, implantes, LSC\n\n" .
                       "**⚫ Pérdida Profunda (91+ dB)**\n" .
                       "• No escucha sonidos del habla\n" .
                       "• Puede percibir vibraciones intensas\n" .
                       "• Comunicación principalmente visual\n" .
                       "• **Apoyo:** Implantes cocleares, LSC, cultura sorda\n\n" .
                       "¿Necesitas información sobre algún grado específico o evaluaciones audiológicas?";
            
            default:
                return $this->generarRespuestaGenerica($data);
        }
    }
    
    private function generarRespuestaGenerica($data) {
        return "📚 Encontré información relevante sobre tu consulta. " .
               "Te recomiendo usar el sistema completo para obtener todos los detalles. " .
               "¿Hay algo específico que te gustaría saber?";
    }
    
    private function buscarEnContenido($mensaje) {
        $this->debug_log("Búsqueda semántica para: $mensaje");
        
        // Búsqueda por palabras clave parciales
        $mensaje_limpio = $this->limpiarTexto($mensaje);
        $palabras_mensaje = explode(' ', $mensaje_limpio);
        $coincidencias = [];
        
        // Buscar coincidencias parciales en todas las secciones
        foreach ($this->palabras_clave as $seccion => $palabras_seccion) {
            $score = 0;
            foreach ($palabras_mensaje as $palabra_usuario) {
                if (strlen($palabra_usuario) < 3) continue; // Ignorar palabras muy cortas
                
                foreach ($palabras_seccion as $palabra_clave) {
                    // Coincidencia exacta
                    if (strpos($palabra_clave, $palabra_usuario) !== false) {
                        $score += 3;
                    }
                    // Coincidencia parcial (similar)
                    if ($this->similitudTexto($palabra_usuario, $palabra_clave) > 0.7) {
                        $score += 2;
                    }
                    // Coincidencia por raíz de palabra
                    if ($this->mismaRaiz($palabra_usuario, $palabra_clave)) {
                        $score += 1;
                    }
                }
            }
            
            if ($score > 0) {
                $coincidencias[$seccion] = $score;
            }
        }
        
        // Buscar en contenido de la API si no hay coincidencias directas
        if (empty($coincidencias)) {
            $coincidencias = $this->buscarEnAPI($mensaje);
        }
        
        if (!empty($coincidencias)) {
            // Ordenar por mayor puntuación
            arsort($coincidencias);
            $mejor_seccion = array_key_first($coincidencias);
            
            $this->debug_log("Mejor coincidencia: $mejor_seccion (score: {$coincidencias[$mejor_seccion]})");
            
            // Si la coincidencia es buena, obtener información
            if ($coincidencias[$mejor_seccion] >= 2) {
                return $this->obtenerInformacion($mejor_seccion, $mensaje);
            }
        }
        
        // Búsqueda por conceptos relacionados
        return $this->buscarConceptosRelacionados($mensaje);
    }
    
    private function limpiarTexto($texto) {
        // Convertir a minúsculas y eliminar acentos
        $texto = strtolower($texto);
        $texto = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $texto);
        // Eliminar signos de puntuación excepto espacios
        $texto = preg_replace('/[^\w\s]/', '', $texto);
        // Eliminar palabras vacías comunes
        $palabras_vacias = ['el', 'la', 'de', 'que', 'y', 'a', 'en', 'un', 'es', 'se', 'no', 'te', 'lo', 'le', 'da', 'su', 'por', 'son', 'con', 'para', 'como', 'las', 'del', 'los'];
        $palabras = explode(' ', $texto);
        $palabras_filtradas = array_filter($palabras, function($palabra) use ($palabras_vacias) {
            return !in_array($palabra, $palabras_vacias) && strlen($palabra) > 2;
        });
        return implode(' ', $palabras_filtradas);
    }
    
    private function similitudTexto($texto1, $texto2) {
        // Calcular similitud usando Levenshtein
        $len1 = strlen($texto1);
        $len2 = strlen($texto2);
        if ($len1 == 0 || $len2 == 0) return 0;
        
        $distancia = levenshtein($texto1, $texto2);
        $max_len = max($len1, $len2);
        return 1 - ($distancia / $max_len);
    }
    
    private function mismaRaiz($palabra1, $palabra2) {
        // Verificar si comparten raíz común (4+ caracteres)
        if (strlen($palabra1) < 4 || strlen($palabra2) < 4) return false;
        
        $raiz1 = substr($palabra1, 0, 4);
        $raiz2 = substr($palabra2, 0, 4);
        
        return $raiz1 === $raiz2;
    }
    
    private function buscarEnAPI($mensaje) {
        try {
            // Simular búsqueda en la API con términos del mensaje
            $palabras = explode(' ', $this->limpiarTexto($mensaje));
            $coincidencias = [];
            
            // Buscar cada palabra en las secciones de la API
            foreach ($palabras as $palabra) {
                if (strlen($palabra) > 3) {
                    // Aquí podrías hacer una búsqueda real en la API
                    // Por ahora, simularemos algunos matches
                    if (strpos($palabra, 'tecno') !== false || strpos($palabra, 'dispositiv') !== false) {
                        $coincidencias['tecnologias_apoyo'] = 2;
                    }
                    if (strpos($palabra, 'educ') !== false || strpos($palabra, 'aprend') !== false) {
                        $coincidencias['inclusion_educativa'] = 2;
                    }
                    if (strpos($palabra, 'invest') !== false || strpos($palabra, 'avance') !== false) {
                        $coincidencias['investigacion_avances'] = 2;
                    }
                }
            }
            
            return $coincidencias;
        } catch (Exception $e) {
            $this->debug_log("Error en búsqueda API: " . $e->getMessage());
            return [];
        }
    }
    
    private function buscarConceptosRelacionados($mensaje) {
        // Conceptos relacionados por contexto
        $conceptos_relacionados = [
            'familia' => 'como_comunicarse',
            'trabajo' => 'inclusion_educativa',
            'niños' => 'inclusion_educativa',
            'bebé' => 'prevencion_salud',
            'embarazo' => 'prevencion_salud',
            'hospital' => 'tecnologias_apoyo',
            'médico' => 'tecnologias_apoyo',
            'escuela' => 'inclusion_educativa',
            'universidad' => 'inclusion_educativa',
            'música' => 'prevencion_salud',
            'ruido' => 'prevencion_salud',
            'futuro' => 'investigacion_avances',
            'nuevo' => 'investigacion_avances'
        ];
        
        $mensaje_lower = strtolower($mensaje);
        foreach ($conceptos_relacionados as $concepto => $seccion) {
            if (strpos($mensaje_lower, $concepto) !== false) {
                $this->debug_log("Concepto relacionado encontrado: $concepto -> $seccion");
                return $this->obtenerInformacion($seccion, $mensaje) . 
                       "\n\n💡 *Si buscabas información específica sobre otro tema, puedes preguntarme directamente.*";
            }
        }
        
        // Si no encuentra nada, devolver sugerencias inteligentes
        return $this->generarSugerenciasInteligentes($mensaje);
    }
    
    private function generarSugerenciasInteligentes($mensaje) {
        $sugerencias_base = [
            "🤖 No encontré información específica para '$mensaje', pero puedo ayudarte con:\n\n",
            "📚 **Temas principales:**\n",
            "• **Definición y tipos de sordera** - ¿Qué es la sordera? ¿Cuáles son sus tipos?\n",
            "• **Causas de la sordera** - ¿Por qué ocurre? ¿Se puede prevenir?\n",
            "• **Lengua de Señas Colombiana (LSC)** - ¿Cómo funciona? ¿Dónde aprenderla?\n",
            "• **Cultura de la comunidad sorda** - Valores, tradiciones y organización\n",
            "• **Tecnologías de apoyo** - Audífonos, implantes, apps móviles\n",
            "• **Educación inclusiva** - Métodos, estrategias y derechos\n",
            "• **Mitos y realidades** - Derribando estereotipos\n",
            "• **Comunicación efectiva** - Cómo interactuar respetuosamente\n\n",
            "💬 **Ejemplos de preguntas:**\n",
            "• \"¿Cuáles son las causas de la sordera?\"\n",
            "• \"¿Cómo aprender lengua de señas?\"\n",
            "• \"¿Qué tecnologías ayudan a las personas sordas?\"\n",
            "• \"¿Cómo comunicarme con una persona sorda?\"\n\n",
            "¡Pregúntame sobre cualquiera de estos temas! 🙂"
        ];
    }
        
    private function buscarEnPreguntasFrecuentes($mensaje) {
        $this->debug_log("Buscando en preguntas frecuentes: $mensaje");
        
        $mensaje_limpio = $this->limpiarTexto($mensaje);
        $mejor_coincidencia = null;
        $mejor_score = 0;
        
        foreach ($this->preguntas_frecuentes as $pregunta => $datos) {
            $score = 0;
            
            // Coincidencia directa con la pregunta
            if (strpos($mensaje_limpio, $pregunta) !== false || strpos($pregunta, $mensaje_limpio) !== false) {
                $score += 10;
            }
            
            // Coincidencia con tags
            foreach ($datos['tags'] as $tag) {
                if (strpos($mensaje_limpio, $tag) !== false) {
                    $score += 5;
                }
                
                // Similitud con tags
                if ($this->similitudTexto($mensaje_limpio, $tag) > 0.8) {
                    $score += 3;
                }
            }
            
            // Palabras clave en común
            $palabras_pregunta = explode(' ', $pregunta);
            $palabras_mensaje = explode(' ', $mensaje_limpio);
            
            foreach ($palabras_mensaje as $palabra_msg) {
                if (strlen($palabra_msg) > 3) {
                    foreach ($palabras_pregunta as $palabra_preg) {
                        if (strpos($palabra_preg, $palabra_msg) !== false) {
                            $score += 2;
                        }
                    }
                }
            }
            
            if ($score > $mejor_score) {
                $mejor_score = $score;
                $mejor_coincidencia = $datos;
            }
        }
        
        if ($mejor_score >= 5) {
            $this->debug_log("FAQ encontrada con score: $mejor_score");
            return $mejor_coincidencia['respuesta'] . $this->agregarSugerenciasRelacionadas();
        }
        
        return null;
    }
    
    private function agregarSugerenciasRelacionadas() {
        return "\n\n🔗 **Preguntas relacionadas:**\n" .
               "• ¿Cuánto cuesta un audífono?\n" .
               "• ¿Cómo aprender lengua de señas?\n" .
               "• ¿Qué es un implante coclear?\n" .
               "• ¿Los sordos pueden conducir?\n\n" .
               "💬 Pregúntame sobre cualquier aspecto de la sordera o LSC.";
    }
    
    private function obtenerRespuestaFallback($seccion) {
        $fallbacks = [
            'definicion' => 'La sordera es la pérdida total o parcial de la audición. Puede ser congénita o adquirida, y se clasifica en conductiva, neurosensorial o mixta.',
            'causas_principales' => 'Las causas principales incluyen factores genéticos (50-60%), infecciones, exposición a ruido, medicamentos ototóxicos y traumatismos.',
            'lengua_señas_colombiana' => 'La LSC es la lengua oficial de la comunidad sorda colombiana, reconocida por ley. Es una lengua visual-espacial completa con más de 450,000 usuarios.',
            'cultura_sorda' => 'La cultura sorda es una identidad cultural basada en la lengua de señas, valores comunitarios y una perspectiva visual del mundo.',
            'tecnologias_apoyo' => 'Incluyen audífonos, implantes cocleares, sistemas FM y aplicaciones móviles que facilitan la comunicación y accesibilidad.',
            'como_comunicarse' => 'Lo más importante es el contacto visual, hablar de frente, usar gestos naturales y ser paciente y respetuoso.'
        ];
        
        return $fallbacks[$seccion] ?? $this->respuestas_generales['no_entiendo'];
    }
    
    public function obtenerSugerencias() {
        return [
            "¿Qué es la sordera?",
            "¿Cuáles son las causas de la sordera?",
            "¿Qué es la LSC?",
            "¿Cómo comunicarse con personas sordas?",
            "¿Los sordos pueden conducir?",
            "¿Cuánto cuesta un audífono?",
            "¿Cómo aprender lengua de señas?",
            "¿Qué es un implante coclear?",
            "Mitos sobre la sordera",
            "Tecnologías de apoyo auditivo",
            "Cultura de la comunidad sorda",
            "Educación inclusiva para sordos",
            "Prevenir la pérdida auditiva",
            "Avances en investigación auditiva"
        ];
    }

    /**
     * Función de debug para logging
     */
    private function debug_log($mensaje) {
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[$timestamp] $mensaje\n";
        file_put_contents('chatbot_debug.log', $log_entry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Obtiene datos de una sección específica sin incluir headers HTTP
     */
    private function obtenerDatosSeccion($seccion) {
        // Datos básicos para las secciones más comunes
        $datos = [
            'causas_principales' => [
                'titulo' => 'Causas principales de la sordera',
                'descripcion' => 'Las causas de la sordera son diversas y pueden clasificarse en congénitas (presentes desde el nacimiento) y adquiridas (desarrolladas durante la vida).',
                'causas_principales' => [
                    'Genéticas (40%)',
                    'Infecciones durante el embarazo (rubéola, citomegalovirus)',
                    'Complicaciones durante el parto',
                    'Exposición a ruido intenso',
                    'Infecciones del oído (otitis media crónica)',
                    'Medicamentos ototóxicos',
                    'Envejecimiento (presbiacusia)',
                    'Traumatismos craneoencefálicos',
                    'Meningitis y encefalitis',
                    'Tumores del nervio auditivo'
                ]
            ],
            'definicion' => [
                'titulo' => '¿Qué es la sordera?',
                'descripcion' => 'La sordera es la pérdida total o parcial de la capacidad auditiva. Afecta aproximadamente al 5% de la población mundial según la OMS.',
                'tipos_principales' => [
                    'Conductiva - Problema en oído externo/medio',
                    'Neurosensorial - Daño en oído interno o nervio auditivo',
                    'Mixta - Combinación de ambas',
                    'Neuropatía auditiva - Problema en transmisión al cerebro'
                ]
            ],
            'cultura_sorda' => [
                'titulo' => 'Cultura de la comunidad sorda',
                'descripcion' => 'La cultura sorda es rica en tradiciones, valores y formas de comunicación únicas, centrada en la lengua de señas.',
                'elementos_culturales' => [
                    'Lengua de señas como lengua natural',
                    'Identidad visual y espacial',
                    'Valores de comunidad y solidaridad',
                    'Arte sordo (teatro, poesía visual)',
                    'Eventos y encuentros comunitarios',
                    'Organizaciones sordas (FENASCOL, INSOR)'
                ]
            ]
        ];
        
        return isset($datos[$seccion]) ? json_encode($datos[$seccion]) : json_encode(['error' => 'Sección no encontrada']);
    }
}

// Función para integrar con el chat existente
function procesarMensajeBot($mensaje, $usuario_id = null) {
    $chatbot = new ChatbotSordos();
    
    // Si el mensaje contiene ciertas palabras clave, activar el bot
    $palabras_activacion = ['sordera', 'sordo', 'sorda', 'lsc', 'señas', 'cultura sorda', 'audífono', 'implante'];
    $mensaje_lower = strtolower($mensaje);
    
    $activar_bot = false;
    foreach ($palabras_activacion as $palabra) {
        if (strpos($mensaje_lower, $palabra) !== false) {
            $activar_bot = true;
            break;
        }
    }
    
    // También activar si es una pregunta general
    if (strpos($mensaje_lower, '?') !== false || 
        strpos($mensaje_lower, 'qué') !== false ||
        strpos($mensaje_lower, 'cómo') !== false ||
        strpos($mensaje_lower, 'por qué') !== false) {
        $activar_bot = true;
    }
    
    if ($activar_bot) {
        $respuesta = $chatbot->procesarMensaje($mensaje, $usuario_id);
        return [
            'es_bot' => true,
            'respuesta' => $respuesta,
            'sugerencias' => $chatbot->obtenerSugerencias()
        ];
    }
    
    return null; // No es una consulta para el bot
}

// Si se llama directamente para pruebas
if (isset($_GET['test'])) {
    header('Content-Type: application/json');
    
    $chatbot = new ChatbotSordos();
    $mensaje = $_GET['mensaje'] ?? '¿Qué es la sordera?';
    
    $respuesta = $chatbot->procesarMensaje($mensaje);
    
    echo json_encode([
        'mensaje' => $mensaje,
        'respuesta' => $respuesta,
        'sugerencias' => $chatbot->obtenerSugerencias()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>

