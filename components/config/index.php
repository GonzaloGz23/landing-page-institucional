<?php
/**
 * Protección - Directorio de Configuración Components
 * 
 * Implementado: 3 de octubre de 2025
 * Propósito: Bloquear acceso a configuraciones del sistema
 * 
 * Archivos protegidos en esta carpeta:
 * - whatsapp_config.php (números de contacto, mensajes)
 * - page_config.php (configuración de navegación)
 */

http_response_code(403);
exit('Acceso denegado a archivos de configuración');
