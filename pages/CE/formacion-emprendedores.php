<?php
// Configuración de la página CE Formación para Emprendedores
$page_title = 'Formación para Emprendedores - CE';
$body_class = 'bg-ce-formacion-emprendedores';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'formacion-emprendedores.php';

// CSS específicos para CE Formación para Emprendedores
$page_css = [
    'pages/CE-formacion-emprendedores.css'  // CSS específico para formación emprendedores CE
];

// JS específicos (opcional)
$page_js = [
    // 'formacion-emprendedores.js'  // Si necesitas JavaScript específico
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
                <img class="formacion-emprendedores-main-img" src="../../assets/img/CE/prestaciones/main_formacion_emprendedores.png" alt="Formación para Emprendedores CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Herramientas clave para impulsar y fortalecer tu proyecto.<br>
                            • Te capacitamos en gestión digital, ventas online, diseño, logística y organización.<br>
                            • Te ayudamos a desarrollar habilidades prácticas para tu emprendimiento diario.<br>
                            • Acompañamos tanto a quienes están empezando como a quienes buscan profesionalizarse.<br>
                            • Te damos contenidos y recursos para mejorar procesos y potenciar resultados.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'formacion-emprendedores'); ?>" 
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