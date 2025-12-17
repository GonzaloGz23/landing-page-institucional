<?php
// Configuración de la página Quienes Somos
$page_title = 'Quienes Somos - Organismo Público';
$body_class = 'bg-quienes-somos';
$page_level = 'root';
$current_page = 'quienes-somos.php';

// CSS específicos para esta página
$page_css = [
    'pages/quienes-somos.css'  // Se cargará desde assets/css/pages/quienes-somos.css
];

// Incluir header
include '../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        
        <!-- Título principal -->
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <h1 class="h2 mb-4">¿Quienes somos?</h1>
                
                <!-- Contenido -->
                <div class="content-section">
                    <p class="content-text fw-bold">
                        Somos un organismo público que trabaja para generar más y mejores oportunidades laborales para todas las personas.
                    </p>
                    <p class="content-text fw-bold">
                        Desde el organismo diseñamos y llevamos adelante políticas públicas orientadas a fortalecer las capacidades de los trabajadores, acompañar a quienes buscan empleo y potenciar tanto el sector público como el privado.
                    </p>
                    <p class="content-text fw-bold">
                        Lo hacemos con una mirada integral, que combina el conocimiento del mercado laboral, la implementación de políticas activas de empleo y la oferta de formación profesional gratuita y de calidad.
                    </p>
                </div>
                
                <!-- Botón centrado -->
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary btn-lg">
                        Ir al inicio
                    </a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
// Incluir footer
include '../components/footer.php';
?>