<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos para Colaboradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .resource-card {
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .resource-card:hover {
            transform: translateY(-5px);
        }

        .resource-section {
            padding: 3rem 0;
        }

        .resource-title {
            margin-bottom: 2rem;
            text-align: center;
        }
    </style>
    <script>
        let currentLanguage = 'es';

        async function loadResources() {
            const response = await fetch('recursos.json');
            const data = await response.json();
            renderLanguageSelector(data.languages);
            renderSections(data.recursos);
        }

        function renderSections(recursos) {
            const container = document.getElementById('resources-container');
            container.innerHTML = '';

            recursos.forEach(section => {
                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'mb-5';

                const title = section.title[currentLanguage] || section.title['es'];
                sectionDiv.innerHTML = `<h3>${title}</h3>`;

                const row = document.createElement('div');
                row.className = 'row';

                section.items.forEach(item => {
                    const card = document.createElement('div');
                    card.className = 'col-md-6';
                    card.innerHTML = `
                        <div class="card resource-card">
                            <div class="card-body">
                                <h5 class="card-title">${item.nombre[currentLanguage] || item.nombre['es']}</h5>
                                <p class="card-text">${item.descripcion[currentLanguage] || item.descripcion['es']}</p>
                                <a href="${item.link}" class="btn btn-primary" target="_blank">Ir al recurso</a>
                            </div>
                        </div>
                    `;
                    row.appendChild(card);
                });

                sectionDiv.appendChild(row);
                container.appendChild(sectionDiv);
            });
        }

        function renderLanguageSelector(languages) {
            const selector = document.getElementById('language-selector');
            selector.innerHTML = '';

            languages.forEach(lang => {
                const option = document.createElement('option');
                option.value = lang.code;
                option.textContent = lang.name;
                selector.appendChild(option);
            });

            selector.addEventListener('change', (event) => {
                currentLanguage = event.target.value;
                loadResources();
            });
        }

        document.addEventListener('DOMContentLoaded', loadResources);
    </script>
</head>

<body>
    <section class="resource-section">
        <div class="container">
            <h2 class="resource-title">Recursos para Trabajo Colaborativo</h2>
            <div class="mb-4">
                <label for="language-selector" class="form-label">Selecciona tu idioma:</label>
                <select class="form-select" id="language-selector">
                    <!-- Opciones de idiomas cargadas dinámicamente -->
                </select>
            </div>
            <div id="resources-container">
                <!-- Secciones cargadas dinámicamente -->
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include('includes/footer.php'); ?>
