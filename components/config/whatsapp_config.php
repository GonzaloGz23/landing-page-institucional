<?php
/**
 * Configuración centralizada para WhatsApp
 * 
 * Este archivo contiene toda la configuración necesaria para generar
 * enlaces de WhatsApp personalizados según el centro y programa.
 * 
 * @author Organismo Público
 * @version 1.1
 * @date 15 de octubre de 2025
 */

// Prevenir acceso directo
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

/**
 * Configuración principal de WhatsApp
 * 
 * Estructura:
 * - CE/CIE: Centros principales
 * - phone: Número de WhatsApp (formato internacional)
 * - name: Nombre completo del centro
 * - services: Array de prestaciones con sus mensajes personalizados
 */
$whatsapp_config = [
    'CE' => [
        'phone' => '+5490000000000',
        'name' => 'Centro de Apoyo',
        'description' => 'Centro para emprendedores y desarrollo de negocios',
        'services' => [
            // === PRESTACIONES CE ===
            'atencion' => 'Hola, necesito asesoramiento para mi emprendimiento.',
            'punto-emprendedor' => 'Hola, necesito que me brinden información sobre Punto Emprendedor. Quiero conocer los beneficios disponibles.',
            'laboratorio-emprendedor' => 'Hola, quiero que me den información sobre Laboratorio Emprendedor. Tengo una idea y quiero convertirla en un proyecto.',
            'agencia-marketing' => 'Hola, necesito que me proporcionen información sobre Agencia de Marketing. Necesito ayuda para promocionar mi emprendimiento.',
            'formacion-emprendedores' => 'Hola, me gustaría recibir información sobre Formación de Emprendedores. Me quiero capacitar para mejorar mi emprendimiento.',
            'capital-fortalecimiento' => 'Hola, quisiera que me brinden información sobre Capital de Fortalecimiento. Necesito recursos o créditos para emprendedores.',

            // === PROGRAMAS CE ===
            'desarrolladora-emprendedores' => 'Hola, necesito que me den información sobre Desarrolladora de Emprendedores. Quiero escalar mi emprendimiento con mentorías.',
            'renovacion-comercial' => 'Hola, me gustaría recibir información sobre Renovación Comercial. Quiero renovar o mejorar mi emprendimiento.',
            'mercado-comunitario' => 'Hola, quiero que me proporcionen información sobre Mercado Comunitario. Quiero participar del Mercado Comunitario de Emprendedores.',
            'conexion-comercial' => 'Hola, necesito que me brinden información sobre Conexión Comercial. Quiero vincularme con empresas como proveedor.'
        ]
    ],
    'CIE' => [
        'phone' => '+5490000000000',
        'name' => 'Centro de Servicios',
        'description' => 'Centro de capacitación e intermediación laboral',
        'services' => [
            // === PRESTACIONES CIE ===
            'admision' => 'Hola, necesito ayuda para armar o mejorar mi CV.',
            'mejora-continua' => 'Hola, quiero que me den información sobre Mejora Continua. Busco capacitaciones para mi equipo de trabajo.',
            'insercion-formacion' => 'Hola, me gustaría recibir información sobre Inserción a la Formación. Quiero capacitarme para conseguir empleo.',
            'insercion-oficios' => 'Hola, necesito que me proporcionen información sobre Inserción en Oficios. Quiero profesionalizar mis habilidades en mi oficio.',

            // === PROGRAMAS CIE ===
            'oficios-formosa' => 'Hola, quisiera que me brinden información sobre el portal de oficios. Quiero hacer una consulta sobre el directorio o la app.',
            'me-formo' => 'Hola, necesito que me den información sobre Me Formo. Estoy buscando mi primera experiencia laboral.'
        ]
    ]
];

/**
 * Función principal para generar enlaces de WhatsApp
 * 
 * @param string $center Centro (CE o CIE)
 * @param string $service Prestación específica
 * @return string|false URL de WhatsApp o false si hay error
 */
function generateWhatsAppLink($center, $service)
{
    global $whatsapp_config;

    // Validar parámetros
    if (!isValidCenter($center)) {
        error_log("WhatsApp Error: Centro inválido - $center");
        return false;
    }

    if (!isValidService($center, $service)) {
        error_log("WhatsApp Error: Prestación inválida - $center/$service");
        return false;
    }

    // Obtener configuración
    $config = $whatsapp_config[strtoupper($center)];
    $phone = $config['phone'];
    $message = $config['services'][$service];

    // Construir URL de WhatsApp
    $encoded_message = urlencode($message);
    $whatsapp_url = "https://wa.me/{$phone}?text={$encoded_message}";

    return $whatsapp_url;
}

/**
 * Obtener la configuración completa o de un centro específico
 * 
 * @param string|null $center Centro específico (opcional)
 * @return array|false Configuración o false si no existe
 */
function getWhatsAppConfig($center = null)
{
    global $whatsapp_config;

    if ($center === null) {
        return $whatsapp_config;
    }

    $center = strtoupper($center);
    return isset($whatsapp_config[$center]) ? $whatsapp_config[$center] : false;
}

/**
 * Validar si un centro es válido
 * 
 * @param string $center Centro a validar
 * @return bool True si es válido
 */
function isValidCenter($center)
{
    global $whatsapp_config;
    return isset($whatsapp_config[strtoupper($center)]);
}

/**
 * Validar si una prestación existe en un centro
 * 
 * @param string $center Centro
 * @param string $service Prestación
 * @return bool True si es válido
 */
function isValidService($center, $service)
{
    global $whatsapp_config;

    if (!isValidCenter($center)) {
        return false;
    }

    $center = strtoupper($center);
    return isset($whatsapp_config[$center]['services'][$service]);
}

/**
 * Obtener lista de prestaciones de un centro
 * 
 * @param string $center Centro
 * @return array|false Lista de prestaciones o false si no existe
 */
function getWhatsAppServices($center)
{
    $config = getWhatsAppConfig($center);
    return $config ? array_keys($config['services']) : false;
}

/**
 * Obtener el teléfono de un centro
 * 
 * @param string $center Centro
 * @return string|false Teléfono o false si no existe
 */
function getWhatsAppPhone($center)
{
    $config = getWhatsAppConfig($center);
    return $config ? $config['phone'] : false;
}

/**
 * Obtener el mensaje de una prestación específica
 * 
 * @param string $center Centro
 * @param string $service Prestación
 * @return string|false Mensaje o false si no existe
 */
function getWhatsAppMessage($center, $service)
{
    if (!isValidService($center, $service)) {
        return false;
    }

    $config = getWhatsAppConfig($center);
    return $config['services'][$service];
}

/**
 * Función auxiliar para debug - mostrar toda la configuración
 * 
 * @return void
 */
function debugWhatsAppConfig()
{
    if (defined('WP_DEBUG') || isset($_GET['debug_whatsapp'])) {
        global $whatsapp_config;
        echo '<pre>';
        print_r($whatsapp_config);
        echo '</pre>';
    }
}

/**
 * Función para validar formato de número de teléfono
 * 
 * @param string $phone Número a validar
 * @return bool True si es válido
 */
function isValidPhoneFormat($phone)
{
    // Formato esperado: +54 seguido de 10 dígitos
    return preg_match('/^\+54\d{10}$/', $phone);
}

/**
 * Generar enlace con target="_blank" y propiedades adicionales
 * 
 * @param string $center Centro
 * @param string $service Prestación
 * @param string $class Clases CSS adicionales
 * @param string $text Texto del enlace
 * @return string|false HTML del enlace o false si hay error
 */
function generateWhatsAppButton($center, $service, $class = 'btn btn-primary', $text = 'Contactar por WhatsApp')
{
    $url = generateWhatsAppLink($center, $service);

    if (!$url) {
        return false;
    }

    $html = '<a href="' . htmlspecialchars($url) . '" ';
    $html .= 'class="' . htmlspecialchars($class) . '" ';
    $html .= 'target="_blank" ';
    $html .= 'rel="noopener noreferrer" ';
    $html .= 'aria-label="Contactar por WhatsApp">';
    $html .= htmlspecialchars($text);
    $html .= '</a>';

    return $html;
}

// === CONFIGURACIÓN ADICIONAL ===

/**
 * Configuración global de WhatsApp
 */
$whatsapp_global_config = [
    'api_version' => '1.1',
    'created_date' => '2025-10-02',
    'last_updated' => date('Y-m-d'),
    'default_target' => '_blank',
    'enable_tracking' => false,  // Para futuras analíticas
    'enable_debug' => false      // Para modo debug
];

/**
 * Mensajes de error personalizados
 */
$whatsapp_error_messages = [
    'invalid_center' => 'Centro no válido. Use CE o CIE.',
    'invalid_service' => 'Prestación no encontrada en el centro especificado.',
    'invalid_phone' => 'Formato de teléfono inválido.',
    'config_not_found' => 'Configuración de WhatsApp no encontrada.',
    'general_error' => 'Error al generar enlace de WhatsApp.'
];

?>