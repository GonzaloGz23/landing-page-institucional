<?php
// Configuración de la página CE
$page_title = 'Casa del Emprendedor - Organismo Público';
$body_class = 'bg-ce-home';
$page_level = 'ce';  // Nivel CE para rutas correctas
$current_page = 'index.php';

// CSS específicos para CE
$page_css = [
    'pages/CE-index.css'  // CSS específico para CE principal
];

// Incluir header
include '../../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        <div class="row">
            <img class="ce-img" src="../../assets/img/common/placeholder.svg" alt="Logo">
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="container letter-white ce-main-text">
                    <p>Si tenés una idea y querés transformarla en un proyecto, o si ya estás emprendiendo y buscás crecer, la <b>Casa del Emprendedor</b> es tu lugar.</p>
                    <p>Acá vas a encontrar equipos preparados para acompañarte en cada etapa: desde la orientación inicial, la formación y el asesoramiento, hasta la comercialización, el marketing y el acceso a programas que te ayudan a fortalecer tu emprendimiento.</p>
                    <p>Todo en un solo espacio, pensado para que puedas emprender con más herramientas, más apoyo y más oportunidades.</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a role="button" href="prestaciones.php" class="btn-ce-allservices btn btn-primary btn-lg">
                    Ver todas las prestaciones
                </a>
            </div>
        </div>
    </div>
</main>

<?php
// Incluir footer
include '../../components/footer.php';
?>