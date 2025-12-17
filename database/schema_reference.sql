-- ============================================================================
-- ESTRUCTURA DE BASE DE DATOS - REFERENCIA
-- ============================================================================
-- Este archivo muestra la estructura de las dos bases de datos utilizadas
-- en el proyecto. Es solo para REFERENCIA y documentación.
-- NO está diseñado para ser ejecutado directamente.
-- ============================================================================

-- ============================================================================
-- BASE DE DATOS 1: sistema_cursos
-- ============================================================================
-- Gestiona toda la información relacionada con capacitaciones

-- ----------------------------------------------------------------------------
-- Tabla: capacitaciones
-- Descripción: Almacena información principal de cada curso/capacitación
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `capacitaciones` (
  `id_capacitacion` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre del curso',
  `descripcion` TEXT COMMENT 'Descripción detallada del curso',
  `objetivo` TEXT COMMENT 'Objetivos de aprendizaje',
  `requisitos` TEXT COMMENT 'Requisitos previos para inscribirse',
  `duracion_horas` INT(11) COMMENT 'Duración total en horas',
  `cupo_maximo` INT(11) COMMENT 'Cantidad máxima de inscriptos',
  `cupo_actual` INT(11) DEFAULT 0 COMMENT 'Cantidad actual de inscriptos',
  `fecha_inicio_cursada` DATE COMMENT 'Fecha de inicio del curso',
  `fecha_fin_cursada` DATE COMMENT 'Fecha de finalización del curso',
  `fecha_inicio_inscripcion` DATE COMMENT 'Apertura de inscripciones',
  `fecha_fin_inscripcion` DATE COMMENT 'Cierre de inscripciones',
  `imagen_url` VARCHAR(255) COMMENT 'Ruta de la imagen del curso',
  `equipo_id` INT(11) COMMENT 'FK: Equipo responsable (de sistema_institucional)',
  `estado_id` INT(11) DEFAULT 1 COMMENT '1=Abierta, 2=Cerrada, 3=Finalizada',
  `es_destacado` TINYINT(1) DEFAULT 0 COMMENT '1=Mostrar en destacados',
  `esta_publicada` TINYINT(1) DEFAULT 1 COMMENT '1=Visible en el sitio',
  `modalidad` ENUM('presencial', 'virtual', 'hibrida') DEFAULT 'presencial',
  `lugar` VARCHAR(255) COMMENT 'Ubicación física del curso',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_capacitacion`),
  KEY `idx_estado` (`estado_id`),
  KEY `idx_publicada` (`esta_publicada`),
  KEY `idx_destacado` (`es_destacado`),
  KEY `idx_equipo` (`equipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Tabla: modulos
-- Descripción: Contenido temático de cada capacitación (estructura jerárquica)
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `modulos` (
  `id_modulo` INT(11) NOT NULL AUTO_INCREMENT,
  `capacitacion_id` INT(11) NOT NULL COMMENT 'FK: Capacitación a la que pertenece',
  `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre del módulo/tema',
  `descripcion` TEXT COMMENT 'Descripción del contenido',
  `orden` INT(11) DEFAULT 0 COMMENT 'Orden de presentación',
  `padre_id` INT(11) DEFAULT NULL COMMENT 'FK: Módulo padre (para submódulos)',
  `duracion_horas` INT(11) COMMENT 'Duración del módulo',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_modulo`),
  KEY `idx_capacitacion` (`capacitacion_id`),
  KEY `idx_padre` (`padre_id`),
  CONSTRAINT `fk_modulo_capacitacion` FOREIGN KEY (`capacitacion_id`) 
    REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE,
  CONSTRAINT `fk_modulo_padre` FOREIGN KEY (`padre_id`) 
    REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Tabla: cronograma
-- Descripción: Calendario de clases de cada capacitación
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cronograma` (
  `id_cronograma` INT(11) NOT NULL AUTO_INCREMENT,
  `capacitacion_id` INT(11) NOT NULL COMMENT 'FK: Capacitación',
  `fecha` DATE NOT NULL COMMENT 'Fecha de la clase',
  `hora_inicio` TIME COMMENT 'Hora de inicio',
  `hora_fin` TIME COMMENT 'Hora de finalización',
  `tema` VARCHAR(255) COMMENT 'Tema a tratar',
  `descripcion` TEXT COMMENT 'Descripción de la clase',
  `lugar` VARCHAR(255) COMMENT 'Ubicación de la clase',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cronograma`),
  KEY `idx_capacitacion` (`capacitacion_id`),
  KEY `idx_fecha` (`fecha`),
  CONSTRAINT `fk_cronograma_capacitacion` FOREIGN KEY (`capacitacion_id`) 
    REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Tabla: inscripciones
-- Descripción: Registro de personas inscriptas en capacitaciones
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `inscripciones` (
  `id_inscripcion` INT(11) NOT NULL AUTO_INCREMENT,
  `capacitacion_id` INT(11) NOT NULL COMMENT 'FK: Capacitación',
  `dni` VARCHAR(20) NOT NULL COMMENT 'DNI del inscripto',
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255),
  `telefono` VARCHAR(50),
  `fecha_nacimiento` DATE,
  `direccion` VARCHAR(255),
  `localidad` VARCHAR(100),
  `nivel_educativo` VARCHAR(100),
  `situacion_laboral` VARCHAR(100),
  `fecha_inscripcion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
  PRIMARY KEY (`id_inscripcion`),
  UNIQUE KEY `unique_inscripcion` (`capacitacion_id`, `dni`),
  KEY `idx_dni` (`dni`),
  KEY `idx_capacitacion` (`capacitacion_id`),
  CONSTRAINT `fk_inscripcion_capacitacion` FOREIGN KEY (`capacitacion_id`) 
    REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Tabla: estados
-- Descripción: Catálogo de estados de capacitaciones
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `estados` (
  `id_estado` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL COMMENT 'Nombre del estado',
  `descripcion` VARCHAR(255) COMMENT 'Descripción del estado',
  `color` VARCHAR(20) COMMENT 'Color para UI (hex o nombre)',
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de ejemplo para estados
-- INSERT INTO estados VALUES (1, 'Abierta', 'Inscripciones abiertas', '#28a745');
-- INSERT INTO estados VALUES (2, 'Cerrada', 'Inscripciones cerradas', '#ffc107');
-- INSERT INTO estados VALUES (3, 'Finalizada', 'Curso finalizado', '#6c757d');


-- ============================================================================
-- BASE DE DATOS 2: sistema_institucional
-- ============================================================================
-- Sistema principal de gestión institucional

-- ----------------------------------------------------------------------------
-- Tabla: equipos
-- Descripción: Equipos de trabajo del organismo
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre completo del equipo',
  `alias` VARCHAR(100) COMMENT 'Nombre corto para mostrar',
  `descripcion` TEXT COMMENT 'Descripción del equipo',
  `responsable` VARCHAR(255) COMMENT 'Nombre del responsable',
  `email` VARCHAR(255) COMMENT 'Email de contacto',
  `telefono` VARCHAR(50) COMMENT 'Teléfono de contacto',
  `estado` ENUM('habilitado', 'deshabilitado') DEFAULT 'habilitado',
  `borrado` TINYINT(1) DEFAULT 0 COMMENT 'Borrado lógico',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_equipo`),
  KEY `idx_estado` (`estado`),
  KEY `idx_borrado` (`borrado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ejemplos de equipos:
-- - CIE (Centro de Inserción al Empleo)
-- - CE (Centro de Emprendedores)
-- - Formación Profesional
-- - Oficios Formosa
-- - etc.

-- ----------------------------------------------------------------------------
-- Tabla: usuarios
-- Descripción: Personal administrativo del sistema
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL COMMENT 'Hash de contraseña',
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `equipo_id` INT(11) COMMENT 'FK: Equipo al que pertenece',
  `rol` ENUM('admin', 'coordinador', 'operador') DEFAULT 'operador',
  `activo` TINYINT(1) DEFAULT 1,
  `ultimo_acceso` TIMESTAMP NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  KEY `idx_equipo` (`equipo_id`),
  KEY `idx_activo` (`activo`),
  CONSTRAINT `fk_usuario_equipo` FOREIGN KEY (`equipo_id`) 
    REFERENCES `equipos` (`id_equipo`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Tabla: configuraciones
-- Descripción: Parámetros de configuración del sistema
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `configuraciones` (
  `id_config` INT(11) NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Identificador de configuración',
  `valor` TEXT COMMENT 'Valor de la configuración',
  `descripcion` VARCHAR(255) COMMENT 'Descripción del parámetro',
  `tipo` ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_config`),
  UNIQUE KEY `unique_clave` (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- RELACIONES CROSS-DATABASE
-- ============================================================================
-- 
-- IMPORTANTE: Estas relaciones NO se implementan con FOREIGN KEYS debido a
-- que están en bases de datos diferentes. La integridad referencial se
-- maneja a nivel de aplicación (PHP).
--
-- Relaciones:
-- - capacitaciones.equipo_id -> equipos.id_equipo
--   Una capacitación es gestionada por un equipo
--
-- ============================================================================

-- ============================================================================
-- NOTAS TÉCNICAS
-- ============================================================================
--
-- 1. CHARSET: utf8mb4_unicode_ci
--    - Soporte completo para caracteres especiales y emojis
--    - Collation case-insensitive para búsquedas
--
-- 2. TIMESTAMPS
--    - created_at: Fecha de creación (automática)
--    - updated_at: Fecha de última modificación (automática)
--
-- 3. ÍNDICES
--    - Índices en campos frecuentemente consultados
--    - Índices en foreign keys para mejorar JOINs
--
-- 4. BORRADO LÓGICO
--    - Algunas tablas usan campo 'borrado' en lugar de DELETE
--    - Permite mantener historial y auditoría
--
-- 5. ENUMS
--    - Valores predefinidos para campos con opciones limitadas
--    - Validación a nivel de base de datos
--
-- ============================================================================
