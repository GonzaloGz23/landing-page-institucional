# 🚀 Características Técnicas Destacadas

Este documento detalla las soluciones técnicas más interesantes implementadas en el proyecto.

## 1. Solución Cross-Database sin Privilegios Especiales

### El Problema

El proyecto requería consultar datos de dos bases de datos diferentes:
- `sistema_cursos`: Gestión de capacitaciones
- `sistema_institucional`: Información de equipos y usuarios

La solución tradicional sería usar JOINs cross-database:
```sql
SELECT c.*, e.alias 
FROM sistema_cursos.capacitaciones c
LEFT JOIN sistema_institucional.equipos e ON c.equipo_id = e.id_equipo
```

**Limitación**: El hosting no otorgaba privilegios necesarios para este tipo de consultas.

### La Solución

Implementé una estrategia de **consultas separadas + combinación en PHP**:

1. **Primera consulta**: Obtener capacitaciones de `sistema_cursos`
2. **Extraer IDs únicos**: Identificar qué equipos se necesitan
3. **Segunda consulta**: Obtener equipos de `sistema_institucional` usando IN clause
4. **Combinación en PHP**: Hacer el "JOIN" manualmente con arrays asociativos

```php
// 1. Obtener capacitaciones
$capacitaciones = $this->getCapacitacionesFromDB();

// 2. Extraer IDs únicos de equipos
$equipoIds = array_unique(array_column($capacitaciones, 'equipo_id'));

// 3. Obtener equipos en una sola consulta
$equipos = $this->getEquiposByIds($equipoIds); // Retorna [id => nombre]

// 4. Combinar datos (JOIN en PHP)
foreach ($capacitaciones as &$capacitacion) {
    $equipoId = $capacitacion['equipo_id'];
    $capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
}
```

### Ventajas

✅ **Sin privilegios especiales**: Cada consulta se ejecuta en su propia BD  
✅ **Eficiente**: Solo 2 consultas totales (no N+1)  
✅ **Rápido**: Lookup O(1) con arrays asociativos  
✅ **Portable**: Funciona en cualquier hosting  
✅ **Mantenible**: Código claro y fácil de debuggear

### Rendimiento

Para 50 capacitaciones con 10 equipos únicos:
- **Antes**: 1 consulta JOIN (bloqueada por hosting)
- **Después**: 2 consultas simples + combinación O(n) en PHP
- **Resultado**: Rendimiento prácticamente idéntico, sin restricciones

**Documentación completa**: [`backend/docs/SOLUCION_CROSS_DATABASE.md`](backend/docs/SOLUCION_CROSS_DATABASE.md)

---

## 2. Arquitectura de Componentes Reutilizables

### Sistema de Componentes PHP

El proyecto implementa un sistema de componentes reutilizables similar a frameworks modernos:

#### Header Centralizado
```php
// Componente: components/header.php
// Variables esperadas: $page_title, $body_class, $page_level, $current_page, $page_css

// Uso en cualquier página:
$page_title = 'Capacitaciones Disponibles';
$body_class = 'bg-capacitaciones';
$page_level = 'root';
$page_css = ['pages/capacitaciones.min.css'];
include '../components/header.php';
```

#### Configuración Adaptativa de Rutas

El sistema detecta automáticamente el nivel de carpeta y ajusta las rutas:

```php
// components/config/page_config.php
function initPageConfig($page_level) {
    switch ($page_level) {
        case 'root':
            $assets_path = '../assets/';
            $home_path = '';
            break;
        case 'ce':
        case 'cie':
            $assets_path = '../../assets/';
            $home_path = '../';
            break;
    }
    return compact('assets_path', 'home_path', 'nav_links');
}
```

**Beneficio**: Componentes funcionan correctamente sin importar desde dónde se incluyan.

#### Card de Capacitación Reutilizable

```php
// components/card-capacitacion.php
// Recibe variable $curso y renderiza card completa con:
// - Imagen
// - Título y descripción
// - Estado (abierta/cerrada/finalizada)
// - Botón de acción dinámico
// - Estilos condicionales según estado

// Uso:
foreach ($capacitaciones as $curso) {
    include '../components/card-capacitacion.php';
}
```

---

## 3. Seguridad Implementada

### Protección Contra SQL Injection

**Todas** las consultas usan prepared statements:

```php
// ❌ NUNCA así:
$sql = "SELECT * FROM capacitaciones WHERE id = " . $_GET['id'];

// ✅ SIEMPRE así:
$sql = "SELECT * FROM capacitaciones WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
```

### Protección de Directorios Sensibles

```apache
# backend/.htaccess
Order Deny,Allow
Deny from all

# Permite acceso solo a archivos específicos si es necesario
<FilesMatch "\.(php)$">
    Allow from all
</FilesMatch>
```

### Validación de Acceso a Archivos

```php
// Todos los archivos del backend verifican:
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

// Solo se permite acceso cuando se define la constante:
define('SECURE_ACCESS', true);
require_once '../backend/config/BDConections.php';
```

### Sanitización de Salida

```php
// Escapar HTML en todas las salidas:
<h2><?= htmlspecialchars($curso['nombre']) ?></h2>

// Sanitizar atributos:
<div data-nombre="<?= strtolower(htmlspecialchars($curso['nombre'])) ?>">
```

---

## 4. Optimización de Rendimiento

### Evitar N+1 Queries

**Problema común**: Consultar equipos dentro de un loop

```php
// ❌ MAL: N+1 queries (1 + N consultas)
foreach ($capacitaciones as $curso) {
    $equipo = getEquipoById($curso['equipo_id']); // Consulta por cada curso
}

// ✅ BIEN: Solo 2 queries
$equipoIds = array_unique(array_column($capacitaciones, 'equipo_id'));
$equipos = getEquiposByIds($equipoIds); // Una sola consulta con IN
foreach ($capacitaciones as &$curso) {
    $curso['equipo_nombre'] = $equipos[$curso['equipo_id']] ?? 'Sin equipo';
}
```

### Minificación de Assets

Todos los CSS y JS están minificados:
- `main.css` → `main.min.css` (reducción ~40%)
- `capacitaciones.css` → `capacitaciones.min.css`
- Carga automática de versión minificada si existe

### Fallback de CDN

Sistema de fallback automático si CDN falla:

```javascript
// Verificar si Bootstrap CSS se cargó desde CDN
const checkBootstrapCSS = () => {
    let testEl = document.createElement('div');
    testEl.className = 'container-fluid';
    document.body.appendChild(testEl);
    
    let hasBootstrap = window.getComputedStyle(testEl).width !== 'auto';
    document.body.removeChild(testEl);
    
    if (!hasBootstrap) {
        // Cargar versión local
        let fallbackCSS = document.createElement('link');
        fallbackCSS.rel = 'stylesheet';
        fallbackCSS.href = '../assets/css/bootstrap.min.css';
        document.head.appendChild(fallbackCSS);
    }
}
```

**Beneficio**: Alta disponibilidad incluso si CDN está caído.

### Control de Caché

```php
// pages/capacitaciones.php
// Deshabilitar caché para contenido dinámico
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
```

---

## 5. Búsqueda en Tiempo Real (JavaScript Vanilla)

### Implementación sin Frameworks

Sistema de búsqueda dinámica implementado con JavaScript puro:

```javascript
// assets/js/pages/capacitaciones.js
document.getElementById('busqueda').addEventListener('input', function(e) {
    const termino = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.capacitacion-item');
    let resultados = 0;
    
    items.forEach(item => {
        const nombre = item.dataset.nombre;
        const equipo = item.dataset.equipo;
        const fecha = item.dataset.fecha;
        
        const coincide = nombre.includes(termino) || 
                        equipo.includes(termino) || 
                        fecha.includes(termino);
        
        item.style.display = coincide ? '' : 'none';
        if (coincide) resultados++;
    });
    
    // Actualizar contador
    document.getElementById('total-resultados').textContent = resultados;
});
```

**Características**:
- ✅ Búsqueda instantánea mientras el usuario escribe
- ✅ Busca en múltiples campos (nombre, equipo, fecha)
- ✅ Contador de resultados en tiempo real
- ✅ Sin dependencias externas (solo JavaScript nativo)
- ✅ Rendimiento óptimo con dataset attributes

---

## 6. Diseño Responsive Mobile-First

### Bootstrap 5 + Customización

El proyecto usa Bootstrap 5.3 como base con customizaciones:

```css
/* Breakpoints personalizados */
.capacitaciones-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

/* Navegación adaptativa */
@media (max-width: 991px) {
    .navbar .nav { display: none; }
    .navbar-toggler { display: block; }
}

@media (min-width: 992px) {
    .navbar .nav { display: flex; }
    .navbar-toggler { display: none; }
}
```

### Offcanvas para Móviles

Menú lateral deslizable en dispositivos móviles:

```html
<!-- Botón hamburguesa (solo móvil) -->
<button class="navbar-toggler d-lg-none" data-bs-toggle="offcanvas">
    <i class="bi bi-list"></i>
</button>

<!-- Offcanvas menu -->
<div class="offcanvas offcanvas-end" id="offcanvasNavbar">
    <!-- Menú de navegación -->
</div>
```

---

## 7. Gestión de Estados de Capacitaciones

### Sistema Dinámico de Estados

Las capacitaciones tienen diferentes estados que afectan su visualización:

```php
// Estados posibles:
// 1 = Abierta (inscripciones abiertas)
// 2 = Cerrada (inscripciones cerradas, curso en progreso)
// 3 = Finalizada (curso terminado)

// Lógica en card-capacitacion.php
$estado_clase = match($curso['estado_id']) {
    1 => 'estado-abierta',
    2 => 'estado-cerrada',
    3 => 'estado-finalizada',
    default => 'estado-desconocido'
};

$boton_texto = match($curso['estado_id']) {
    1 => 'Inscribirse',
    2 => 'Ver detalles',
    3 => 'Ver información',
    default => 'Más info'
};
```

**Beneficio**: UI adaptativa según el estado del curso.

---

## 8. Validación de DNI en Inscripciones

### Verificación de Duplicados

Sistema AJAX para verificar si un DNI ya está inscrito:

```javascript
// inscripciones/validar_dni.php
async function validarDNI(dni, capacitacionId) {
    const response = await fetch('validar_dni.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ dni, capacitacion_id: capacitacionId })
    });
    
    const data = await response.json();
    return data.disponible;
}
```

**Beneficio**: Evita inscripciones duplicadas antes de enviar el formulario.

---

## Conclusión

Este proyecto demuestra:
- ✅ Soluciones creativas a limitaciones de infraestructura
- ✅ Código limpio y mantenible
- ✅ Seguridad como prioridad
- ✅ Optimización de rendimiento
- ✅ Experiencia de usuario cuidada
- ✅ Arquitectura escalable

Cada decisión técnica fue tomada considerando las restricciones reales del hosting y las necesidades del usuario final.
