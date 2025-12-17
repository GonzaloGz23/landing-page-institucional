<?php
// Configuración de la página CIE Inserción Laboral y Formación Profesional
$page_title = 'Inserción Laboral y Formación Profesional - CIE';
$body_class = 'bg-cie-insercion-formacion';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'insercion-formacion.php';

// CSS específicos para CIE Inserción Formación
$page_css = [
    'pages/CIE-insercion-formacion.css'  // CSS específico para inserción formación CIE
];

// JS específicos (opcional)
$page_js = [
    // 'insercion-formacion.js'  // Si necesitas JavaScript específico
];

// Definir constante de seguridad
define('SECURE_ACCESS', true);

// Incluir configuración de WhatsApp
include '../../components/config/whatsapp_config.php';

// Incluir header
include '../../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        
        <!-- Primera fila: Imagen principal -->
        <div class="row">
            <div class="col-12">
                <img class="insercion-formacion-main-img" src="../../assets/img/CIE/prestaciones/main_insercion_laboral_profesional.png" alt="Inserción Laboral y Formación Profesional CIE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                           Acompañamos tu ingreso al mundo laboral.
                        </p>
                        <ul class="content-text">
                            <li>Te inscribimos en cursos y programas como Me Formo para Trabajar.</li>
                            <li>Te brindamos capacitación y experiencia real en ámbitos laborales.</li>
                            <li>Presentamos tu CV ante empresas que buscan personal.</li>
                            <li>Te vinculamos con entrenamientos laborales para sumar práctica.</li>
                            <li>Te ayudamos a adquirir conocimientos técnicos, habilidades y confianza.</li>
                        </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CIE', 'insercion-formacion'); ?>" 
                       class="btn btn-primary btn-access-service"
                       target="_blank"
                       rel="noopener noreferrer">
                        Quiero acceder a esta prestación
                    </a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
// Incluir footer
include '../../components/footer.php';
?>