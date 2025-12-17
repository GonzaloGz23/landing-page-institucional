<?php
// Configuración de la página CE Laboratorio de Emprendedores
$page_title = 'Laboratorio de Emprendedores - CE';
$body_class = 'bg-ce-laboratorio-emprendedor';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'laboratorio-emprendedor.php';

// CSS específicos para CE Laboratorio de Emprendedores
$page_css = [
    'pages/CE-laboratorio-emprendedor.css'  // CSS específico para laboratorio emprendedor CE
];

// JS específicos (opcional)
$page_js = [
    // 'laboratorio-emprendedor.js'  // Si necesitas JavaScript específico
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
                <img class="laboratorio-emprendedor-main-img" src="../../assets/img/CE/prestaciones/main_laboratorio_emprendedores.png" alt="Laboratorio de Emprendedores CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                            Donde tus ideas se convierten en proyectos concretos.
                        </p>
                        <ul class="content-text">
                            <li>Te ayudamos a diseñar, validar y mejorar tus propuestas con metodologías ágiles.</li>
                            <li>Te acompañamos a transformar tus ideas en emprendimientos con valor de mercado.</li>
                            <li>Te integramos a programas como:
                                <ul>
                                    <li>Conexión Comercial</li>
                                    <li>Desarrolladora de Emprendedores</li>
                                    <li>Renovación Comercial</li>
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'laboratorio-emprendedor'); ?>" 
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