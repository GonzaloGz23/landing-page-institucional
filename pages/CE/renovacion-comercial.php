<?php
// Configuración de la página CE Renovación Comercial
$page_title = 'Renovación Comercial - CE';
$body_class = 'bg-ce-renovacion-comercial';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'renovacion-comercial.php';

// CSS específicos para CE Renovación Comercial
$page_css = [
    'pages/CE-renovacion-comercial.css'  // CSS específico para renovación comercial CE
];

// JS específicos (opcional)
$page_js = [
    // 'renovacion-comercial.js'  // Si necesitas JavaScript específico
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
                <img class="renovacion-comercial-main-img" src="../../assets/img/CE/prestaciones/main_renovacion_comercial.png" alt="Renovación Comercial CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Actualizá y fortalecé tu negocio para llegar a nuevos públicos.<br>
                            • Te brindamos talleres, asesoramiento y herramientas digitales.<br>
                            • Te ayudamos a optimizar procesos e innovar en tu propuesta.<br>
                            • Te acompañamos si ya tenés un producto/servicio y buscás un cambio.<br>
                            • Te damos estrategias para aumentar ventas y diferenciarte en el mercado.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'renovacion-comercial'); ?>" 
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