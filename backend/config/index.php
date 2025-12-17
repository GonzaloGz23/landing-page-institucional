<?php
/**
 * Protección - Directorio de Configuración Backend
 * 
 * Implementado: 3 de octubre de 2025
 * Propósito: Bloquear acceso a configuraciones de base de datos
 * 
 * Archivos protegidos en esta carpeta:
 * - BDConections.php (credenciales de base de datos)
 */

http_response_code(403);
exit('Acceso denegado a archivos de configuración');
