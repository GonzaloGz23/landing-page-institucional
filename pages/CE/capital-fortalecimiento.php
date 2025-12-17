<?php
// Configuración de la página CE Capital y Fortalecimiento Emprendedor
$page_title = 'Capital y Fortalecimiento Emprendedor - CE';
$body_class = 'bg-ce-capital-fortalecimiento';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'capital-fortalecimiento.php';

// CSS específicos para CE Capital y Fortalecimiento Emprendedor
$page_css = [
    'pages/CE-capital-fortalecimiento.css'  // CSS específico para capital y fortalecimiento CE
];

// JS específicos (opcional)
$page_js = [
    // 'capital-fortalecimiento.js'  // Si necesitas JavaScript específico
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
                <img class="capital-fortalecimiento-main-img" src="../../assets/img/CE/prestaciones/main_capital_fortalecimiento_emprendedor.png" alt="Capital y Fortalecimiento Emprendedor CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Apoyo financiero y material para seguir creciendo.<br>
                            • Te acompañamos en la gestión de créditos, subsidios y préstamos de equipamiento.<br>
                            • Te facilitamos acceso a recursos concretos para mejorar tu negocio.<br>
                            • Te asistimos si necesitás dar un salto de calidad en tu proyecto.<br>
                            • Te brindamos medios y oportunidades para crecer con respaldo permanente.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'capital-fortalecimiento'); ?>" 
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