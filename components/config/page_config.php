<?php
/**
 * Configuración centralizada para las páginas
 * Define rutas y navegación según el nivel de carpeta
 * 
 * ARCHIVO PROTEGIDO - No accesible públicamente
 */

// Prevenir acceso directo
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

function getPageConfig($level = 'root') {
    $configs = [
        'root' => [
            'assets_path' => '../assets/',
            'home_path' => '',
            'nav_links' => [
                'index.php' => 'Inicio',
                'quienes-somos.php' => '¿Quiénes somos?',
                'contacto.php' => 'Contacto',
                // 'preguntas-frecuentes.php' => 'Preguntas frecuentes' // Temporalmente oculto
            ]
        ],
        'ce' => [
            'assets_path' => '../../assets/',
            'home_path' => '../',
            'nav_links' => [
                '../index.php' => 'Inicio',
                '../quienes-somos.php' => '¿Quiénes somos?',
                '../contacto.php' => 'Contacto',
                // '../preguntas-frecuentes.php' => 'Preguntas frecuentes' // Temporalmente oculto
            ]
        ],
        'cie' => [
            'assets_path' => '../../assets/',
            'home_path' => '../',
            'nav_links' => [
                '../index.php' => 'Inicio',
                '../quienes-somos.php' => '¿Quiénes somos?',
                '../contacto.php' => 'Contacto',
                // '../preguntas-frecuentes.php' => 'Preguntas frecuentes' // Temporalmente oculto
            ]
        ],
        'inscripciones' => [
            'assets_path' => '../assets/',
            'home_path' => '../pages/',
            'nav_links' => [
                '../pages/index.php' => 'Inicio',
                '../pages/capacitaciones.php' => 'Capacitaciones',
                '../pages/quienes-somos.php' => '¿Quiénes somos?',
                '../pages/contacto.php' => 'Contacto',
                '../pages/preguntas-frecuentes.php' => 'Preguntas frecuentes'
            ]
        ]
    ];
    
    return $configs[$level] ?? $configs['root'];
}

/**
 * Obtiene la configuración para una página específica
 */
function initPageConfig($page_level = 'root') {
    $config = getPageConfig($page_level);
    
    // Hacer variables globales para usar en componentes
    global $assets_path, $home_path, $nav_links;
    $assets_path = $config['assets_path'];
    $home_path = $config['home_path'];
    $nav_links = $config['nav_links'];
    
    return $config;
}
?>