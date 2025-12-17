<?php
/**
 * Componente Header - HEAD + Navegación
 * 
 * Variables esperadas:
 * - $page_title: Título de la página
 * - $body_class: Clase CSS para el body
 * - $page_level: Nivel de carpeta ('root', 'ce', 'cie')
 * - $current_page: Página actual para marcar en navegación
 * - $page_css: Array de archivos CSS específicos (opcional)
 */

// Definir constante de seguridad antes de cargar configuraciones
if (!defined('SECURE_ACCESS')) {
    define('SECURE_ACCESS', true);
}

// Cargar configuración
require_once __DIR__ . '/config/page_config.php';

// Inicializar configuración de página
$config = initPageConfig($page_level ?? 'root');
$assets_path = $config['assets_path'];
$home_path = $config['home_path'];
$nav_links = $config['nav_links'];

// Valores por defecto
$page_title = $page_title ?? 'Organismo Público';
$body_class = $body_class ?? 'bg-home';
$current_page = $current_page ?? '';
$page_css = $page_css ?? [];
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <?php
    // Google Analytics - Only load if tracking ID is configured
// Set GA_TRACKING_ID in your environment configuration
    $ga_tracking_id = ''; // TODO: Load from environment variable
    if (!empty($ga_tracking_id)):
        ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $ga_tracking_id ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());

            gtag('config', '<?= $ga_tracking_id ?>');
        </script>
    <?php endif; ?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $assets_path ?>img/favico/main.ico">
    <title><?= $page_title ?></title>

    <!-- CSS Globales -->
    <!-- Bootstrap CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"
        id="bootstrap-cdn">

    <!-- Bootstrap Icons desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        crossorigin="anonymous" id="bootstrap-icons-cdn">

    <!-- CSS Custom (siempre local) -->
    <link rel="stylesheet" href="<?= $assets_path ?>css/backgrounds.min.css">
    <link rel="stylesheet" href="<?= $assets_path ?>css/main.min.css">
    <link rel="stylesheet" href="<?= $assets_path ?>css/components.min.css">

    <!-- Fallback CSS - Se cargan si CDN falla -->
    <script>
        // Verificar si Bootstrap CSS se cargó desde CDN
        const checkBootstrapCSS = () => {
            let testEl = document.createElement('div');
            testEl.className = 'container-fluid';
            testEl.style.position = 'absolute';
            testEl.style.left = '-9999px';
            document.body.appendChild(testEl);

            let hasBootstrap = window.getComputedStyle(testEl).width !== 'auto';
            document.body.removeChild(testEl);

            if (!hasBootstrap) {
                console.warn('Bootstrap CDN falló, cargando versión local...');
                let fallbackCSS = document.createElement('link');
                fallbackCSS.rel = 'stylesheet';
                fallbackCSS.href = '<?= $assets_path ?>css/bootstrap.min.css';
                document.head.appendChild(fallbackCSS);
            }
        }

        // Verificar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', checkBootstrapCSS);
        } else {
            checkBootstrapCSS();
        }

        // Fallback para Bootstrap Icons
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                let iconTest = document.createElement('i');
                iconTest.className = 'bi bi-house';
                iconTest.style.position = 'absolute';
                iconTest.style.left = '-9999px';
                document.body.appendChild(iconTest);

                let hasIcons = window.getComputedStyle(iconTest, ':before').content !== 'none';
                document.body.removeChild(iconTest);

                if (!hasIcons) {
                    console.warn('Bootstrap Icons CDN falló, cargando versión local...');
                    let fallbackIcons = document.createElement('link');
                    fallbackIcons.rel = 'stylesheet';
                    fallbackIcons.href = '<?= $assets_path ?>css/bootstrap-icons.min.css';
                    document.head.appendChild(fallbackIcons);
                }
            }, 100);
        });
    </script>

    <!-- CSS Específicos de Página -->
    <?php if (!empty($page_css)): ?>
        <?php foreach ($page_css as $css_file): ?>
            <?php
            // Intentar cargar versión minificada si existe
            $min_css_file = str_replace('.css', '.min.css', $css_file);
            $min_css_path = __DIR__ . '/../assets/css/' . $min_css_file;

            // Si existe la versión minificada, usarla; sino, usar la original
            $css_to_load = file_exists($min_css_path) ? $min_css_file : $css_file;
            ?>
            <link rel="stylesheet" href="<?= $assets_path ?>css/<?= $css_to_load ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- SweetAlert2 CSS desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos personalizados para SweetAlert2 -->
    <style>
        .inscripcion-swal-popup {
            font-family: inherit;
        }

        .inscripcion-swal-title {
            color: #013453 !important;
            font-weight: 600;
        }

        .inscripcion-swal-confirm {
            background-color: #013453 !important;
            border: none !important;
            padding: 10px 24px !important;
            font-weight: 500;
        }

        .inscripcion-swal-confirm:hover {
            background-color: #1f6891 !important;
        }

        .inscripcion-swal-cancel {
            background-color: #7e2752 !important;
            border: none !important;
            padding: 10px 24px !important;
            font-weight: 500;
        }

        .inscripcion-swal-cancel:hover {
            background-color: #9d3068 !important;
        }
    </style>
</head>

<body class="<?= $body_class ?>">
    <!-- Navegación -->
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Logo/imagen como enlace -->
            <a class="navbar-brand" href="#">
                <img src="<?= $assets_path ?>img/common/placeholder.svg" alt="Logo" style="max-height: 40px;">
            </a>

            <!-- Menú desktop (oculto en móviles) -->
            <ul class="nav justify-content-end d-none d-lg-flex">
                <?php foreach ($nav_links as $url => $title): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page === $url) ? 'active' : '' ?>" <?= ($current_page === $url) ? 'aria-current="page"' : '' ?> href="<?= $url ?>"><?= $title ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Botón hamburguesa (visible solo en móviles) -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </nav>

    <!-- Offcanvas para móviles -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menú</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <?php foreach ($nav_links as $url => $title): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page === $url) ? 'active' : '' ?>" <?= ($current_page === $url) ? 'aria-current="page"' : '' ?> href="<?= $url ?>"><?= $title ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>