<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .stats-section {
            padding: 3rem 0;
        }

        .stats-title {
            margin-bottom: 2rem;
            text-align: center;
        }

        .stats-table {
            margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .stats-table thead {
            background-color: #007bff;
            color: #fff;
        }

        .stats-table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .stats-table tbody tr:nth-child(even) {
            background-color: #e9ecef;
        }

        .language-selector {
            margin-bottom: 2rem;
            text-align: center;
        }
    </style>
    <script>
        let currentLanguage = 'es';

        async function loadStatistics() {
            const response = await fetch('estadisticas.json');
            const data = await response.json();
            renderLanguageSelector(data.languages);
            renderStatistics(data.estadisticas);
        }

        function renderStatistics(sections) {
            const container = document.getElementById('statistics-container');
            container.innerHTML = '';

            sections.forEach(section => {
                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'mb-5';

                const title = section.title[currentLanguage] || section.title['es'];
                sectionDiv.innerHTML = `<h3 class="text-center">${title}</h3>`;

                const table = document.createElement('table');
                table.className = 'table stats-table';
                table.innerHTML = `
                    <thead>
                        <tr>
                            <th>${currentLanguage === 'es' ? 'Nombre' : currentLanguage === 'en' ? 'Name' : 'Nom'}</th>
                            <th>${currentLanguage === 'es' ? 'Valor' : currentLanguage === 'en' ? 'Value' : 'Valeur'}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                `;

                const tbody = table.querySelector('tbody');
                section.items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.nombre[currentLanguage] || item.nombre['es']}</td>
                        <td>${item.valor}</td>
                    `;
                    tbody.appendChild(row);
                });

                sectionDiv.appendChild(table);
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
                loadStatistics();
            });
        }

        document.addEventListener('DOMContentLoaded', loadStatistics);
    </script>
</head>

<body>
    <section class="stats-section">
        <div class="container">
            <h2 class="stats-title">Estadísticas del Proyecto</h2>
            <div class="language-selector">
                <label for="language-selector" class="form-label">Selecciona tu idioma:</label>
                <select class="form-select w-50 mx-auto" id="language-selector">
                    <!-- Opciones de idiomas cargadas dinámicamente -->
                </select>
            </div>
            <div id="statistics-container">
                <!-- Secciones cargadas dinámicamente -->
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include('includes/footer.php'); ?>
