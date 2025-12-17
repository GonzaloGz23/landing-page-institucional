<?php
// Configuración de la página CE Conexión Comercial
$page_title = 'Conexión Comercial - CE';
$body_class = 'bg-ce-conexion-comercial';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'conexion-comercial.php';

// CSS específicos para CE Conexión Comercial
$page_css = [
    'pages/CE-conexion-comercial.css'  // CSS específico para conexión comercial CE
];

// JS específicos (opcional)
$page_js = [
    // 'conexion-comercial.js'  // Si necesitas JavaScript específico
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
                <img class="conexion-comercial-main-img" src="../../assets/img/CE/prestaciones/main_conexion_comercial.png" alt="Conexión Comercial CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Vinculación directa con empresas e instituciones.<br>
                            • Te acercamos a rondas de negocios y encuentros comerciales.<br>
                            • Te acompañamos a presentar tu oferta y negociar acuerdos.<br>
                            • Te ayudamos a convertirte en proveedor y ampliar tu red de clientes.<br>
                            • Te damos oportunidades para aumentar ventas y fortalecer tu presencia en la provincia.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'conexion-comercial'); ?>" 
                       class="btn btn-primary btn-access-service"
                       target="_blank"
                       rel="noopener noreferrer">
                        Quiero acceder a este programa
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