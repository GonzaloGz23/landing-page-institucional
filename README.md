# 🌐 Landing Page - Organismo Público

> Sistema web de gestión de capacitaciones laborales desarrollado con PHP, MySQL y Bootstrap 5

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
![PHP](https://img.shields.io/badge/PHP-7%2B-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)

## 📋 Descripción del Proyecto

Este proyecto fue desarrollado para un organismo público como sistema de gestión y difusión de capacitaciones laborales. El sistema permite a las personas explorar cursos disponibles, inscribirse en capacitaciones y acceder a información sobre programas de empleo y emprendimiento.

**Nota**: Este es un proyecto sanitizado de producción adaptado para portfolio profesional. Las credenciales y datos sensibles han sido removidos.

## ✨ Características Principales

### 🎯 Funcionalidades del Sistema
- **Catálogo de Capacitaciones**: Listado completo de cursos disponibles con filtrado y búsqueda
- **Búsqueda en Tiempo Real**: Sistema de búsqueda dinámica con JavaScript vanilla (sin frameworks)
- **Cursos Destacados**: Sección especial para capacitaciones prioritarias
- **Sistema de Inscripciones**: Formulario de registro con validación de DNI
- **Detalle de Cursos**: Información completa incluyendo módulos, cronograma y requisitos
- **Diseño Responsive**: Interfaz adaptativa para desktop, tablet y móvil
- **Dos Áreas Especializadas**:
  - **CIE** (Centro de Inserción al Empleo): Capacitación y búsqueda laboral
  - **CE** (Centro de Emprendedores): Apoyo a emprendedores y PyMEs

### 🛠️ Características Técnicas Destacadas

#### 1. **Solución Cross-Database sin Privilegios Especiales**
El proyecto implementa una solución elegante para consultas entre dos bases de datos diferentes (`sistema_cursos` y `sistema_institucional`) sin requerir privilegios especiales de MySQL:

- **Problema**: El hosting no permitía JOINs cross-database
- **Solución**: Consultas separadas + combinación en PHP usando arrays asociativos
- **Resultado**: Rendimiento óptimo (O(n)) sin restricciones de privilegios
- **Documentación**: Ver [`backend/docs/SOLUCION_CROSS_DATABASE.md`](backend/docs/SOLUCION_CROSS_DATABASE.md)

#### 2. **Arquitectura de Componentes Reutilizables**
Sistema modular con componentes PHP reutilizables:
- Header y Footer centralizados
- Cards de capacitaciones con estados dinámicos
- Configuración de rutas adaptativa según nivel de carpeta
- Fallback automático de CDN a archivos locales

#### 3. **Seguridad Implementada**
- Protección contra acceso directo a archivos del backend
- Prepared statements en todas las consultas SQL
- Validación de datos de entrada
- Sanitización de salida HTML
- Headers de caché controlados

#### 4. **Optimización de Rendimiento**
- CSS y JS minificados
- Carga condicional de recursos
- Una sola consulta para capacitaciones (evita N+1 queries)
- Lazy loading de componentes

## 🏗️ Stack Tecnológico

### Backend
- **PHP 7+**: Lenguaje principal del servidor
- **MySQL 5.7+**: Dos bases de datos relacionales
- **PDO**: Capa de abstracción de base de datos con prepared statements

### Frontend
- **HTML5**: Estructura semántica
- **CSS3**: Estilos personalizados + minificación
- **JavaScript (Vanilla)**: Sin frameworks, código nativo
- **Bootstrap 5.3.8**: Framework CSS responsive
- **Bootstrap Icons 1.11.1**: Iconografía

### Herramientas y Librerías
- **SweetAlert2**: Alertas y modales elegantes
- **Google Analytics**: Tracking de usuarios (opcional)

## 📁 Estructura del Proyecto

```
newLandingPage/
├── assets/                  # Recursos estáticos
│   ├── css/                # Hojas de estilo (minificadas)
│   ├── img/                # Imágenes y logos
│   ├── js/                 # Scripts JavaScript
│   └── fonts/              # Fuentes personalizadas
├── backend/                # Lógica del servidor
│   ├── config/             # Configuración de BD
│   ├── controllers/        # Controladores MVC
│   └── docs/               # Documentación técnica
├── components/             # Componentes reutilizables
│   ├── header.php          # Navegación y <head>
│   ├── footer.php          # Pie de página
│   ├── card-capacitacion.php  # Card de curso
│   └── config/             # Configuración de componentes
├── pages/                  # Páginas del sitio
│   ├── index.php           # Página principal
│   ├── capacitaciones.php  # Listado de cursos
│   ├── CIE/                # Sección Centro de Inserción al Empleo
│   └── CE/                 # Sección Centro de Emprendedores
├── inscripciones/          # Sistema de inscripciones
├── database/               # Scripts SQL de referencia
├── .env.example            # Plantilla de configuración
├── .gitignore              # Archivos ignorados por Git
└── LICENSE                 # Licencia MIT
```

## 🗄️ Arquitectura de Base de Datos

El sistema utiliza **dos bases de datos MySQL** separadas:

### 1. `sistema_cursos`
Base de datos dedicada a la gestión de capacitaciones:
- **capacitaciones**: Información de cursos (nombre, descripción, fechas, cupos)
- **modulos**: Contenido temático de cada capacitación
- **cronograma**: Calendario de clases
- **inscripciones**: Registro de participantes
- **estados**: Estados de las capacitaciones (abierta, cerrada, finalizada)

### 2. `sistema_institucional`
Base de datos principal del sistema institucional:
- **equipos**: Equipos responsables de las capacitaciones
- **usuarios**: Personal administrativo
- **configuraciones**: Parámetros del sistema

**Ver**: [`database/schema_reference.sql`](database/schema_reference.sql) para estructura completa

## 🔧 Configuración (Para Desarrollo Local)

Si deseas ejecutar este proyecto localmente para revisarlo:

1. **Clonar el repositorio**
```bash
git clone <repo-url>
cd newLandingPage
```

2. **Configurar base de datos**
   - Crear dos bases de datos MySQL: `sistema_cursos` y `sistema_institucional`
   - Importar estructura desde `database/schema_reference.sql`

3. **Configurar variables de entorno**
```bash
cp .env.example .env
# Editar .env con tus credenciales de base de datos
```

4. **Configurar servidor web**
   - Usar XAMPP, LAMPP, WAMP o servidor PHP integrado
   - Apuntar el DocumentRoot a la carpeta del proyecto

5. **Acceder al sitio**
```
http://localhost/newLandingPage/
```

## 💡 Características Técnicas para Destacar en Entrevistas

### 1. Solución Creativa a Limitaciones de Hosting
Implementé una solución elegante para realizar consultas entre dos bases de datos cuando el hosting no permitía JOINs cross-database. En lugar de usar privilegios especiales, separé las consultas y las combiné eficientemente en PHP usando arrays asociativos, logrando el mismo rendimiento sin restricciones.

### 2. Arquitectura Escalable y Mantenible
El proyecto sigue un patrón MVC adaptado con separación clara de responsabilidades:
- Controllers para lógica de negocio
- Componentes reutilizables para UI
- Configuración centralizada
- Código DRY (Don't Repeat Yourself)

### 3. Seguridad como Prioridad
- Todas las consultas usan prepared statements (prevención de SQL injection)
- Protección de directorios sensibles con .htaccess
- Validación y sanitización de datos
- Control de acceso a archivos del backend

### 4. Optimización de Rendimiento
- Minimización de consultas a BD (evitando N+1 queries)
- CSS/JS minificados para reducir tamaño
- Fallback de CDN a local para alta disponibilidad
- Carga condicional de recursos

### 5. Experiencia de Usuario
- Búsqueda en tiempo real sin recargar página
- Diseño responsive mobile-first
- Feedback visual con SweetAlert2
- Navegación intuitiva

## 📝 Documentación Adicional

- **[FEATURES.md](FEATURES.md)**: Características técnicas detalladas
- **[backend/docs/SOLUCION_CROSS_DATABASE.md](backend/docs/SOLUCION_CROSS_DATABASE.md)**: Explicación de la solución cross-database
- **[database/schema_reference.sql](database/schema_reference.sql)**: Estructura de base de datos

## 🤝 Contexto del Proyecto

Proyecto preparado para demostración en portfolio profesional; el código ha sido sanitizado para remover datos sensibles y adaptado para ejemplos.

### Notas
- ✅ Código sanitizado para demostración

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

---

**Desarrollado por**: Gonzalo Gómez  
**Contacto**: gonzaloegomez23@gmail.com

---
