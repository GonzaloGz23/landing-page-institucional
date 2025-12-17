<?php
/**
 * Componente: Card de Capacitación
 * 
 * Card reutilizable para mostrar información resumida de una capacitación.
 * Se usa tanto en el carrusel de destacadas como en el grid general.
 * 
 * Variables esperadas:
 * - $curso (array): Datos de la capacitación con las siguientes claves:
 *   - id (int): ID de la capacitación
 *   - estado_id (int): ID del estado de la capacitación
 *   - nombre (string): Nombre del curso
 *   - equipo_nombre (string): Nombre del equipo responsable
 *   - fecha_inicio_cursada (date): Fecha de inicio
 *   - ruta_imagen (string|null): Nombre del archivo de imagen (solo nombre, no ruta completa)
 *   - es_destacado (bool): Si la capacitación es destacada (opcional)
 */

// Definir acceso seguro para archivos del backend
if (!defined('SECURE_ACCESS')) {
    define('SECURE_ACCESS', true);
}

// Validar que exista la variable $curso
if (!isset($curso) || !is_array($curso)) {
    return;
}

// Preparar datos
$id = $curso['id'] ?? 0;
$estado_id = $curso['estado_id'] ?? 0;
$nombre = htmlspecialchars($curso['nombre'] ?? 'Sin nombre');
$equipo = htmlspecialchars($curso['equipo_nombre'] ?? 'Sin equipo');
$fecha = $curso['fecha_inicio_cursada'] ?? null;
$fecha_format = $curso['fecha_format'] ?? null;
$imagen = $curso['ruta_imagen'] ?? null;
$es_destacado = isset($curso['es_destacado']) && $curso['es_destacado'] == 1;
$esta_cerrado = $estado_id == 5;
$link = $curso['link'] ?? null;

// si existe o no el link de BD
if (empty($link)) {
    // Incluir codificador de IDs
    require_once __DIR__ . '/../backend/config/IdEncoder.php';
    $url_detalle = '../inscripciones/detalleCapacitacion.php?id=' . IdEncoder::encode($id);
} else {
    // Usar el link directo desde la BD
    $url_detalle = $link;
}


// Determinar la ruta base según desde dónde se llama el componente
// Si estamos en /pages/, la ruta es ../inscripciones/
// Si estamos en /components/, la ruta es ../inscripciones/
$ruta_base = '../inscripciones/detalleCapacitacion.php';

// Si $page_level está definido (viene del header), ajustar ruta
if (isset($page_level) && $page_level === 'root') {
    $ruta_base = '../inscripciones/detalleCapacitacion.php';
}



// Determinar ruta de imagen
$ruta_imagen = '../assets/img/common/capacitaciones/sin_imagen.webp'; // Imagen por defecto
if ($imagen && !empty($imagen)) {
    // La BD solo almacena el nombre del archivo (ej: imagen.webp)
    // Construir la ruta completa concatenando la ruta base con el nombre del archivo
    $image_path_rel = '../assets/img/capacitaciones/' . htmlspecialchars($imagen);

    // Verificar si existe el archivo para agregar versionado

    $fs_path = __DIR__ . '/../assets/img/capacitaciones/' . $imagen;

    if (file_exists($fs_path)) {
        $version = filemtime($fs_path);
        $ruta_imagen = $image_path_rel . '?v=' . $version;
    } else {
        $ruta_imagen = $image_path_rel;
    }
}
?>

<div class="card capacitacion-card h-100 shadow-sm">
    <!-- Badge de destacado -->
    <?php if ($es_destacado): ?>
        <div class="badge-destacado">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                <defs>
                    <linearGradient id="starGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#534b66;stop-opacity:1" />
                        <stop offset="25%" style="stop-color:#5b4567;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#673d65;stop-opacity:1" />
                        <stop offset="75%" style="stop-color:#73335e;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#7e2752;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path
                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
        </div>
    <?php endif; ?>

    <!-- Imagen del curso -->
    <img src="<?= $ruta_imagen ?>" class="card-img-top" alt="<?= $nombre ?>"
        onerror="this.src='../assets/img/common/capacitaciones/sin_imagen.webp'">

    <!-- Contenido de la card -->
    <div class="card-body d-flex flex-column">
        <!-- Nombre del curso -->
        <h5 class="card-title fw-bold" title="<?= $nombre ?>">
            <?php if ($esta_cerrado): ?>(Cerrado) <?php endif; ?><?= $nombre ?>
        </h5>

        <!-- Información adicional -->
        <div class="card-info mb-3 flex-grow-1">
            <!-- Equipo -->
            <p class="mb-2 d-flex align-items-center">
                <i class="bi bi-people-fill me-2"></i>
                <small class="fw-bold">Equipo:</small>
                <span class="ms-1 fw-semibold"><?= $equipo ?></span>
            </p>

            <!-- Fecha de inicio -->
            <p class="mb-0 d-flex align-items-center">
                <i class="bi bi-calendar-event-fill me-2"></i>
                <small class="fw-bold">Inicio:</small>
                <span class="ms-1 fw-semibold"><?= $fecha_format ?></span>
            </p>
        </div>

        <!-- Botón Ver más -->
        <a href="<?= $url_detalle ?>" class="btn btn-primary w-100 mt-auto">
            <i class="bi bi-eye"></i> Ver más
        </a>
    </div>
</div>