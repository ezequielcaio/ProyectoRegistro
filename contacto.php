<?php
include 'includes/header.php';
?>

<div class="container my-5">
    <h2 id="contact-title" class="mb-4">Contacto</h2>
     <div class="d-flex justify-content-between align-items-center">
        <h2 id="form-title">Seleccionar un idioma</h2>
        <select id="language-selector" class="form-select w-auto">
            <option value="es">Español</option>
            <option value="en">English</option>
        </select>
    </div>
    <!--<div class="mb-3">
        <label for="language-selector" class="form-label">Selecciona un idioma:</label>
        <select id="language-selector" class="form-select">
            <option value="es" selected>Español</option>
            <option value="en">English</option>
        </select>
    </div>-->
    <div id="contact-container" class="row">
        <!-- Aquí se cargarán dinámicamente las secciones de contacto -->
    </div>
</div>

<script>
    // Función para cargar las secciones de contacto desde el JSON
    const loadContactSections = (lang) => {
        fetch('contacto.json')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('contact-container');
                container.innerHTML = '';
                data.forEach(section => {
                    container.innerHTML += `
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h3 class="card-title">${section.title[lang]}</h3>
                                    <p class="card-text">${section.description[lang]}</p>
                                    ${section.links
                                        .map(link => `
                                            <a href="${link.url}" target="_blank" class="btn btn-primary btn-sm me-2">
                                                ${link.text[lang]}
                                            </a>`).join('')}
                                </div>
                            </div>
                        </div>`;
                });
            })
            .catch(error => console.error('Error cargando contacto:', error));
    };

    // Cambiar idioma dinámicamente
    document.querySelector('#language-selector').addEventListener('change', (e) => {
        loadContactSections(e.target.value);
    });

    // Cargar secciones en el idioma por defecto al iniciar
    loadContactSections('es');
</script>

<?php
include 'includes/footer.php';
?>
