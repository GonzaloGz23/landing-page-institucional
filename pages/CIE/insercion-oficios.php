<?php
// Configuración de la página CIE Inserción Laboral en Oficios
$page_title = 'Inserción Laboral en Oficios - CIE';
$body_class = 'bg-cie-insercion-oficios';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'insercion-oficios.php';

// CSS específicos para CIE Inserción Oficios
$page_css = [
    'pages/CIE-insercion-oficios.css'  // CSS específico para inserción oficios CIE
];

// JS específicos (opcional)
$page_js = [
    // 'insercion-oficios.js'  // Si necesitas JavaScript específico
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
                <img class="insercion-oficios-main-img" src="../../assets/img/CIE/prestaciones/main_insercion_laboral_oficios.png" alt="Inserción Laboral en Oficios CIE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                    <p class="content-text">
                        El área de <b>Inserción Laboral en Oficios</b> está dirigida a quienes ya se desempeñan en un oficio y quieren perfeccionar lo que hacen.
                    </p>
                    <p class="content-text">
                        Acá podés capacitarte para mejorar tus técnicas y profesionalizar tu trabajo en rubros como albañilería, electricidad, carpintería, pintura, gomería, refrigeración, servicios domésticos, jardinería y más.
                    </p>
                    <p class="content-text">
                        Además, contamos con la aplicación web <b>Oficios Formosa</b>, un directorio digital que reúne a los trabajadores en un solo lugar. Allí podés crear tu perfil, mostrar tu experiencia y facilitar que potenciales clientes te contacten directamente, mientras los usuarios pueden buscar y contratar servicios fácilmente.
                    </p>
                    <p class="content-text">
                        Es una herramienta clave para crecer dentro de tu oficio y conseguir más oportunidades.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CIE', 'insercion-oficios'); ?>" 
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