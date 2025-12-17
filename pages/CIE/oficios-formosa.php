<?php
// Configuración de la página CIE Oficios Formosa
$page_title = 'Oficios Formosa - CIE';
$body_class = 'bg-cie-oficios-formosa';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'oficios-formosa.php';

// CSS específicos para CIE Oficios Formosa
$page_css = [
    'pages/CIE-oficios-formosa.css'
];

// JS específicos (opcional)
$page_js = [
    // 'oficios-formosa.js'  // Si necesitas JavaScript específico
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
                <img class="oficios-formosa-main-img" src="../../assets/img/CIE/prestaciones/main_oficios_formosa.png" alt="Oficios Formosa CIE">
            </div>
        </div>

        <!-- Segunda fila: Contenido principal dividido en dos columnas -->
        <div class="row">
            <!-- Columna izquierda: Contenido de texto -->
            <div class="col-12 col-lg-8">
                <div class="content-section letter-white">
                    <p class="content-text">
                        <b>¿Tenés un oficio y querés darlo a conocer para conseguir más clientes?</b>
                    </p>
                    <p class="content-text">
                        <b>¿Necesitás un servicio a domicilio y no sabés dónde buscarlo?</b>
                    </p>
                    <p class="content-text">
                        Con <b>Oficios Formosa</b> podés registrarte gratis y mostrar tus trabajos con fotos y datos de contacto, llegando a más personas que necesitan lo que hacés.
                    </p>
                     <p class="content-text">
                        Si buscás un servicio, entrás al directorio, elegís el rubro y accedés directamente al WhatsApp del trabajador para coordinar.
                    </p>
                     <p class="content-text">
                       Todo en un mismo lugar, práctico, rápido y accesible desde el celular o la computadora.
                    </p>
                </div>
            </div>
            
            <!-- Columna derecha: Código QR -->
            <div class="col-12 col-lg-4">
                <div class="qr-section text-center">
                    <div class="qr-container">
                        <img src="../../assets/img/qr/oficios.png" 
                             alt="Código QR Oficios Formosa" 
                             class="qr-code-img">
                        <p class="qr-text">
                            Escaneá el QR<br>para descargar la app
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botones de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <!-- <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mb-4">
                        <a href="https://cutt.ly/Mr1PSK77"  target="_blank" class="btn btn-primary btn-access-service">
                            Llevame a la App
                        </a>
                        <a href="https://cutt.ly/ir1PAsKC"  target="_blank" class="btn btn-secondary btn-access-service">
                            Ver tutoriales
                        </a>
                    </div> -->
                    <p class="contact-info">
                        <b>¿Dudas? Comunicate con nuestro equipo al 
                        <a href="<?php echo generateWhatsAppLink('CIE', 'oficios-formosa'); ?>" 
                           class="whatsapp-link"
                           target="_blank"
                           rel="noopener noreferrer">
                           <i class="bi bi-whatsapp"></i> 3704027762</a></b>
                    </p>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
// Incluir footer
include '../../components/footer.php';
?>