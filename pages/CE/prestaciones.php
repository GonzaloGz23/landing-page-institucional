<?php
// Configuración de la página CE Prestaciones
$page_title = 'Prestaciones CE - Casa del Emprendedor';
$body_class = 'bg-ce-prestaciones';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'prestaciones.php';

// CSS específicos para CE Prestaciones
$page_css = [
    'pages/CE-prestaciones.css'  // CSS específico para prestaciones CE
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
                <img class="ce-prestaciones-img" src="../../assets/img/common/placeholder.svg" alt="Logo">
            </div>
        </div>

        <!-- Segunda row: Sección de Prestaciones -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="prestaciones-section">
                    <h2 class="section-label">Elegí la opción que más se adapte a tus necesidades:</h2>
                    <div class="row g-5">
                        <!-- Asesoramiento y atención -->
                        <div class="col-12 col-md-6">
                            <a href="atencion.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_asesoramiento_atencion.png" alt="Asesoramiento y atención">
                                </div>
                                <p class="service-description">Resolvé tus consultas y recibí orientación inmediata</p>
                            </a>
                        </div>
                        
                        <!-- Punto emprendedor -->
                        <div class="col-12 col-md-6">
                            <a href="punto-emprendedor.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_punto_emprendedor.png" alt="Punto emprendedor">
                                </div>
                                <p class="service-description">Accedé a beneficios y acompañamiento para crecer</p>
                            </a>
                        </div>
                        
                        <!-- Laboratorio de emprendedores -->
                        <div class="col-12 col-md-6">
                            <a href="laboratorio-emprendedor.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_laboratorio_emprendedores.png" alt="Laboratorio de emprendedores">
                                </div>
                                <p class="service-description">Transformá tus ideas en proyectos reales</p>
                            </a>
                        </div>
                        
                        <!-- Agencia de marketing -->
                        <div class="col-12 col-md-6">
                            <a href="agencia-marketing.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_agencia_marketing.png" alt="Agencia de marketing">
                                </div>
                                <p class="service-description">Aprendé a posicionar tu emprendimiento y atraer clientes</p>
                            </a>
                        </div>
                        
                        <!-- Formación para emprendedores -->
                        <div class="col-12 col-md-6">
                            <a href="formacion-emprendedores.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_formacion_emprendedores.png" alt="Formación para emprendedores">
                                </div>
                                <p class="service-description">Capacitate y adquirí nuevas herramientas para tu negocio</p>
                            </a>
                        </div>
                        
                        <!-- Capital financiero y fortalecimiento emprendedor -->
                        <div class="col-12 col-md-6">
                            <a href="capital-fortalecimiento.php" class="service-item prestacion hover-service">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_capital_fortalecimiento_emprendedor.png" alt="Capital financiero y fortalecimiento emprendedor">
                                </div>
                                <p class="service-description">Solicitá créditos y recursos para potenciar tu emprendimiento</p>
                            </a>
                        </div>
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
                        <!-- Desarrolladora de emprendedores -->
                        <div class="col-12 col-md-6">
                            <a href="desarrolladora-emprendedores.php" class="service-item programa hover-service" data-bg="desarrolladora">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_desarrolladora_emprendedores.png" alt="Desarrolladora de emprendedores">
                                </div>
                                <p class="service-description">Escalá tu emprendimiento con mentorías y asesoramiento</p>
                            </a>
                        </div>
                        
                        <!-- Renovación comercial -->
                        <div class="col-12 col-md-6">
                            <a href="renovacion-comercial.php" class="service-item programa hover-service" data-bg="renovacion">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_renovacion_comercial.png" alt="Renovación comercial">
                                </div>
                                <p class="service-description">Rediseñá tus procesos y productos con nuevas ideas</p>
                            </a>
                        </div>
                        
                        <!-- Mercado comunitario -->
                        <div class="col-12 col-md-6">
                            <a href="mercado-comunitario.php" class="service-item programa hover-service" data-bg="mercado">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_mercado_comunitario.png" alt="Mercado comunitario">
                                </div>
                                <p class="service-description">Ofrecé tus productos en espacios de venta y ferias</p>
                            </a>
                        </div>
                        
                        <!-- Conexión comercial -->
                        <div class="col-12 col-md-6">
                            <a href="conexion-comercial.php" class="service-item programa hover-service" data-bg="conexion">
                                <div class="service-content">
                                    <img src="../../assets/img/CE/prestaciones/item_conexion_comercial.png" alt="Conexión comercial">
                                </div>
                                <p class="service-description">Conectá con empresas locales y conviertete en proveedor</p>
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
