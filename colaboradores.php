<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección de Colaboradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .search-section {
            background-color: #f8f9fa;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .card {
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .profile-card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .skill-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin: 0.25rem;
            display: inline-block;
        }

        .story-card {
            border-left: 4px solid #0d6efd;
        }

        .contact-card {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0);
            color: white;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
    <script>
        async function loadCollaborators() {
            const response = await fetch('colaboradores.json');
            const data = await response.json();

            renderProfiles(data.perfiles);
            renderStories(data.historias);
        }

        function renderProfiles(profiles) {
            const container = document.getElementById('profiles-container');
            container.innerHTML = '';
            profiles.forEach(profile => {
                const card = document.createElement('div');
                card.className = 'col-md-4';
                card.innerHTML = `
                    <div class="card profile-card">
                        <div class="card-body text-center">
                            <img src="${profile.imagen}" class="profile-image mb-3" alt="Perfil">
                            <h5 class="card-title">${profile.nombre}</h5>
                            <p class="text-muted">${profile.profesion}</p>
                            <div class="mb-3">
                                ${profile.habilidades.map(skill => `<span class="skill-badge">${skill}</span>`).join('')}
                            </div>
                            <button class="btn btn-outline-primary">Ver Perfil</button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function renderStories(stories) {
            const container = document.getElementById('stories-container');
            container.innerHTML = '';
            stories.forEach(story => {
                const card = document.createElement('div');
                card.className = 'col-md-6 mb-4';
                card.innerHTML = `
                    <div class="card story-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="${story.imagen}" class="rounded-circle me-3" alt="Perfil">
                                <div>
                                    <h5 class="card-title mb-0">${story.titulo}</h5>
                                    <small class="text-muted">Por ${story.autor}</small>
                                </div>
                            </div>
                            <p class="card-text">${story.descripcion}</p>
                            <a href="#" class="btn btn-outline-primary">Leer más</a>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        async function searchCollaborators(event) {
            event.preventDefault();

            const query = document.getElementById('search-query').value.toLowerCase();
            const category = document.getElementById('search-category').value.toLowerCase();
            const location = document.getElementById('search-location').value.toLowerCase();

            const response = await fetch('colaboradores.json');
            const data = await response.json();

            const filteredProfiles = data.perfiles.filter(profile => {
                return (
                    (!query || profile.nombre.toLowerCase().includes(query) || profile.habilidades.some(skill => skill.toLowerCase().includes(query))) &&
                    (!category || profile.categoria.toLowerCase() === category) &&
                    (!location || profile.ubicacion.toLowerCase() === location)
                );
            });

            renderProfiles(filteredProfiles);
        }

        document.addEventListener('DOMContentLoaded', loadCollaborators);
    </script>
</head>

<body>
    <!-- Sección de Búsqueda -->
    <section class="search-section">
        <div class="container">
            <h2 class="text-center mb-4">Buscar Socios</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3" onsubmit="searchCollaborators(event)">
                                <div class="col-md-4">
                                    <input type="text" id="search-query" class="form-control" placeholder="Habilidades, nombre...">
                                </div>
                                <div class="col-md-3">
                                    <select id="search-category" class="form-select">
                                        <option value="">Categoría</option>
                                        <option value="tecnologia">Tecnología</option>
                                        <option value="diseño">Diseño</option>
                                        <option value="marketing">Marketing</option>
                                        <option value="finanzas">Finanzas</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="search-location" class="form-select">
                                        <option value="">Ubicación</option>
                                        <option value="la paz">La Paz</option>
                                        <option value="cochabamba">Cochabamba</option>
                                        <option value="santa cruz">Santa Cruz</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Perfiles de Colaboradores -->
    <section class="container mb-5">
        <h2 class="mb-4">Perfiles de Colaboradores</h2>
        <div class="row" id="profiles-container"></div>
    </section>

    <!-- Contactar Interesados -->
    <section class="container mb-5">
        <div class="card contact-card">
            <div class="card-body text-center p-5">
                <h2 class="mb-4">¿Listo para Colaborar?</h2>
                <p class="mb-4">Conecta con otros profesionales y lleva tus proyectos al siguiente nivel.</p>
                <button class="btn btn-light btn-lg">Iniciar Conversación</button>
            </div>
        </div>
    </section>

    <!-- Historias de Colaboración -->
    <section class="container mb-5">
        <h2 class="mb-4">Historias de Colaboración</h2>
        <div class="row" id="stories-container"></div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include('includes/footer.php'); ?>
