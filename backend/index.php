<?php
/**
 * Archivo de Protección - Backend
 * Bloquea listado de directorios
 * 
 * Implementado: 3 de octubre de 2025
 * Propósito: Capa secundaria de seguridad
 * 
 * Este archivo se ejecuta si alguien intenta acceder a:
 * http://tudominio.com/backend/
 * 
 * Funciona como respaldo si .htaccess no está habilitado
 * o si la configuración de Apache no lo procesa.
 */

http_response_code(403);
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .error-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
        }
        h1 { 
            color: #dc3545; 
            margin-bottom: 20px;
            font-size: 2rem;
        }
        p { 
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .btn-home {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn-home:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="icon">🔒</div>
        <h1>403 - Acceso Denegado</h1>
        <p>No tiene permisos para acceder a este directorio.</p>
        <p><small>Si necesita acceso, contacte al administrador del sistema.</small></p>
        <a href="/" class="btn-home">Volver al inicio</a>
    </div>
</body>
</html>
