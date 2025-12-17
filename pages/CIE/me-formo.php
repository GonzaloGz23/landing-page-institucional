<?php
// Configuración de la página CIE Me Formo para Trabajar
$page_title = 'Me Formo para Trabajar - CIE';
$body_class = 'bg-cie-me-formo';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'me-formo.php';

// CSS específicos para CIE Me Formo
$page_css = [
    'pages/CIE-me-formo.css'  // CSS específico para me formo CIE
];

// JS específicos (opcional)
$page_js = [
    // 'me-formo.js'  // Si necesitas JavaScript específico
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
                <img class="me-formo-main-img" src="../../assets/img/CIE/prestaciones/main_me_formo_trabajar.png" alt="Me Formo para Trabajar CIE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Tu primera experiencia laboral en un entorno real.<br>
                            • Te vinculamos con entrenamientos laborales en empresas locales.<br>
                            • Te ayudamos a desarrollar habilidades prácticas para tu currículum.<br>
                            • Te acompañamos en tus primeros pasos si todavía no tenés experiencia.<br>
                            • Te abrimos oportunidades para crecer, ganar confianza y avanzar en el mundo laboral.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
       <!--  <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CIE', 'me-formo'); ?>" 
                       class="btn btn-primary btn-access-service"
                       target="_blank"
                       rel="noopener noreferrer">
                        Quiero acceder a este programa
                    </a>
                </div>
            </div>
        </div> -->

    </div>
</main>

<?php
// Incluir footer
include '../../components/footer.php';
?>