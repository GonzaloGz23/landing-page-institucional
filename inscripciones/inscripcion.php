<?php 
/**
 * Formulario de Inscripción
 * 
 * Página para que el usuario complete sus datos personales
 * y se inscriba a una capacitación específica.
 * Recibe: id (capacitación) codificado en URL
 */

// Definir acceso seguro
define('SECURE_ACCESS', true);

require_once __DIR__ . '/../backend/config/IdEncoder.php';
require_once __DIR__ . '/../backend/config/BDConections.php';
require_once __DIR__ . '/../backend/controllers/TrainingController.php';
require_once __DIR__ . '/../backend/controllers/InscriptionController.php';

// Recibir parámetro codificado (solo ID)
$id_encoded = $_GET['id'] ?? null;

// Validar que exista el parámetro
if (!$id_encoded) {
    die('⚠️ Parámetro ID requerido. Acceso denegado.');
}

// Decodificar ID
$id_capacitacion = IdEncoder::decode($id_encoded);

// Validar decodificación exitosa
if ($id_capacitacion === null) {
    die('⚠️ URL inválida o manipulada. Acceso denegado.');
}

// Instanciar controller para obtener datos de la capacitación
$trainingController = new TrainingController(
    DatabaseManager::getConnection('courses'),
    DatabaseManager::getConnection('main')
);

// Obtener datos básicos de la capacitación (incluye estado_id desde BD)
$capacitacion = $trainingController->getCapacitacionDetalle($id_capacitacion);

if (!$capacitacion) {
    die('⚠️ Capacitación no encontrada o no disponible.');
}

// Verificar si la capacitación está cerrada (pero no bloquear acceso)
$esta_cerrado = $capacitacion['esta_cerrado'];

// Si está cerrada, no procesar el formulario
if ($esta_cerrado && $_SERVER['REQUEST_METHOD'] === 'POST') {
    die('⚠️ Esta capacitación ya no acepta inscripciones.');
}

// Instanciar InscriptionController para obtener catálogos y procesar inscripción
$inscriptionController = new InscriptionController(DatabaseManager::getConnection('courses'));

// Procesar formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Preparar datos para la inscripción
        $datos = [
            'capacitacion_id' => $id_capacitacion,
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
            'sexo' => $_POST['sexo'] ?? '',
            'dni' => trim($_POST['dni'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'celular' => trim($_POST['celular'] ?? ''),
            'celular_alternativo' => trim($_POST['celular_alternativo'] ?? ''),
            'domicilio' => trim($_POST['domicilio'] ?? ''),
            'barrio_id' => $_POST['barrio_id'] ?? null,
            'nivel_educativo_id' => $_POST['nivel_educativo_id'] ?? null,
            'ocupacion_id' => $_POST['ocupacion_id'] ?? null
        ];
        
        // Llamar al método de registro
        $resultado = $inscriptionController->registrarInscripcion($datos);
        
        if ($resultado['success']) {
            // Redirigir con mensaje de éxito
            header('Location: inscripcion.php?id=' . $id_encoded . '&success=1');
            exit;
        } else {
            // Determinar tipo de error para la URL
            $error_type = 'invalid';
            if (strpos($resultado['message'], 'ya está inscrito') !== false || 
                strpos($resultado['message'], 'DNI') !== false || 
                strpos($resultado['message'], 'correo') !== false) {
                $error_type = 'duplicado';
            } elseif (strpos($resultado['message'], 'cupos') !== false || 
                      strpos($resultado['message'], 'disponibles') !== false) {
                $error_type = 'completo';
            } elseif (strpos($resultado['message'], 'cerrada') !== false) {
                $error_type = 'cerrado';
            }
            
            // Redirigir con mensaje de error
            header('Location: inscripcion.php?id=' . $id_encoded . '&error=' . $error_type);
            exit;
        }
        
    } catch (Exception $e) {
        // Error inesperado
        error_log("Error en inscripcion.php: " . $e->getMessage());
        header('Location: inscripcion.php?id=' . $id_encoded . '&error=invalid');
        exit;
    }
}

// Obtener datos para los selects del formulario
$barrios = $inscriptionController->getBarrios();
$niveles = $inscriptionController->getNivelesEducativos();
$ocupaciones = $inscriptionController->getOcupaciones();

// Configuración de la página para el header
$page_title = 'Inscripción - ' . htmlspecialchars($capacitacion['nombre']);
$body_class = 'bg-capacitaciones';
$page_level = 'inscripciones';
$current_page = 'inscripcion.php';
$page_css = ['pages/inscripcion.min.css'];
$page_js = ['pages/inscripcion.js'];

// Incluir header
include __DIR__ . '/../components/header.php';
?>

<main class="container py-5 inscripcion-form-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Volver al detalle -->
            <a href="detalleCapacitacion.php?id=<?= $id_encoded ?>" 
               class="volver-link mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Volver al detalle
            </a>
            
            <!-- Título Principal -->
            <h1 class="mb-4">Formulario de Inscripción</h1>
            
            <!-- Alerta si está cerrada -->
            <?php if ($esta_cerrado): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Inscripciones cerradas</strong><br>
                    Esta capacitación ya no acepta nuevas inscripciones. Los campos están deshabilitados solo para visualización.
                </div>
            <?php endif; ?>
            
            <!-- Formulario de inscripción -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Datos Personales
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="" id="formInscripcion" novalidate>
                        <!-- Hidden inputs -->
                        <input type="hidden" name="capacitacion_id" value="<?= $id_capacitacion ?>">
                        
                        <!-- SECCIÓN 1: Datos Personales Básicos -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bi bi-person-fill"></i> Información Personal
                                </h5>
                            </div>
                            
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nombre" 
                                           name="nombre" 
                                           value=""
                                           placeholder="Ingrese su nombre"
                                           required
                                           maxlength="100"
                                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                           title="Solo se permiten letras y espacios"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingrese su nombre (solo letras).
                                </div>
                            </div>
                            
                            <!-- Apellido -->
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">
                                    Apellido <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="apellido" 
                                           name="apellido" 
                                           value=""
                                           placeholder="Ingrese su apellido"
                                           required
                                           maxlength="100"
                                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                           title="Solo se permiten letras y espacios"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingrese su apellido (solo letras).
                                </div>
                            </div>
                            
                            <!-- Fecha de Nacimiento -->
                            <div class="col-md-4 mb-3">
                                <label for="fecha_nacimiento" class="form-label">
                                    Fecha de Nacimiento <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" 
                                           class="form-control" 
                                           id="fecha_nacimiento" 
                                           name="fecha_nacimiento" 
                                           value=""
                                           required
                                           max="<?= date('Y-m-d', strtotime('-18 years')) ?>"
                                           min="<?= date('Y-m-d', strtotime('-100 years')) ?>"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    Debe ser mayor de 18 años.
                                </div>
                                <small class="form-text">Debe ser mayor de 18 años</small>
                            </div>
                            
                            <!-- Sexo -->
                            <div class="col-md-4 mb-3">
                                <label for="sexo" class="form-label">
                                    Sexo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select class="form-select" id="sexo" name="sexo" required <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor seleccione su sexo.
                                </div>
                            </div>
                            
                            <!-- DNI -->
                            <div class="col-md-4 mb-3">
                                <label for="dni" class="form-label">
                                    DNI <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="dni" 
                                           name="dni" 
                                           value=""
                                           placeholder="Ej: 12345678"
                                           required
                                           minlength="7"
                                           maxlength="8"
                                           pattern="[0-9]{7,8}"
                                           title="Ingrese 7 u 8 dígitos sin puntos"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    DNI inválido (7 u 8 dígitos sin puntos).
                                </div>
                                <small class="form-text">Sin puntos ni espacios</small>
                            </div>
                        </div>
                        
                        <!-- SECCIÓN 2: Información de Contacto -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bi bi-telephone-fill"></i> Información de Contacto
                                </h5>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value=""
                                           placeholder="ejemplo@correo.com"
                                           required
                                           maxlength="255"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingrese un correo electrónico válido.
                                </div>
                            </div>
                            
                            <!-- Celular -->
                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">
                                    Celular <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="celular" 
                                           name="celular" 
                                           value=""
                                           placeholder="Ej: 3704123456"
                                           required
                                           maxlength="20"
                                           pattern="[0-9]+"
                                           title="Solo números sin espacios ni guiones"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    Ingrese un número de celular válido (solo números).
                                </div>
                                <small class="form-text">Solo números, sin espacios</small>
                            </div>
                            
                            <!-- Celular Alternativo (Opcional) -->
                            <div class="col-md-6 mb-3">
                                <label for="celular_alternativo" class="form-label">
                                    Celular Alternativo <span>(Opcional)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="celular_alternativo" 
                                           name="celular_alternativo" 
                                           value=""
                                           placeholder="Ej: 3704123456"
                                           maxlength="20"
                                           pattern="[0-9]*"
                                           title="Solo números sin espacios ni guiones"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <small class="form-text">Solo números, sin espacios</small>
                            </div>
                        </div>
                        
                        <!-- SECCIÓN 3: Información Adicional -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bi bi-geo-alt-fill"></i> Información Adicional
                                </h5>
                            </div>
                            
                            <!-- Domicilio -->
                            <div class="col-md-12 mb-3">
                                <label for="domicilio" class="form-label">
                                    Domicilio <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="domicilio" 
                                           name="domicilio" 
                                           value=""
                                           placeholder="Ej: Av. 25 de Mayo 123"
                                           required
                                           maxlength="200"
                                           title="Ingrese su dirección completa"
                                           <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingrese su domicilio.
                                </div>
                                <small class="form-text">Calle, número, piso, departamento (si corresponde)</small>
                            </div>
                            
                            <!-- Barrio -->
                            <div class="col-md-6 mb-3">
                                <label for="barrio_id" class="form-label">
                                    Barrio <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <select class="form-select" id="barrio_id" name="barrio_id" required <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                        <option value="" selected disabled>Seleccione su barrio...</option>
                                        <?php foreach ($barrios as $barrio): ?>
                                            <option value="<?= $barrio['id'] ?>">
                                                <?= htmlspecialchars($barrio['descripcion']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor seleccione su barrio.
                                </div>
                            </div>
                            
                            <!-- Nivel Educativo -->
                            <div class="col-md-6 mb-3">
                                <label for="nivel_educativo_id" class="form-label">
                                    Nivel Educativo Alcanzado <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                    <select class="form-select" id="nivel_educativo_id" name="nivel_educativo_id" required <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                        <option value="" selected disabled>Seleccione...</option>
                                        <?php foreach ($niveles as $nivel): ?>
                                            <option value="<?= $nivel['id'] ?>">
                                                <?= htmlspecialchars($nivel['descripcion']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor seleccione su nivel educativo.
                                </div>
                            </div>
                            
                            <!-- Ocupación -->
                            <div class="col-md-12 mb-3">
                                <label for="ocupacion_id" class="form-label">
                                    Ocupación Actual <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <select class="form-select" id="ocupacion_id" name="ocupacion_id" required <?php if ($esta_cerrado) echo 'disabled'; ?>>
                                        <option value="" selected disabled>Seleccione...</option>
                                        <?php foreach ($ocupaciones as $ocupacion): ?>
                                            <option value="<?= $ocupacion['id'] ?>">
                                                <?= htmlspecialchars($ocupacion['descripcion']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor seleccione su ocupación actual.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de Acción -->
                        <?php if (!$esta_cerrado): ?>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                Confirmar Inscripción
                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- Nota sobre campos obligatorios -->
                        <div class="text-center mt-3">
                            <?php if ($esta_cerrado): ?>
                                <p class="text-warning fw-bold">
                                    <i class="bi bi-exclamation-triangle"></i> Esta capacitación ya no acepta inscripciones
                                </p>
                            <?php else: ?>
                                <small style="color: var(--text-color);">* Campos obligatorios</small>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Incluir footer
include __DIR__ . '/../components/footer.php';
?>