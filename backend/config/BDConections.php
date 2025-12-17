<?php
/**
 * Database Manager - Gestor de Conexiones a Base de Datos
 * 
 * ARCHIVO PROTEGIDO - No accesible públicamente
 * Contiene credenciales sensibles de bases de datos
 */

// Prevenir acceso directo
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

class DatabaseManager
{
    private static $connections = [];

    public static function getConnection($database = 'main')
    {
        if (!isset(self::$connections[$database])) {
            self::$connections[$database] = self::createConnection($database);
        }
        return self::$connections[$database];
    }

    private static function createConnection($database)
    {
        // PENDIENTE: Implementar carga de variables de entorno (ej: usando vlucas/phpdotenv)
        // Por ahora, usando valores por defecto para desarrollo local
        // En producción, estos deberían cargarse desde archivo .env

        $esLocal = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);

        switch ($database) {
            case 'main':
                // Configuración SIGE principal
                $config = [
                    'host' => 'localhost',
                    'dbname' => $esLocal ? 'sistema_institucional' : 'sistema_institucional_prod',
                    'user' => $esLocal ? 'root' : 'db_user',
                    'pass' => $esLocal ? '' : 'your_password_here'
                ];
                break;

            case 'courses':
                // Configuración base de datos de cursos
                $config = [
                    'host' => 'localhost',
                    'dbname' => $esLocal ? 'sistema_cursos' : 'sistema_cursos_prod',
                    'user' => $esLocal ? 'root' : 'db_user',
                    'pass' => $esLocal ? '' : 'your_password_here'
                ];
                break;

            default:
                throw new Exception("Base de datos no configurada: $database");
        }

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
            $pdo->exec("SET time_zone = '-03:00'");
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Error conectando a $database: " . $e->getMessage());
        }
    }
}
