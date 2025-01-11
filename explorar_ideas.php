<?php
include 'includes/header.php';
?>

<div class="container my-5">
    <h2 id="explore-title" class="mb-4 text-center">Explorar Ideas</h2>
    <div class="mb-3 text-center">
        <label for="language-selector" class="form-label">Selecciona un idioma:</label>
        <select id="language-selector" class="form-select w-auto d-inline-block">
            <option value="es" selected>Español</option>
            <option value="en">English</option>
        </select>
    </div>
    <div id="explore-container" class="row gy-4">
        <!-- Secciones dinámicas -->
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }
    h2 {
        color: #333;
        font-weight: bold;
    }
    .card {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #007bff;
    }
    .card-text {
        color: #555;
    }
</style>

<script>
    const loadExploreSections = (lang) => {
        fetch('explorar_ideas.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al cargar el archivo JSON");
                }
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('explore-container');
                container.innerHTML = '';
                data.forEach(section => {
                    container.innerHTML += `
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h3 class="card-title">${section.title[lang]}</h3>
                                    <p class="card-text">${section.description[lang]}</p>
                                    ${section.content.map(item => `
                                        <div class="mb-2">
                                            <strong>${item.name[lang]}:</strong> ${item.details[lang]}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>`;
                });
            })
            .catch(error => {
                console.error('Error cargando explorar ideas:', error);
                const container = document.getElementById('explore-container');
                container.innerHTML = `<div class="text-danger">Error cargando los datos. Por favor, inténtalo más tarde.</div>`;
            });
    };

    document.querySelector('#language-selector').addEventListener('change', (e) => {
        loadExploreSections(e.target.value);
    });

    loadExploreSections('es');
</script>

<?php
include 'includes/footer.php';
?>
