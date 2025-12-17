<?php
// Configuración de la página
$page_title = 'Contacto - Organismo Público';
$body_class = 'bg-contacto';
$page_level = 'root';
$current_page = 'contacto.php';

// CSS específicos para esta página
$page_css = [
    'pages/contacto.css'  // Se cargará desde assets/css/pages/contacto.css
];

// Incluir header
include '../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        
        <!-- Título -->
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <h1 class="h2 mb-4">Contacto</h1>
                
                <!-- Texto de teléfonos -->
                <p class="contact-text text-center">
                    <strong><em>Visitá nuestras oficinas o escribinos:</em></strong>
                </p>
                
                <!-- Contenedores de oficinas -->
                <div class="offices-container">
                        <!-- Oficina Central -->
                            <div class="office-card custom-office-card">
                                <div class="office-name">Oficina Central</div>
                                <div class="office-address">(Dirección disponible a solicitud)</div>
                                <div class="office-phone">(00) 0000-0000</div>
                            </div>
                        <!-- Casa del Emprendedor -->
                        <div class="office-card custom-office-card">
                            <div class="office-name">Centro de Apoyo</div>
                            <div class="office-address">(Dirección disponible a solicitud)</div>
                            <div class="office-phone">(00) 0000-0000</div>
                        </div>
                        <!-- Centro Integral para la Empleabilidad -->
                        <div class="office-card custom-office-card">
                            <div class="office-name">Centro de Servicios</div>
                            <div class="office-address">(Dirección disponible a solicitud)</div>
                            <div class="office-phone">(00) 0000-0000</div>
                        </div>
                </div>
                
            </div>
        </div>

    </div>
</main>

<?php
// Incluir footer
include '../components/footer.php';
?>