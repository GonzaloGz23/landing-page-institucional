<?php
// Configuración de la página CIE Prestaciones
$page_title = 'Prestaciones CIE - Centro de Intermediación Laboral';
$body_class = 'bg-cie-prestaciones';
$page_level = 'cie';  // Nivel CIE para rutas correctas
$current_page = 'prestaciones.php';

// CSS específicos para CIE Prestaciones
$page_css = [
    'pages/CIE-prestaciones.css'  // CSS específico para prestaciones CIE
];

// JS específicos (opcional)
$page_js = [
    // 'prestaciones.js'  // Si necesitas JavaScript específico
];

// Incluir header
include '../../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        
        <!-- Primera row: Logo en solitario -->
        <div class="row">
            <div class="col-12">
                <img class="cie-prestaciones-img" src="../../assets/img/common/placeholder.svg" alt="Logo">
            </div>
        </div>

        <!-- Segunda row: Sección de Prestaciones -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="prestaciones-section">
                    <h2 class="section-label">Elegí la opción que más se adapte a tus necesidades:</h2>
                    <div class="row g-5">
                        <!-- Centro de admisión -->
                        <div class="col-12 col-md-6">
                            <a href="admision.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CIE/prestaciones/item_atencion_asesoramiento.png" alt="Centro de admisión">
                                </div>
                                <p class="service-description">Armá tu CV y sumate a nuestra base de datos de empleo</p>
                            </a>
                        </div>
                        
                        <!-- Mejora continua -->
                        <div class="col-12 col-md-6">
                            <a href="mejora-continua.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CIE/prestaciones/item_mejora_continua.png" alt="Mejora continua">
                                </div>
                                <p class="service-description">Fortalecé tus habilidades para crecer en el mundo laboral</p>
                            </a>
                        </div>
                        
                        <!-- Inserción laboral y formación profesional -->
                        <div class="col-12 col-md-6">
                            <a href="insercion-formacion.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CIE/prestaciones/item_insercion_laboral_profesional.png" alt="Inserción laboral y formación profesional">
                                </div>
                                <p class="service-description">Capacitate y preparate para incorporarte al mercado laboral</p>
                            </a>
                        </div>
                        
                        <!-- Inserción laboral en oficios -->
                        <!-- <div class="col-12 col-md-6">
                            <a href="insercion-oficios.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CIE/prestaciones/item_insercion_laboral_oficios.png" alt="Inserción laboral en oficios">
                                </div>
                                <p class="service-description">Conectá con clientes y aumentá tus oportunidades de trabajo</p>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Tercera row: Sección de Programas -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="programas-section">
                    <h2 class="section-label">También podés acceder a los siguientes programas:</h2>
                    <div class="row g-5">
                        <!-- Oficios Formosa -->
                        <!-- <div class="col-12 col-md-6">
                            <a href="oficios-formosa.php" class="service-item programa hover-service" data-bg="oficios-formosa">
                                <div class="service-content">
                                    <img src="../../assets/img/CIE/prestaciones/item_oficios_formosa.png" alt="Oficios Formosa">
                                </div>
                                <p class="service-description">Buscá oficios de confianza o publicitá el tuyo</p>
                            </a>
                        </div> -->
                        
                        <!-- Me formo para trabajar -->
                        <div class="col-12 col-md-6">
                            <a href="me-formo.php" class="service-item programa hover-service" data-bg="me-formo">
                                <div class="service-content">
                                    <img src="../../assets/img/CIE/prestaciones/item_me_formo_trabajar.png" alt="Me formo para trabajar">
                                </div>
                                <p class="service-description">Accedé a tu primera experiencia laboral</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
// Incluir footer
include '../../components/footer.php';
?>