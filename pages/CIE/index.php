<!-- Descripción de la casa del emprendedor + botón de "ver todas las prestaciones" -->
<?php
// Configuración de la página CE
$page_title = 'CIE - Organismo Público';
$body_class = 'bg-cie-home';
$page_level = 'cie';  // Nivel CE para rutas correctas
$current_page = 'index.php';

// CSS específicos para CE
$page_css = [
    'pages/CIE-index.css'  // CSS específico para CIE principal
];

// Incluir header
include '../../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        <div class="row">
            <img class="cie-img" src="../../assets/img/common/placeholder.svg" alt="Logo">
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="container letter-white cie-main-text">
                    <p>El <b>CIE</b>  es un espacio pensado para vos si estás buscando trabajo, querés mejorar tus habilidades o sumar experiencia.</p>
                    <p>Desde tu primera visita vas a recibir orientación personalizada para definir el mejor camino de formación y vinculación laboral.</p>
                    <p>Podés acceder a capacitaciones en oficios manuales, digitales y tecnológicos, además de talleres de habilidades blandas que fortalecen tu perfil. También vas a encontrar pasantías y entrenamientos laborales que te acercan al mundo del trabajo real, y apoyo para armar o mejorar tu currículum y conectarte con empresas que buscan nuevos perfiles.</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a role="button" href="prestaciones.php" class="btn-cie-allservices btn btn-primary btn-lg">
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