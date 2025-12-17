<?php
// Configuración de la página CIE Admisión
$page_title = 'Centro de Admisión - CIE';
$body_class = 'bg-cie-admision';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'admision.php';

// CSS específicos para CIE Admisión
$page_css = [
    'pages/CIE-admision.css'  // CSS específico para admisión CIE
];

// JS específicos (opcional)
$page_js = [
    // 'admision.js'  // Si necesitas JavaScript específico
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
                <img class="admision-main-img" src="../../assets/img/CIE/prestaciones/main_atencion_asesoramiento.png" alt="Centro de Admisión CIE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                            Tu primer paso dentro del Centro Integral para la Empleabilidad.
                        </p>
                        <ul class="content-text">
                            <li>Te ayudamos a armar tu CV de manera gratuita.</li>
                            <li>Actualizamos tu CV según lo que hoy buscan las empresas.</li>
                            <li>Te incorporamos a la base de datos de la Subsecretaría.</li>
                            <li>Te dejamos disponible para futuras búsquedas laborales.</li>
                            <li>Te acompañamos a aumentar tus oportunidades de empleo.</li>
                        </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CIE', 'admision'); ?>" 
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