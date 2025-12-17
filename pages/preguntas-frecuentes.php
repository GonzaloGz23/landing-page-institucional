<?php
// Configuración de la página Preguntas Frecuentes
$page_title = 'Preguntas Frecuentes - Organismo Público';
$body_class = 'bg-preguntas-frecuentes';
$page_level = 'root';
$current_page = 'preguntas-frecuentes.php';

// CSS específicos para esta página
$page_css = [
    'pages/preguntas-frecuentes.css'  // Se cargará desde assets/css/pages/preguntas-frecuentes.css
];

// Incluir header
include '../components/header.php';
?>

<main class="container-fluid letter-white">
    <div class="container mt-5">
        
        <!-- Título principal -->
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <h1 class="h2 mb-4">Preguntas frecuentes:</h1>
                
                <!-- Contenido de Preguntas y Respuestas -->
                <div class="faq-section">
                    
                    <!-- Pregunta 1 -->
                    <div class="faq-item">
                        <h3 class="faq-question">
                            1) ¿Quién puede acceder a los programas del organismo?
                        </h3>
                        <p class="faq-answer">
                            Cualquier persona que esté buscando su primera experiencia laboral o que quiera mejorar sus oportunidades de empleo puede acceder. Los programas están diseñados para distintos perfiles y niveles de formación.
                        </p>
                    </div>
                    
                    <!-- Pregunta 2 -->
                    <div class="faq-item">
                        <h3 class="faq-question">
                            2) ¿Cómo me inscribo en un programa de capacitación laboral?
                        </h3>
                        <p class="faq-answer">
                            Podés inscribirte a través de nuestra web o directamente en las oficinas correspondientes.
                            Es importante completar todos los datos solicitados para poder recibir información sobre cursos, talleres y programas disponibles.
                        </p>
                    </div>
                    
                    <!-- Pregunta 3 -->
                    <div class="faq-item">
                        <h3 class="faq-question">
                            3) ¿Qué tipos de capacitaciones ofrecen?
                        </h3>
                        <p class="faq-answer">
                            Se ofrecen capacitaciones en oficios, habilidades blandas, herramientas digitales, y preparación para entrevistas y curriculums. Algunos cursos incluyen prácticas en empresas locales para ganar experiencia real.
                        </p>
                    </div>
                    
                    <!-- Pregunta 4 -->
                    <div class="faq-item">
                        <h3 class="faq-question">
                            4) ¿Es necesario tener experiencia laboral previa para participar?
                        </h3>
                        <p class="faq-answer">
                            No, muchos programas están pensados justamente para quienes aún no tienen experiencia, ayudándote a formarte y conseguir tu primer empleo o mejorar tu perfil profesional.
                        </p>
                    </div>
                    
                    <!-- Pregunta 5 -->
                    <div class="faq-item">
                        <h3 class="faq-question">
                            5) ¿Cómo puedo ofrecer mis servicios o buscar trabajo a través del organismo?
                        </h3>
                        <p class="faq-answer">
                            Podés usar nuestra plataforma digital para ofrecer tus servicios o buscar oportunidades laborales en tu zona.
                        </p>
                    </div>
                    
                </div>
                
                <!-- Botón centrado -->
                <div class="text-center mt-5">
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