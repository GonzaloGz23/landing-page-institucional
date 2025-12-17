/**
 * Main JavaScript - NewLandingPage
 * Funcionalidades generales del sitio
 */

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // DEBUG: Verificar carga de Bootstrap
    // ============================================
    if (typeof bootstrap === 'undefined') {
        //console.error('❌ Bootstrap NO está cargado!');
        return;
    }

    // ============================================
    // FIX CRÍTICO: Offcanvas - Navegación en móviles
    // ============================================

    const offcanvasElement = document.getElementById('offcanvasNavbar');

    if (!offcanvasElement) {
        console.warn('⚠️ Elemento offcanvas no encontrado');
        return;
    }

    // Obtener todos los enlaces dentro del offcanvas
    const offcanvasLinks = offcanvasElement.querySelectorAll('a[href]');

    // SOLUCIÓN: Remover data-bs-dismiss y manejar manualmente
    offcanvasLinks.forEach((link, index) => {

        // Agregar evento de clic
        link.addEventListener('click', function (event) {

            // Obtener o crear instancia del offcanvas
            let offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement);

            if (!offcanvasInstance) {
                offcanvasInstance = new bootstrap.Offcanvas(offcanvasElement);
            }

            // Cerrar el offcanvas
            offcanvasInstance.hide();

            // La navegación ocurrirá automáticamente porque no hacemos preventDefault
        });
    });
});