<?php
// Configuración de la página CE Atención y Respuestas Rápidas
$page_title = 'Atención y Respuestas Rápidas - CE';
$body_class = 'bg-ce-atencion';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'atencion.php';

// CSS específicos para CE Atención
$page_css = [
    'pages/CE-atencion.css'  // CSS específico para atención CE
];

// JS específicos (opcional)
$page_js = [
    // 'atencion.js'  // Si necesitas JavaScript específico
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
                <img class="atencion-main-img" src="../../assets/img/CE/prestaciones/main_asesoramiento_atencion.png" alt="Atención y Respuestas Rápidas CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                            Tu punto de inicio dentro de la Casa del Emprendedor.
                        </p>
                        <ul class="content-text">
                            <li>Respondemos tus consultas y te ofrecemos orientación personalizada.</li>
                            <li>Te guiamos hacia el programa o área que se adapte mejor a tus necesidades.</li>
                            <li>Acompañamos tanto a quienes recién empiezan como a quienes ya tienen un proyecto.</li>
                            <li>Te facilitamos el acceso a todos los recursos disponibles.</li>
                        </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'atencion'); ?>" 
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