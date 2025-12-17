<?php
// Configuración de la página CIE Mejora Continua
$page_title = 'Mejora Continua - CIE';
$body_class = 'bg-cie-mejora-continua';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'mejora-continua.php';

// CSS específicos para CIE Mejora Continua
$page_css = [
    'pages/CIE-mejora-continua.css'  // CSS específico para mejora continua CIE
];

// JS específicos (opcional)
$page_js = [
    // 'mejora-continua.js'  // Si necesitas JavaScript específico
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
                <img class="mejora-continua-main-img" src="../../assets/img/CIE/prestaciones/main_mejora_continua.png" alt="Mejora Continua CIE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                              Formación diseñada para fortalecer las habilidades blandas de los equipos de emprendedores y empresas.
                          </p>
                          <ul class="content-text">
                                <li>Te ayudamos a mejorar la comunicación, el trabajo en equipo y el liderazgo de tu personal.</li>
                                <li>Capacitamos a tus colaboradores para fortalecer responsabilidad y organización.</li>
                                <li>Colaboramos en la construcción de equipos más adaptables y preparados para nuevos desafíos.</li>
                                <li>Brindamos herramientas prácticas que impulsan el desempeño diario.</li>
                                <li>Acompañamos a negocios en crecimiento y empresas que buscan profesionalizar su estructura interna.</li>
                          </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CIE', 'mejora-continua'); ?>" 
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