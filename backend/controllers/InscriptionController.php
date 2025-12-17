<?php
/**
 * Inscription Controller - Gestión de Inscripciones
 * 
 * Maneja todas las operaciones relacionadas con las inscripciones
 * a capacitaciones: validaciones, registro, catálogos, etc.
 * 
 * @author Sistema de Capacitaciones
 * @version 1.0
 */

// Prevenir acceso directo
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

class InscriptionController
{
    private $db; // PDO conexión a sistema_cursos

    /**
     * Constructor del controlador
     * @param PDO $db Conexión a base de datos de cursos
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Obtener lista de barrios para el select
     * @return array Lista de barrios ordenados alfabéticamente
     */
    public function getBarrios()
    {
        try {
            $sql = "
                SELECT 
                    id,
                    descripcion
                FROM barrios
                ORDER BY descripcion ASC
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getBarrios: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener lista de niveles educativos para el select
     * @return array Lista de niveles educativos ordenados por id
     */
    public function getNivelesEducativos()
    {
        try {
            $sql = "
                SELECT 
                    id,
                    descipcion as descripcion
                FROM niveles_educativos
                ORDER BY id ASC
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getNivelesEducativos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener lista de ocupaciones para el select
     * @return array Lista de ocupaciones
     */
    public function getOcupaciones()
    {
        try {
            $sql = "
                SELECT 
                    id,
                    descripcion
                FROM ocupaciones
                ORDER BY id ASC
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getOcupaciones: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Verificar si un DNI ya está registrado
     * @param string $dni DNI a verificar
     * @return bool True si existe, False si no existe
     */
    public function dniExiste($dni)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM inscripciones WHERE dni = :dni";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] > 0;

        } catch (PDOException $e) {
            error_log("Error en dniExiste: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un email ya está registrado
     * @param string $email Email a verificar
     * @return bool True si existe, False si no existe
     */
    public function emailExiste($email)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM inscripciones WHERE email = :email";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] > 0;

        } catch (PDOException $e) {
            error_log("Error en emailExiste: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si ya está inscrito en una capacitación específica
     * @param string $dni DNI del usuario
     * @param int $capacitacion_id ID de la capacitación
     * @return bool True si ya está inscrito, False si no
     */
    public function yaEstaInscrito($dni, $capacitacion_id)
    {
        try {
            $sql = "
                SELECT COUNT(*) as total 
                FROM inscripciones i
                INNER JOIN inscripciones_capacitaciones ic ON i.id = ic.inscripcion_id
                WHERE i.dni = :dni 
                  AND ic.capacitacion_id = :capacitacion_id
                  AND ic.estado IN ('pendiente', 'confirmada')
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':capacitacion_id', $capacitacion_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] > 0;

        } catch (PDOException $e) {
            error_log("Error en yaEstaInscrito: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Registrar nueva inscripción (TRANSACCIONAL)
     * 
     * Proceso:
     * 1. Validar formato de datos
     * 2. Verificar duplicados (DNI, email)
     * 3. Verificar si ya está inscrito en esta capacitación
     * 4. Verificar cupos disponibles
     * 5. BEGIN TRANSACTION
     * 6. INSERT o GET id de inscripciones
     * 7. INSERT en inscripciones_capacitaciones
     * 8. COMMIT
     * 
     * @param array $datos Datos del formulario
     * @return array ['success' => bool, 'message' => string, 'inscripcion_id' => int|null]
     */
    public function registrarInscripcion($datos)
    {
        try {
            // 0. NORMALIZAR DATOS
            $datos = $this->normalizarDatos($datos);

            // 1. VALIDAR FORMATO DE DATOS
            $errores = $this->validarDatos($datos);
            if (!empty($errores)) {
                return [
                    'success' => false,
                    'message' => implode('<br>', $errores),
                    'inscripcion_id' => null
                ];
            }

            // 2. VERIFICAR SI YA ESTÁ INSCRITO EN ESTA CAPACITACIÓN
            if ($this->yaEstaInscrito($datos['dni'], $datos['capacitacion_id'])) {
                return [
                    'success' => false,
                    'message' => 'Ya se encuentra inscrito en esta capacitación.',
                    'inscripcion_id' => null
                ];
            }

            // 3. VERIFICAR CUPOS DISPONIBLES
            if (!$this->hayDisponibilidad($datos['capacitacion_id'])) {
                return [
                    'success' => false,
                    'message' => 'No hay cupos disponibles para esta capacitación.',
                    'inscripcion_id' => null
                ];
            }

            // 4. INICIAR TRANSACCIÓN
            $this->db->beginTransaction();

            // 5. VERIFICAR SI EL DNI YA EXISTE
            $inscripcion_id = $this->getInscripcionIdPorDni($datos['dni']);

            if ($inscripcion_id === null) {
                // 5a. DNI NO EXISTE - Insertar nueva inscripción
                $inscripcion_id = $this->insertarInscripcion($datos);

                if ($inscripcion_id === null) {
                    throw new Exception('Error al registrar los datos personales.');
                }
            } else {
                // 5b. DNI EXISTE - Verificar si el email coincide
                $email_existente = $this->getEmailPorInscripcionId($inscripcion_id);

                if ($email_existente !== $datos['email']) {
                    // El DNI existe pero con otro email - posible duplicado fraudulento
                    throw new Exception('El DNI ya está registrado con otro correo electrónico. Verifique sus datos.');
                }
            }

            // 6. INSERTAR RELACIÓN EN inscripciones_capacitaciones
            $resultado_relacion = $this->insertarInscripcionCapacitacion($inscripcion_id, $datos['capacitacion_id']);

            if (!$resultado_relacion) {
                throw new Exception('Error al vincular la inscripción con la capacitación.');
            }

            // 7. COMMIT - Todo exitoso
            $this->db->commit();

            // Log de éxito
            error_log("INSCRIPCIÓN EXITOSA: DNI={$datos['dni']}, Curso={$datos['capacitacion_id']}, InscripcionID={$inscripcion_id}");

            return [
                'success' => true,
                'message' => 'Inscripción registrada exitosamente.',
                'inscripcion_id' => $inscripcion_id
            ];

        } catch (Exception $e) {
            // ROLLBACK en caso de error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            // Log de error
            error_log("ERROR EN INSCRIPCIÓN: " . $e->getMessage() . " | DNI: " . ($datos['dni'] ?? 'N/A'));

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'inscripcion_id' => null
            ];
        }
    }

    /**
     * Validar formato de datos del formulario
     * @param array $datos
     * @return array Lista de errores (vacío si todo OK)
     */
    private function validarDatos($datos)
    {
        $errores = [];

        // Validar DNI (7-8 dígitos)
        if (!isset($datos['dni']) || !preg_match('/^[0-9]{7,8}$/', $datos['dni'])) {
            $errores[] = 'El DNI debe tener 7 u 8 dígitos sin puntos.';
        }

        // Validar email
        if (!isset($datos['email']) || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido.';
        }

        // Validar nombre (solo letras y espacios)
        if (!isset($datos['nombre']) || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/', $datos['nombre'])) {
            $errores[] = 'El nombre solo puede contener letras y espacios.';
        }

        // Validar apellido (solo letras y espacios)
        if (!isset($datos['apellido']) || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/', $datos['apellido'])) {
            $errores[] = 'El apellido solo puede contener letras y espacios.';
        }

        // Validar celular (solo números, 10-20 caracteres)
        if (!isset($datos['celular']) || !preg_match('/^[0-9]{10,20}$/', $datos['celular'])) {
            $errores[] = 'El celular debe contener solo números (10-20 dígitos).';
        }

        // Validar celular alternativo (opcional, pero si existe debe ser válido)
        // Permite de 7 a 20 dígitos para ser más flexible
        if (isset($datos['celular_alternativo']) && trim($datos['celular_alternativo']) !== '' && !preg_match('/^[0-9]{7,20}$/', $datos['celular_alternativo'])) {
            $errores[] = 'El celular alternativo debe contener solo números (7-20 dígitos).';
        }

        // Validar fecha de nacimiento (mayor de 18 años)
        if (!isset($datos['fecha_nacimiento'])) {
            $errores[] = 'La fecha de nacimiento es obligatoria.';
        } else {
            $fecha_nac = new DateTime($datos['fecha_nacimiento']);
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nac)->y;

            if ($edad < 18) {
                $errores[] = 'Debe ser mayor de 18 años para inscribirse.';
            }
        }

        return $errores;
    }

    /**
     * Normalizar datos del formulario antes de validar e insertar
     * @param array $datos Datos crudos del formulario
     * @return array Datos normalizados
     */
    private function normalizarDatos($datos)
    {
        return [
            // Capacitación ID (sin cambios)
            'capacitacion_id' => $datos['capacitacion_id'] ?? null,

            // Nombres: Primera letra mayúscula de cada palabra
            'nombre' => isset($datos['nombre'])
                ? ucwords(mb_strtolower(trim($datos['nombre']), 'UTF-8'), " \t\r\n\f\v-")
                : '',

            'apellido' => isset($datos['apellido'])
                ? ucwords(mb_strtolower(trim($datos['apellido']), 'UTF-8'), " \t\r\n\f\v-")
                : '',

            // Fecha de nacimiento (sin cambios)
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? '',

            // Sexo: Capitalizar
            'sexo' => isset($datos['sexo'])
                ? ucfirst(strtolower(trim($datos['sexo'])))
                : '',

            // DNI: Solo números
            'dni' => isset($datos['dni'])
                ? preg_replace('/[^0-9]/', '', $datos['dni'])
                : '',

            // Email: Minúsculas
            'email' => isset($datos['email'])
                ? strtolower(trim($datos['email']))
                : '',

            // Celular: Solo números
            'celular' => isset($datos['celular'])
                ? preg_replace('/[^0-9]/', '', $datos['celular'])
                : '',

            // Celular alternativo: Solo números (puede estar vacío)
            'celular_alternativo' => isset($datos['celular_alternativo']) && !empty(trim($datos['celular_alternativo']))
                ? preg_replace('/[^0-9]/', '', $datos['celular_alternativo'])
                : '',

            // Domicilio: Capitalizar palabras
            'domicilio' => isset($datos['domicilio'])
                ? ucwords(mb_strtolower(trim($datos['domicilio']), 'UTF-8'), " \t\r\n\f\v-")
                : '',

            // IDs de catálogos (sin cambios)
            'barrio_id' => $datos['barrio_id'] ?? null,
            'nivel_educativo_id' => $datos['nivel_educativo_id'] ?? null,
            'ocupacion_id' => $datos['ocupacion_id'] ?? null,
        ];
    }

    /**
     * Obtener ID de inscripción por DNI
     * @param string $dni
     * @return int|null ID de inscripción o null si no existe
     */
    private function getInscripcionIdPorDni($dni)
    {
        try {
            $sql = "SELECT id FROM inscripciones WHERE dni = :dni LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int) $result['id'] : null;

        } catch (PDOException $e) {
            error_log("Error en getInscripcionIdPorDni: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener email asociado a una inscripción
     * @param int $inscripcion_id
     * @return string|null Email o null
     */
    private function getEmailPorInscripcionId($inscripcion_id)
    {
        try {
            $sql = "SELECT email FROM inscripciones WHERE id = :id LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $inscripcion_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['email'] : null;

        } catch (PDOException $e) {
            error_log("Error en getEmailPorInscripcionId: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Insertar nueva inscripción en tabla inscripciones
     * @param array $datos
     * @return int|null ID del registro insertado o null si falla
     */
    private function insertarInscripcion($datos)
    {
        try {
            $sql = "
                INSERT INTO inscripciones (
                    nombre, 
                    apellido, 
                    fecha_nacimiento, 
                    sexo, 
                    dni, 
                    email, 
                    celular, 
                    celular_alternativo, 
                    domicilio, 
                    barrio_id, 
                    nivel_educativo_id, 
                    ocupacion_id
                ) VALUES (
                    :nombre, 
                    :apellido, 
                    :fecha_nacimiento, 
                    :sexo, 
                    :dni, 
                    :email, 
                    :celular, 
                    :celular_alternativo, 
                    :domicilio, 
                    :barrio_id, 
                    :nivel_educativo_id, 
                    :ocupacion_id
                )
            ";

            $stmt = $this->db->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $datos['apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(':sexo', $datos['sexo'], PDO::PARAM_STR);
            $stmt->bindParam(':dni', $datos['dni'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
            $stmt->bindParam(':celular', $datos['celular'], PDO::PARAM_STR);

            // Celular alternativo puede ser null
            $celular_alt = !empty($datos['celular_alternativo']) ? $datos['celular_alternativo'] : null;
            $stmt->bindParam(':celular_alternativo', $celular_alt, PDO::PARAM_STR);

            $stmt->bindParam(':domicilio', $datos['domicilio'], PDO::PARAM_STR);
            $stmt->bindParam(':barrio_id', $datos['barrio_id'], PDO::PARAM_INT);
            $stmt->bindParam(':nivel_educativo_id', $datos['nivel_educativo_id'], PDO::PARAM_INT);
            $stmt->bindParam(':ocupacion_id', $datos['ocupacion_id'], PDO::PARAM_INT);

            $stmt->execute();

            // Retornar ID del registro insertado
            return (int) $this->db->lastInsertId();

        } catch (PDOException $e) {
            error_log("Error en insertarInscripcion: " . $e->getMessage());
            throw new Exception('Error al guardar los datos personales en la base de datos.');
        }
    }

    /**
     * Insertar relación inscripción-capacitación
     * @param int $inscripcion_id
     * @param int $capacitacion_id
     * @return bool True si éxito, False si falla
     */
    private function insertarInscripcionCapacitacion($inscripcion_id, $capacitacion_id)
    {
        try {
            $sql = "
                INSERT INTO inscripciones_capacitaciones (
                    inscripcion_id, 
                    capacitacion_id, 
                    estado
                ) VALUES (
                    :inscripcion_id, 
                    :capacitacion_id, 
                    'confirmada'
                )
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':inscripcion_id', $inscripcion_id, PDO::PARAM_INT);
            $stmt->bindParam(':capacitacion_id', $capacitacion_id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en insertarInscripcionCapacitacion: " . $e->getMessage());
            throw new Exception('Error al registrar la inscripción a la capacitación.');
        }
    }

    /**
     * Verificar si hay cupos disponibles en una capacitación
     * @param int $capacitacion_id
     * @return bool True si hay cupos, False si no hay
     */
    private function hayDisponibilidad($capacitacion_id)
    {
        try {
            $sql = "
                SELECT 
                    c.cupos_maximos,
                    COUNT(ic.id) as inscritos
                FROM capacitaciones c
                LEFT JOIN inscripciones_capacitaciones ic 
                    ON c.id = ic.capacitacion_id 
                    AND ic.estado IN ('pendiente', 'confirmada')
                WHERE c.id = :capacitacion_id
                GROUP BY c.id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':capacitacion_id', $capacitacion_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return false; // Capacitación no encontrada
            }

            $cupos_maximos = (int) $result['cupos_maximos'];
            $inscritos = (int) $result['inscritos'];

            return ($cupos_maximos - $inscritos) > 0;

        } catch (PDOException $e) {
            error_log("Error en hayDisponibilidad: " . $e->getMessage());
            return false;
        }
    }
}
