<?php 
/**
 * Detalle de Capacitación
 * 
 * Muestra información completa de una capacitación específica
 * Recibe: id (capacitación) codificado en URL
 */

// Definir acceso seguro para archivos del backend
define('SECURE_ACCESS', true);

require_once __DIR__ . '/../backend/config/IdEncoder.php';
require_once __DIR__ . '/../backend/config/BDConections.php';
require_once __DIR__ . '/../backend/controllers/TrainingController.php';

// Recibir parámetro codificado (solo ID)
$id_encoded = $_GET['id'] ?? null;

// Validar que exista
if (!$id_encoded) {
    die('⚠️ Parámetro ID requerido.');
}

// Decodificar ID
$id = IdEncoder::decode($id_encoded);

// Validar decodificación exitosa
if ($id === null) {
    die('⚠️ URL inválida o manipulada.');
}

// Instanciar controller con las conexiones necesarias
$controller = new TrainingController(
    DatabaseManager::getConnection('courses'),
    DatabaseManager::getConnection('main')
);

// Obtener datos de la capacitación (incluye estado_id desde BD)
$capacitacion = $controller->getCapacitacionDetalle($id);

if (!$capacitacion) {
    die('⚠️ Capacitación no encontrada.');
}

// Configuración de la página para el header
$page_title = htmlspecialchars($capacitacion['nombre']) . ' - Detalle';
$body_class = 'bg-capacitaciones';
$page_level = 'inscripciones'; // Nivel de carpeta
$current_page = 'detalleCapacitacion.php';
$page_css = ['pages/detalleCapacitacion.min.css']; // CSS adicionales

// Incluir header
include __DIR__ . '/../components/header.php';
?>

<main class="container py-5 detalle-capacitacion">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-4">
                    <?php if ($capacitacion['esta_cerrado']): ?>(Cerrado) <?php endif; ?><?= htmlspecialchars($capacitacion['nombre'] ?? 'Sin nombre') ?>
                </h1>
                <?php if (!empty($capacitacion['slogan'])): ?>
                    <p class="lead text-muted"><?= htmlspecialchars($capacitacion['slogan']) ?></p>
                <?php else: ?>
                    <p class="lead text-muted">Sin descripción</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Información Básica -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-info-circle-fill"></i> Información General</h5>
                        <ul class="list-unstyled">
                            <li><strong> Nivel:</strong> <?= htmlspecialchars($capacitacion['nivel'] ?? 'Sin datos') ?></li>
                            <li><strong> Modalidad:</strong> <?= htmlspecialchars($capacitacion['tipo_modalidad'] ?? 'Sin datos') ?></li>
                            <li><strong> Lugar:</strong> <?= htmlspecialchars($capacitacion['lugar'] ?? 'Sin datos') ?></li>
                            <li><strong> Duración por clase:</strong> <?= !empty($capacitacion['duracion_clase_minutos']) ? $capacitacion['duracion_clase_minutos'] . ' minutos' : 'Sin datos' ?></li>
                            <li><strong> Total de encuentros:</strong> <?= $capacitacion['total_encuentros'] ?? 'Sin datos' ?></li>
                            <li><strong> Inicio:</strong> <?= !empty($capacitacion['fecha_inicio_cursada']) ? date('d/m/Y', strtotime($capacitacion['fecha_inicio_cursada'])) : 'Sin datos' ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-calendar3"></i> Cronograma</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Horario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($capacitacion['cronograma'])): ?>
                                        <?php foreach ($capacitacion['cronograma'] as $horario): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($horario['nombre_dia'] ?? 'Sin datos') ?></td>
                                            <td>
                                                <?php 
                                                if (!empty($horario['hora_inicio']) && !empty($horario['hora_fin'])) {
                                                    echo date('H:i', strtotime($horario['hora_inicio'])) . ' - ' . date('H:i', strtotime($horario['hora_fin']));
                                                } else {
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center">Sin cronograma disponible</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Objetivo -->
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-bullseye"></i> Objetivo</h5>
                        <p><?= !empty($capacitacion['objetivo']) ? nl2br(htmlspecialchars($capacitacion['objetivo'])) : 'Sin datos' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Qué Aprenderás -->
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-lightbulb-fill"></i> ¿Qué aprenderás?</h5>
                        <p><?= !empty($capacitacion['que_aprenderas']) ? nl2br(htmlspecialchars($capacitacion['que_aprenderas'])) : 'Sin datos' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programa de Módulos -->
        <?php if (!empty($capacitacion['modulos'])): ?>
        <div class="row mb-4">
            <div class="col">
                <h3><i class="bi bi-journal-bookmark-fill"></i> Programa del Curso</h3>
                <div class="list-group">
                    <?php foreach ($capacitacion['modulos'] as $index => $modulo): ?>
                    <div class="list-group-item">
                        <h5 class="mb-3">
                            <span class="badge bg-primary me-2">Tema <?= $index + 1 ?></span>
                            <?= nl2br(htmlspecialchars($modulo['descripcion'])) ?>
                        </h5>
                        
                        <?php if (!empty($modulo['submodulos'])): ?>
                        <div class="ms-4 mt-3">
                            <h6 class="text-white mb-2">Subtemas:</h6>
                            <ul class="list-unstyled">
                                <?php foreach ($modulo['submodulos'] as $subIndex => $subtema): ?>
                                <li class="mb-2 ps-3 border-start border-3 border-secondary">
                                    <span class="badge bg-secondary me-2"><?= $index + 1 ?>.<?= $subIndex + 1 ?></span>
                                    <?= nl2br(htmlspecialchars($subtema['descripcion'])) ?>
                                    
                                    <?php if (!empty($subtema['submodulos'])): ?>
                                    <ul class="list-unstyled ms-4 mt-2">
                                        <?php foreach ($subtema['submodulos'] as $subsubIndex => $subsubtema): ?>
                                        <li class="mb-2 ps-3 border-start border-2 border-info">
                                            <span class="badge bg-info me-2"><?= $index + 1 ?>.<?= $subIndex + 1 ?>.<?= $subsubIndex + 1 ?></span>
                                            <?= nl2br(htmlspecialchars($subsubtema['descripcion'])) ?>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Información Adicional -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-people-fill"></i> Destinatarios</h5>
                        <p><?= !empty($capacitacion['destinatarios']) ? nl2br(htmlspecialchars($capacitacion['destinatarios'])) : 'Sin datos' ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-check-circle-fill"></i> Requisitos</h5>
                        <p><?= !empty($capacitacion['requisitos']) ? nl2br(htmlspecialchars($capacitacion['requisitos'])) : 'Sin datos' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón Final -->
        <?php if (!$capacitacion['esta_cerrado']): ?>
        <div class="row">
            <div class="col text-center">
                <?php 
                    $id_inscripcion = IdEncoder::encode($id);
                ?>
                <a href="inscripcion.php?id=<?= $id_inscripcion ?>" 
                   class="btn btn-success btn-lg">
                    Inscribirse Ahora
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php
// Incluir footer
include __DIR__ . '/../components/footer.php';
?>
