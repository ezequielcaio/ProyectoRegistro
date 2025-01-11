<?php
include 'includes/header.php';
?>
<div class="container my-5">
    <h1 id="faq-title" class="mb-4">Preguntas Frecuentes</h1>
    <!--<div class="mb-3">
        <label for="language-selector" class="form-label">Selecciona un idioma:</label>
        <select id="language-selector" class="form-select">
            <option value="es" selected>Español</option>
            <option value="en">English</option>
        </select>
    </div>-->
    <div class="d-flex justify-content-between align-items-center">
        <h2 id="form-title">Selecciona un idioma</h2>
        <select id="language-selector" class="form-select w-auto">
            <option value="es">Español</option>
            <option value="en">English</option>
        </select>
    </div>
    <div id="faq-container" class="accordion" role="tablist">
        <!-- Aquí se cargarán dinámicamente las preguntas frecuentes -->
    </div>
</div>

<script>
    // Función para cargar preguntas frecuentes desde el JSON
    const loadFaqs = (lang) => {
        fetch('preguntas_frecuentes.json')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('faq-container');
                container.innerHTML = '';
                data.forEach((category, index) => {
                    let questionsHTML = '';
                    category.questions.forEach((q, qIndex) => {
                        questionsHTML += `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-${index}-${qIndex}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${index}-${qIndex}" aria-expanded="false" aria-controls="collapse-${index}-${qIndex}">
                                        ${q.question[lang]}
                                    </button>
                                </h2>
                                <div id="collapse-${index}-${qIndex}" class="accordion-collapse collapse" aria-labelledby="heading-${index}-${qIndex}" data-bs-parent="#faq-container">
                                    <div class="accordion-body">
                                        ${q.answer[lang]}
                                    </div>
                                </div>
                            </div>`;
                    });

                    container.innerHTML += `
                        <div class="mb-4">
                            <h3>${category.category[lang]}</h3>
                            ${questionsHTML}
                        </div>`;
                });
            })
            .catch(error => console.error('Error cargando FAQs:', error));
    };

    // Cambiar idioma dinámicamente
    document.querySelector('#language-selector').addEventListener('change', (e) => {
        loadFaqs(e.target.value);
    });

    // Cargar preguntas frecuentes en el idioma por defecto al iniciar
    loadFaqs('es');
</script>

<?php
include 'includes/footer.php';
?>
