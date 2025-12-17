/**
 * Módulo de validación y control del formulario de inscripción
 * Usa SweetAlert2 para alertas personalizadas
 */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formInscripcion');

    // Configuración de colores corporativos para SweetAlert2
    const swalConfig = {
        confirmButtonColor: '#013453', // --main-color
        cancelButtonColor: '#7e2752',  // --tertiary-color
        customClass: {
            popup: 'inscripcion-swal-popup',
            title: 'inscripcion-swal-title',
            confirmButton: 'inscripcion-swal-confirm',
            cancelButton: 'inscripcion-swal-cancel'
        }
    };

    // Validación Bootstrap en tiempo real
    let formSubmitted = false;

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        event.stopPropagation();

        // Validar formulario con HTML5
        if (!form.checkValidity()) {
            form.classList.add('was-validated');

            // Mostrar alerta de error con SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Formulario incompleto',
                html: 'Por favor complete todos los campos obligatorios correctamente antes de enviar el formulario.',
                ...swalConfig
            });

            return;
        }

        // Si ya se envió, no hacer nada
        if (formSubmitted) return;

        // NUEVO: Validar DNI antes de confirmar
        const dni = document.getElementById('dni').value;
        const capacitacionId = document.querySelector('input[name="capacitacion_id"]').value;
        const submitBtn = form.querySelector('button[type="submit"]');

        // Bloquear botón y mostrar spinner
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Validando...';

        try {
            // Llamada AJAX para validar DNI
            const response = await fetch('validar_dni.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `dni=${encodeURIComponent(dni)}&capacitacion_id=${encodeURIComponent(capacitacionId)}`
            });

            const data = await response.json();

            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;

            // Si ya está inscrito
            if (data.yaInscrito) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ya estás inscrito',
                    html: 'El DNI ingresado ya se encuentra inscrito en esta capacitación.<br><br>Si crees que esto es un error, por favor contacta con el equipo organizador.',
                    ...swalConfig
                });
                return;
            }

            // Si NO está inscrito, mostrar confirmación
            Swal.fire({
                icon: 'question',
                title: '¿Confirmar inscripción?',
                html: 'Verifique que todos sus datos sean correctos antes de enviar.',
                showCancelButton: true,
                confirmButtonText: 'Sí, inscribirme',
                cancelButtonText: 'Revisar datos',
                ...swalConfig
            }).then((result) => {
                if (result.isConfirmed) {
                    formSubmitted = true;
                    form.submit(); // Enviar formulario
                }
            });

        } catch (error) {
            // Error en AJAX
            console.error('Error al validar DNI:', error);

            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;

            // Mostrar error
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                html: 'No se pudo validar el DNI. Por favor intente nuevamente.',
                ...swalConfig
            });
        }
    }, false);

    // Validación del DNI en tiempo real (solo números)
    const dniInput = document.getElementById('dni');
    dniInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validación de celulares (solo números)
    const celularInput = document.getElementById('celular');
    const celularAltInput = document.getElementById('celular_alternativo');

    celularInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    celularAltInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validación de nombre y apellido (solo letras)
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');

    nombreInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });

    apellidoInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });

    // Mostrar mensajes de éxito/error al cargar si vienen de POST
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success === '1') {
        Swal.fire({
            icon: 'success',
            title: '¡Inscripción confirmada!',
            html: 'Tu inscripción ha sido registrada exitosamente. Pronto recibirás un correo de confirmación.',
            ...swalConfig
        });
    } else if (error) {
        const errorMessages = {
            'duplicado': 'Ya existe una inscripción registrada con este DNI o correo electrónico.',
            'completo': 'Lo sentimos, esta capacitación ya no tiene cupos disponibles.',
            'cerrado': 'Esta capacitación ya no acepta inscripciones.',
            'invalid': 'Hubo un error al procesar tu inscripción. Por favor intenta nuevamente.'
        };

        Swal.fire({
            icon: 'error',
            title: 'Error en la inscripción',
            html: errorMessages[error] || 'Ocurrió un error inesperado. Por favor intenta nuevamente.',
            ...swalConfig
        });
    }
});
