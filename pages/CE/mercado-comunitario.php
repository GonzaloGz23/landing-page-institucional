<?php
// Configuración de la página CE Mercado Comunitario Emprendedores
$page_title = 'Mercado Comunitario Emprendedores - CE';
$body_class = 'bg-ce-mercado-comunitario';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'mercado-comunitario.php';

// CSS específicos para CE Mercado Comunitario Emprendedores
$page_css = [
    'pages/CE-mercado-comunitario.css'  // CSS específico para mercado comunitario CE
];

// JS específicos (opcional)
$page_js = [
    // 'mercado-comunitario.js'  // Si necesitas JavaScript específico
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
                <img class="mercado-comunitario-main-img" src="../../assets/img/CE/prestaciones/main_mercado_comunitario.png" alt="Mercado Comunitario Emprendedores CE">
            </div>
        </div>

        <!-- Segunda fila: Cuerpo del texto -->
        <div class="row">
            <div class="col-12">
                <div class="content-section letter-white">
                        <p class="content-text">
                            Un espacio para mostrar, vender y validar tu producto.<br>
                            • Te invitamos a participar de ferias y espacios de venta.<br>
                            • Te ayudamos a conectar con compradores y otros emprendedores.<br>
                            • Te acompañamos a probar precios, recibir devoluciones y mejorar tu oferta.<br>
                            • Te damos visibilidad en el mercado local y nuevas oportunidades de crecimiento.
                        </p>
                </div>
            </div>
        </div>

        <!-- Tercera fila: Botón de acceso -->
        <div class="row">
            <div class="col-12">
                <div class="button-container">
                    <a href="<?php echo generateWhatsAppLink('CE', 'mercado-comunitario'); ?>" 
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

<?php
// Incluir footer
include '../../components/footer.php';
?>