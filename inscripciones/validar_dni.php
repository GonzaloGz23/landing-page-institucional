<?php
/**
 * Endpoint AJAX: Validar si DNI ya está inscrito
 * 
 * Verifica si un DNI ya está registrado en una capacitación específica
 * antes de permitir el envío del formulario.
 * 
 * Solo accesible vía POST AJAX
 */

// Definir acceso seguro
define('SECURE_ACCESS', true);

require_once __DIR__ . '/../backend/config/BDConections.php';
require_once __DIR__ . '/../backend/controllers/InscriptionController.php';

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    die(json_encode(['error' => 'Método no permitido']));
}

// Obtener datos
$dni = trim($_POST['dni'] ?? '');
$capacitacion_id = (int)($_POST['capacitacion_id'] ?? 0);

// Validar datos básicos
if (empty($dni) || $capacitacion_id === 0) {
    http_response_code(400);
    header('Content-Type: application/json');
    die(json_encode(['error' => 'Datos inválidos']));
}

// Validar formato DNI (7-8 dígitos)
if (!preg_match('/^[0-9]{7,8}$/', $dni)) {
    http_response_code(400);
    header('Content-Type: application/json');
    die(json_encode(['error' => 'DNI inválido']));
}

try {
    // Instanciar controller
    $controller = new InscriptionController(DatabaseManager::getConnection('courses'));
    
    // Verificar si ya está inscrito
    $yaInscrito = $controller->yaEstaInscrito($dni, $capacitacion_id);
    
    // Responder con JSON
    header('Content-Type: application/json');
    echo json_encode([
        'yaInscrito' => $yaInscrito,
        'mensaje' => $yaInscrito 
            ? 'El DNI ya está inscrito en esta capacitación.' 
            : 'DNI disponible para inscripción.'
    ]);
    
} catch (Exception $e) {
    // Log de error
    error_log("Error en validar_dni.php: " . $e->getMessage());
    
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error del servidor. Por favor intente nuevamente.']);
}
