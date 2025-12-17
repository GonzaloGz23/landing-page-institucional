<?php
// Deshabilitar caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Configuración de la página de capacitaciones
$page_title = 'Capacitaciones Disponibles';
$body_class = 'bg-capacitaciones';
$page_level = 'root';
$current_page = 'capacitaciones.php';
$page_css = ['pages/capacitaciones.min.css', 'components/card-capacitacion.min.css'];
$page_js = ['pages/capacitaciones.js'];

// Incluir header
include '../components/header.php';

// Cargar configuración de BD y controller
// Definir acceso seguro para archivos del backend
if (!defined('SECURE_ACCESS')) {
    define('SECURE_ACCESS', true);
}
require_once '../backend/config/BDConections.php';
require_once '../backend/controllers/TrainingController.php';

// Instanciar controller con ambas conexiones
$controller = new TrainingController(
    DatabaseManager::getConnection('courses'),
    DatabaseManager::getConnection('main')
);

// Obtener todas las capacitaciones (UNA SOLA CONSULTA)
$capacitaciones = $controller->getCapacitacionesDisponibles();


// Filtrar destacadas del mismo array (sin consulta adicional)
$destacadas = array_filter($capacitaciones, function ($curso) {
    return isset($curso['es_destacado']) && $curso['es_destacado'] == 1;
});

// Limitar destacadas a máximo 3
$destacadas = array_slice($destacadas, 0, 3);
?>

<main class="capacitaciones-main container-fluid py-4">

    <!-- SECCIÓN 1: Capacitaciones Destacadas -->
    <?php if (!empty($destacadas)): ?>
        <section class="capacitaciones-destacadas-section mb-4" id="seccion-destacadas">
            <div class="capacitaciones-destacadas-container container">
                <h2 class="capacitaciones-destacadas-title text-center mb-4 fw-bold">
                    Capacitaciones Destacadas
                </h2>

                <!-- Grid de cards destacadas centradas -->
                <div
                    class="capacitaciones-destacadas-grid row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 justify-content-center">
                    <?php foreach ($destacadas as $curso): ?>
                        <div class="capacitaciones-destacadas-col col d-flex justify-content-center">
                            <?php include '../components/card-capacitacion.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Título de Todas las Capacitaciones -->
    <div class="container text-center">
        <h3 class="capacitaciones-lista-title">Todas las Capacitaciones</h3>
    </div>

    <!-- SECCIÓN 2: Buscador -->
    <section class="capacitaciones-buscador-section mb-3">
        <div class="capacitaciones-buscador-container container">
            <div class="capacitaciones-buscador-card card">
                <div class="capacitaciones-buscador-card-body card-body">
                    <div class="capacitaciones-buscador-row row g-3 align-items-center">
                        <!-- Campo de búsqueda único -->
                        <div class="capacitaciones-buscador-input-col col">
                            <div class="capacitaciones-buscador-input-group input-group input-group-lg">
                                <span class="capacitaciones-buscador-icon input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="capacitaciones-buscador-input form-control form-control-lg"
                                    id="busqueda" placeholder="Buscar por nombre de curso, equipo o fecha..."
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <!-- Contador de resultados -->
                    <div class="capacitaciones-buscador-contador mt-3" id="contador-resultados" style="display: none;">
                        <small class="capacitaciones-buscador-contador-text text-muted">
                            <i class="bi bi-funnel"></i>
                            Se encontraron <strong class="capacitaciones-buscador-total"
                                id="total-resultados">0</strong> resultados
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN 3: Todas las Capacitaciones -->
    <section class="capacitaciones-lista-section mb-5">
        <div class="capacitaciones-lista-container container">
            <?php if (empty($capacitaciones)): ?>
                <div class="capacitaciones-lista-empty alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle fs-4"></i>
                    <p class="mb-0 mt-2">No hay capacitaciones disponibles en este momento.</p>
                </div>
            <?php else: ?>
                <div class="capacitaciones-lista-grid row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4"
                    id="grid-capacitaciones">
                    <?php foreach ($capacitaciones as $curso): ?>
                        <div class="capacitaciones-lista-item col capacitacion-item"
                            data-nombre="<?= strtolower(htmlspecialchars($curso['nombre'])) ?>"
                            data-equipo="<?= strtolower(htmlspecialchars($curso['equipo_nombre'] ?? '')) ?>"
                            data-fecha="<?= htmlspecialchars($curso['fecha_inicio_cursada'] ?? '') ?>">
                            <?php include '../components/card-capacitacion.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Mensaje cuando no hay resultados de búsqueda -->
                <div class="capacitaciones-lista-no-resultados alert alert-info text-center" role="alert"
                    id="sin-resultados" style="display: none;">
                    <i class="bi bi-info-circle fs-4"></i>
                    <p class="mb-0 mt-2">No se encontraron capacitaciones con el término de búsqueda.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>