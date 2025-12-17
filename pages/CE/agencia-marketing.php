<?php
// Configuración de la página CE Agencia de Marketing
$page_title = 'Agencia de Marketing - CE';
$body_class = 'bg-ce-agencia-marketing';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'agencia-marketing.php';

// CSS específicos para CE Agencia de Marketing
$page_css = [
    'pages/CE-agencia-marketing.css'  // CSS específico para agencia marketing CE
];

// JS específicos (opcional)
$page_js = [
    // 'agencia-marketing.js'  // Si necesitas JavaScript específico
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
                <img class="agencia-marketing-main-img" src="../../assets/img/CE/prestaciones/main_agencia_marketing.png" alt="Agencia de Marketing CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                            Te ayudamos a posicionar y dar visibilidad a tu emprendimiento.
                        </p>
                        <ul class="content-text">
                            <li>Te asesoramos en redes sociales, identidad de marca, diseño y comunicación.</li>
                            <li>Trabajamos para que tu proyecto destaque ante el público adecuado.</li>
                            <li>Te asistimos tanto para comenzar como para profesionalizar tu comunicación.</li>
                            <li>Te brindamos herramientas concretas para difundir y hacer crecer tu presencia.</li>
                        </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'agencia-marketing'); ?>" 
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