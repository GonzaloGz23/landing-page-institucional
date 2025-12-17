<?php
// Configuración de la página CE Punto Emprendedor
$page_title = 'Punto Emprendedor - CE';
$body_class = 'bg-ce-punto-emprendedor';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'punto-emprendedor.php';

// CSS específicos para CE Punto Emprendedor
$page_css = [
    'pages/CE-punto-emprendedor.css'  // CSS específico para punto emprendedor CE
];

// JS específicos (opcional)
$page_js = [
    // 'punto-emprendedor.js'  // Si necesitas JavaScript específico
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
                <img class="punto-emprendedor-main-img" src="../../assets/img/CE/prestaciones/main_punto_emprendedor.png" alt="Punto Emprendedor CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                   <p class="content-text">
                              Acompañamiento integral durante todo tu camino emprendedor.
                          </p>
                          <ul class="content-text">
                                <li>Te brindamos asistencia, recursos y beneficios para vos y tu proyecto.</li>
                                <li>Te ofrecemos descuentos en comercios, farmacias, gimnasios y espacios recreativos.</li>
                                <li>Te guiamos en tus primeros pasos si estás empezando.</li>
                                <li>Te asesoramos para seguir creciendo si ya estás emprendiendo.</li>
                                <li>Creamos un espacio de comunidad, encuentro y acompañamiento continuo.</li>
                          </ul>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'punto-emprendedor'); ?>" 
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