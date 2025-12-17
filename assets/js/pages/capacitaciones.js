/**
 * Módulo de búsqueda en tiempo real para capacitaciones
 */

// Búsqueda en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const inputBusqueda = document.getElementById('busqueda');
    const seccionDestacadas = document.getElementById('seccion-destacadas');
    const gridCapacitaciones = document.getElementById('grid-capacitaciones');
    const contadorResultados = document.getElementById('contador-resultados');
    const totalResultados = document.getElementById('total-resultados');
    const sinResultados = document.getElementById('sin-resultados');
    const capacitacionItems = document.querySelectorAll('.capacitacion-item');
    
    inputBusqueda.addEventListener('input', function() {
        const termino = this.value.toLowerCase().trim();
        
        // Si no hay búsqueda, mostrar todo
        if (termino === '') {
            capacitacionItems.forEach(item => item.style.display = '');
            contadorResultados.style.display = 'none';
            sinResultados.style.display = 'none';
            gridCapacitaciones.style.display = '';
            return;
        }
        
        // NO ocultar destacadas durante búsqueda para evitar saltos en el scroll
        
        // Filtrar capacitaciones
        let resultadosVisibles = 0;
        capacitacionItems.forEach(item => {
            const nombre = item.dataset.nombre;
            const equipo = item.dataset.equipo;
            const fecha = item.dataset.fecha;
            
            const coincide = nombre.includes(termino) || 
                           equipo.includes(termino) || 
                           fecha.includes(termino);
            
            if (coincide) {
                item.style.display = '';
                resultadosVisibles++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Actualizar contador y mensajes
        totalResultados.textContent = resultadosVisibles;
        
        if (resultadosVisibles === 0) {
            contadorResultados.style.display = 'none';
            gridCapacitaciones.style.display = 'none';
            sinResultados.style.display = 'block';
        } else {
            contadorResultados.style.display = 'block';
            gridCapacitaciones.style.display = '';
            sinResultados.style.display = 'none';
        }
    });
});
