<?php
// Configuración de la página principal
$page_title = 'Organismo Público | 2025';
$body_class = 'bg-home';
$page_level = 'root';
$current_page = 'index.php';

// Sin CSS específicos para la página principal
$page_css = [];

// Incluir header
include '../components/header.php';
?>

    <!-- Main content area -->
    <main class="container-fluid letter-white">
        <h1 class="text-center mt-5 fw-bold">Bienvenido/a a nuestra web</h1>
        <div class="fw-semibold">
            <p class="text-center mt-3 mb-1 fst-italic">En el organismo acompañamos tu crecimiento laboral y emprendedor.</p>
            <p class="text-center mt-1 mb-3">Encontrá capacitaciones y asesoramiento para conseguir empleo o potenciar tu emprendimiento.</p>
        </div>
        <h2 class="h3 text-center fw-bold mt-3">¿En qué podemos ayudarte?</h2>
        <section class="container mb-5">
            <div class="row">
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div role="button" class="main-button d-flex align-items-center p-3 CIE hover-subtle">
                        <a class="text-decoration-none" href="CIE/index.php">
                            <div class="row">
                                <div class="col">
                                            <img class="main-button_img" src="../assets/img/common/placeholder.svg" alt="Logo">
                                </div>
                                <div class="col-12 mt-2 text-center">
                                    <label class="letter-white fw-bold">Capacitate, mejorá tu CV, y encontrá tu próximo empleo.</label>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div role="button" class="main-button d-flex align-items-center CE p-3 hover-subtle">
                        <a class="text-decoration-none" href="CE/index.php">
                            <div class="row">
                                <div class="col">
                                    <img class="main-button_img" src="../assets/img/common/placeholder.svg" alt="Logo">
                                </div>
                                <div class="col-12 mt-2 text-center">
                                    <label class="letter-white fw-bold">Si querés emprender o escalar tu negocio, este es tu lugar.</label>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="container mt-5">
            <div class="col-12">
                <div class="row d-flex justify-content-center mx-2">
                    <div class="more-courses d-flex justify-content-center hover-subtle" role="button">
                        <a class="text-decoration-none m-0 letter-white h3 fst-italic fw-bold" href="#" rel="noopener noreferrer">Ir a cursos disponibles</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
// Incluir footer
include '../components/footer.php';
?>