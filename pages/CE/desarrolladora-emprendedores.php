<?php
// Configuración de la página CE Desarrolladora de Emprendedores
$page_title = 'Desarrolladora de Emprendedores - CE';
$body_class = 'bg-ce-desarrolladora-emprendedores';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'desarrolladora-emprendedores.php';

// CSS específicos para CE Desarrolladora de Emprendedores
$page_css = [
    'pages/CE-desarrolladora-emprendedores.css'  // CSS específico para desarrolladora emprendedores CE
];

// JS específicos (opcional)
$page_js = [
    // 'desarrolladora-emprendedores.js'  // Si necesitas JavaScript específico
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
                <img class="desarrolladora-emprendedores-main-img" src="../../assets/img/CE/prestaciones/main_desarrolladora_emprendedores.png" alt="Desarrolladora de Emprendedores CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Acompañamiento estratégico para impulsar o profesionalizar tu proyecto.<br>
                            • Te brindamos mentorías, capacitaciones y asesoramiento personalizado.<br>
                            • Te ayudamos a convertir una idea en un emprendimiento real.<br>
                            • Optimización de procesos, gestión y proyección hacia nuevos mercados.<br>
                            • Te damos herramientas concretas para consolidar un emprendimiento sólido.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'desarrolladora-emprendedores'); ?>" 
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