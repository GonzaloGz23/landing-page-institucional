<?php
/**
 * Training Controller - Gestión de Capacitaciones
 * 
 * Maneja todas las operaciones relacionadas con la visualización
 * y búsqueda de capacitaciones disponibles.
 * 
 * @author Sistema de Capacitaciones
 * @version 1.0
 */

// Prevenir acceso directo
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

class TrainingController
{
    private $dbCourses;  // PDO conexión a sistema_cursos
    private $dbMain;     // PDO conexión a sistema_institucional

    /**
     * Constructor del controlador
     * @param PDO $dbCourses Conexión a base de datos de cursos
     * @param PDO $dbMain Conexión a base de datos principal (equipos)
     */
    public function __construct($dbCourses, $dbMain)
    {
        $this->dbCourses = $dbCourses;
        $this->dbMain = $dbMain;
    }

    /**
     * Obtener capacitaciones destacadas (máximo 5)
     * Para mostrar en el carrusel principal
     * 
     * @return array Lista de capacitaciones destacadas
     */
    public function getCapacitacionesDestacadas()
    {
        try {
            // 1. Obtener capacitaciones destacadas de la BD de cursos
            $sql = "
                SELECT 
                    c.id,
                    c.estado_id,
                    c.nombre,
                    c.equipo_id,
                    DATE_FORMAT(c.fecha_inicio_cursada, '%d/%m/%Y') as fecha_format,
                    c.fecha_inicio_cursada,
                    c.ruta_imagen,
                    c.es_destacado
                FROM capacitaciones c
                WHERE c.esta_publicada = 1
                  AND c.esta_eliminada = 0
                  AND c.estado_id IN (4, 5)
                  AND c.es_destacado = 1
                ORDER BY c.fecha_inicio_cursada ASC
                LIMIT 5
            ";

            $stmt = $this->dbCourses->prepare($sql);
            $stmt->execute();
            $capacitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 2. Si no hay capacitaciones, retornar vacío
            if (empty($capacitaciones)) {
                return [];
            }

            // 3. Obtener IDs de equipos únicos
            $equipoIds = array_unique(array_column($capacitaciones, 'equipo_id'));
            $equipoIds = array_filter($equipoIds); // Remover nulls

            // 4. Obtener información de equipos de la BD principal
            $equipos = $this->getEquiposByIds($equipoIds);

            // 5. Combinar datos (hacer el JOIN en PHP)
            foreach ($capacitaciones as &$capacitacion) {
                $equipoId = $capacitacion['equipo_id'];
                $capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
            }

            return $capacitaciones;

        } catch (PDOException $e) {
            error_log("Error en getCapacitacionesDestacadas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener todas las capacitaciones disponibles (incluyendo destacadas)
     * 
     * @return array Lista de todas las capacitaciones publicadas
     */
    public function getCapacitacionesDisponibles()
    {
        try {
            // 1. Obtener capacitaciones de la BD de cursos
            $sql = "
                SELECT 
                    c.id,
                    c.estado_id,
                    c.nombre,
                    c.equipo_id,
                    DATE_FORMAT(c.fecha_inicio_cursada, '%d/%m/%Y') as fecha_format,
                    c.fecha_inicio_cursada,
                    c.ruta_imagen,
                    c.es_destacado,
                    c.link
                FROM capacitaciones c
                WHERE c.esta_publicada = 1
                  AND c.esta_eliminada = 0
                  AND c.estado_id IN (4, 5)
                ORDER BY c.fecha_inicio_cursada ASC
            ";

            $stmt = $this->dbCourses->prepare($sql);
            $stmt->execute();
            $capacitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 2. Si no hay capacitaciones, retornar vacío
            if (empty($capacitaciones)) {
                return [];
            }

            // 3. Obtener IDs de equipos únicos
            $equipoIds = array_unique(array_column($capacitaciones, 'equipo_id'));
            $equipoIds = array_filter($equipoIds); // Remover nulls

            // 4. Obtener información de equipos de la BD principal
            $equipos = $this->getEquiposByIds($equipoIds);

            // 5. Combinar datos (hacer el JOIN en PHP)
            foreach ($capacitaciones as &$capacitacion) {
                $equipoId = $capacitacion['equipo_id'];
                $capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
            }

            return $capacitaciones;

        } catch (PDOException $e) {
            error_log("Error en getCapacitacionesDisponibles: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Búsqueda global de capacitaciones
     * Busca en nombre del curso, equipo y fecha con un solo término
     * 
     * @param string $termino Término de búsqueda global
     * @return array Lista de capacitaciones que cumplen la búsqueda
     */
    public function buscarCapacitacionesGlobal($termino)
    {
        try {
            // 1. Obtener todas las capacitaciones disponibles
            $capacitaciones = $this->getCapacitacionesDisponibles();

            if (empty($capacitaciones)) {
                return [];
            }

            // 2. Filtrar en PHP por el término de búsqueda
            $termino_lower = strtolower($termino);
            $resultados = array_filter($capacitaciones, function ($curso) use ($termino_lower) {
                $nombre = strtolower($curso['nombre'] ?? '');
                $equipo = strtolower($curso['equipo_nombre'] ?? '');
                $fecha = $curso['fecha_inicio_cursada'] ?? '';

                return strpos($nombre, $termino_lower) !== false
                    || strpos($equipo, $termino_lower) !== false
                    || strpos($fecha, $termino_lower) !== false;
            });

            return array_values($resultados); // Re-indexar array

        } catch (PDOException $e) {
            error_log("Error en buscarCapacitacionesGlobal: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Buscar capacitaciones con filtros
     * 
     * @param string|null $nombre Nombre del curso (búsqueda parcial)
     * @param int|null $equipo_id ID del equipo responsable
     * @param string|null $fecha_desde Fecha mínima de inicio (formato: Y-m-d)
     * @return array Lista de capacitaciones que cumplen los filtros
     */
    public function buscarCapacitaciones($nombre = null, $equipo_id = null, $fecha_desde = null)
    {
        try {
            // 1. Construir consulta base
            $sql = "
                SELECT 
                    c.id,
                    c.nombre,
                    c.equipo_id,
                    c.fecha_inicio_cursada,
                    c.ruta_imagen,
                    c.es_destacado
                FROM capacitaciones c
                WHERE c.esta_publicada = 1
                  AND c.esta_eliminada = 0
                  AND c.estado_id = 4
            ";

            $params = [];

            // Filtro por nombre (LIKE)
            if (!empty($nombre)) {
                $sql .= " AND c.nombre LIKE :nombre";
                $params[':nombre'] = '%' . $nombre . '%';
            }

            // Filtro por equipo
            if (!empty($equipo_id)) {
                $sql .= " AND c.equipo_id = :equipo_id";
                $params[':equipo_id'] = $equipo_id;
            }

            // Filtro por fecha de inicio
            if (!empty($fecha_desde)) {
                $sql .= " AND c.fecha_inicio_cursada >= :fecha_desde";
                $params[':fecha_desde'] = $fecha_desde;
            }

            $sql .= " ORDER BY c.fecha_inicio_cursada ASC";

            $stmt = $this->dbCourses->prepare($sql);
            $stmt->execute($params);
            $capacitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 2. Si no hay resultados, retornar vacío
            if (empty($capacitaciones)) {
                return [];
            }

            // 3. Obtener IDs de equipos únicos
            $equipoIds = array_unique(array_column($capacitaciones, 'equipo_id'));
            $equipoIds = array_filter($equipoIds);

            // 4. Obtener información de equipos
            $equipos = $this->getEquiposByIds($equipoIds);

            // 5. Combinar datos
            foreach ($capacitaciones as &$capacitacion) {
                $equipoId = $capacitacion['equipo_id'];
                $capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
            }

            return $capacitaciones;

        } catch (PDOException $e) {
            error_log("Error en buscarCapacitaciones: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener lista de equipos que tienen capacitaciones publicadas
     * Para poblar el select del buscador
     * 
     * @return array Lista de equipos [id_equipo, alias]
     */
    public function getEquiposConCapacitaciones()
    {
        try {
            // 1. Obtener IDs de equipos que tienen capacitaciones publicadas
            $sql = "
                SELECT DISTINCT c.equipo_id
                FROM capacitaciones c
                WHERE c.esta_publicada = 1
                  AND c.esta_eliminada = 0
                  AND c.estado_id = 4
                  AND c.equipo_id IS NOT NULL
            ";

            $stmt = $this->dbCourses->prepare($sql);
            $stmt->execute();
            $equipoIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (empty($equipoIds)) {
                return [];
            }

            // 2. Obtener información completa de esos equipos
            $placeholders = implode(',', array_fill(0, count($equipoIds), '?'));
            $sql = "
                SELECT 
                    id_equipo,
                    alias
                FROM equipos
                WHERE id_equipo IN ($placeholders)
                  AND estado = 'habilitado'
                  AND borrado = 0
                ORDER BY alias ASC
            ";

            $stmt = $this->dbMain->prepare($sql);
            $stmt->execute($equipoIds);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getEquiposConCapacitaciones: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene información detallada de una capacitación para mostrar en detalle
     * Incluye: datos básicos, módulos recursivos, cronograma
     * 
     * @param int $id ID de la capacitación
     * @return array|null Datos completos o null si no existe
     */
    public function getCapacitacionDetalle($id)
    {
        try {
            // 1. Obtener datos básicos (incluye estado_id desde BD)
            $capacitacion = $this->getCapacitacionBasica($id);

            if (!$capacitacion) {
                return null;
            }

            // 2. Obtener módulos recursivos
            $capacitacion['modulos'] = $this->getModulos($id);

            // 3. Obtener cronograma
            $capacitacion['cronograma'] = $this->getCronograma($id);

            return $capacitacion;

        } catch (PDOException $e) {
            error_log("Error en getCapacitacionDetalle: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene datos básicos de una capacitación
     * El estado_id se obtiene directamente desde la base de datos
     * 
     * @param int $id ID de la capacitación
     * @return array|null Datos de la capacitación o null si no existe
     */
    private function getCapacitacionBasica($id)
    {
        try {
            $sql = "SELECT 
                    c.id,
                    c.estado_id,
                    c.nombre,
                    c.slogan,
                    c.tipo_categoria,
                    c.categoria_id,
                    c.tipo_modalidad,
                    c.lugar,
                    c.objetivo,
                    c.que_aprenderas,
                    c.destinatarios,
                    c.requisitos,
                    c.duracion_clase_minutos,
                    c.total_encuentros,
                    c.fecha_inicio_cursada,
                    
                    -- Obtener nombre de categoría según el tipo
                    CASE 
                        WHEN c.tipo_categoria = 'general' THEN cg.nombre
                        WHEN c.tipo_categoria = 'especifica' THEN ce.nombre
                        WHEN c.tipo_categoria = 'subcategoria' THEN sc.nombre
                        ELSE NULL
                    END as nivel,
                    
                    -- Validar si está cerrada (estado_id = 5)
                    IF(c.estado_id = 5, 1, 0) as esta_cerrado
                    
                FROM capacitaciones c
                LEFT JOIN categorias_generales cg ON c.tipo_categoria = 'general' AND c.categoria_id = cg.id
                LEFT JOIN categorias_especificas ce ON c.tipo_categoria = 'especifica' AND c.categoria_id = ce.id
                LEFT JOIN subcategorias sc ON c.tipo_categoria = 'subcategoria' AND c.categoria_id = sc.id
                
                WHERE c.id = :id 
                AND c.esta_publicada = 1
                AND c.esta_eliminada = 0";

            $stmt = $this->dbCourses->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getCapacitacionBasica: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene los módulos de una capacitación
     * 
     * @param int $capacitacion_id
     * @return array
     */
    private function getModulos($capacitacion_id)
    {
        $sql = "SELECT 
                    id,
                    tema_padre_id,
                    descripcion
                FROM temas
                WHERE capacitacion_id = :capacitacion_id
                AND esta_eliminado = 0
                ORDER BY id ASC";

        $stmt = $this->dbCourses->prepare($sql);
        $stmt->bindParam(':capacitacion_id', $capacitacion_id, PDO::PARAM_INT);
        $stmt->execute();

        $temas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir estructura jerárquica
        return $this->construirArbolTemas($temas);
    }

    /**
     * Construye estructura recursiva de temas (módulos y submódulos)
     * 
     * @param array $temas Array plano de todos los temas
     * @param int|null $padre_id ID del tema padre (null para raíz)
     * @return array
     */
    private function construirArbolTemas($temas, $padre_id = null)
    {
        $arbol = [];

        foreach ($temas as $tema) {
            if ($tema['tema_padre_id'] == $padre_id) {
                // Buscar submódulos de este tema
                $submodulos = $this->construirArbolTemas($temas, $tema['id']);

                $nodo = [
                    'id' => $tema['id'],
                    'descripcion' => $tema['descripcion']
                ];

                // Solo agregar submódulos si existen
                if (!empty($submodulos)) {
                    $nodo['submodulos'] = $submodulos;
                }

                $arbol[] = $nodo;
            }
        }

        return $arbol;
    }

    /**
     * Obtiene el cronograma de una capacitación
     * 
     * @param int $capacitacion_id
     * @return array
     */
    private function getCronograma($capacitacion_id)
    {
        $sql = "SELECT 
                    d.id as dia_id,
                    d.nombre as nombre_dia,
                    cr.hora_inicio,
                    cr.hora_fin
                FROM cronogramas cr
                INNER JOIN dias d ON cr.dia_id = d.id
                WHERE cr.capacitacion_id = :capacitacion_id
                ORDER BY d.id ASC";

        $stmt = $this->dbCourses->prepare($sql);
        $stmt->bindParam(':capacitacion_id', $capacitacion_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCapacitacionCompleta($id)
    {
        try {
            // 1. Obtener datos de la capacitación
            $sql = "
                SELECT 
                    c.*,
                    est.nombre AS estado_nombre
                FROM capacitaciones c
                LEFT JOIN estados_capacitacion est 
                    ON c.estado_id = est.id
                WHERE c.id = :id
                  AND c.esta_publicada = 1
                  AND c.esta_eliminada = 0
            ";

            $stmt = $this->dbCourses->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $capacitacion = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$capacitacion) {
                return null;
            }

            // 2. Obtener nombre del equipo si existe
            if (!empty($capacitacion['equipo_id'])) {
                $equipos = $this->getEquiposByIds([$capacitacion['equipo_id']]);
                $capacitacion['equipo_nombre'] = $equipos[$capacitacion['equipo_id']] ?? 'Sin equipo';
            } else {
                $capacitacion['equipo_nombre'] = 'Sin equipo';
            }

            return $capacitacion;

        } catch (PDOException $e) {
            error_log("Error en getCapacitacionCompleta: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Auxiliar: Obtener información de equipos por sus IDs
     * Consulta la BD principal y retorna un array asociativo [id_equipo => alias]
     * 
     * @param array $equipoIds Array de IDs de equipos
     * @return array Array asociativo [id_equipo => alias]
     */
    private function getEquiposByIds($equipoIds)
    {
        if (empty($equipoIds)) {
            return [];
        }

        try {
            // Crear placeholders para la consulta IN
            $placeholders = implode(',', array_fill(0, count($equipoIds), '?'));

            $sql = "
                SELECT 
                    id_equipo,
                    alias
                FROM equipos
                WHERE id_equipo IN ($placeholders)
                  AND estado = 'habilitado'
                  AND borrado = 0
            ";

            $stmt = $this->dbMain->prepare($sql);
            $stmt->execute(array_values($equipoIds));

            $equipos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $equipos[$row['id_equipo']] = $row['alias'];
            }

            return $equipos;

        } catch (PDOException $e) {
            error_log("Error en getEquiposByIds: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Auxiliar: Obtener nombre de la base de datos principal
     * Detecta si es entorno local o producción
     * 
     * @return string Nombre de la BD principal
     */
    private function getMainDatabaseName()
    {
        $esLocal = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);
        return $esLocal ? 'sistema_institucional' : 'u881364944_sistema_inst';
    }
}
