<?php
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 id="form-title">Registrar una Idea</h2>
        <select id="language-selector" class="form-select w-auto">
            <option value="es">Español</option>
            <option value="en">English</option>
        </select>
    </div>
    <form id="idea-form" class="mt-4">
        <div class="mb-3">
            <label for="project-title" class="form-label" id="label-title">Título del proyecto</label>
            <input type="text" class="form-control" id="project-title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="project-description" class="form-label" id="label-description">Descripción del proyecto</label>
            <textarea class="form-control" id="project-description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="project-category" class="form-label" id="label-category">Categorías de interés</label>
            <select class="form-select" id="project-category" name="category" required>
                <option value="Tecnología">Tecnología</option>
                <option value="Salud">Salud</option>
                <option value="Educación">Educación</option>
                <option value="Medio Ambiente">Medio Ambiente</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="project-objectives" class="form-label" id="label-objectives">Objetivos principales</label>
            <textarea class="form-control" id="project-objectives" name="objectives" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="project-files" class="form-label" id="label-files">Adjuntar archivos</label>
            <input type="file" class="form-control" id="project-files" name="files[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary" id="submit-button">Registrar</button>
    </form>

    <h3 class="mt-5" id="table-title">Ideas Registradas</h3>
    <table class="table table-bordered mt-3" id="ideas-table">
        <thead>
            <tr>
                <th id="table-header-title">Título</th>
                <th id="table-header-description">Descripción</th>
                <th id="table-header-category">Categorías</th>
                <th id="table-header-objectives">Objetivos</th>
                <th id="table-header-actions">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Datos cargados dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Idea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Título del proyecto</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Descripción del proyecto</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-category" class="form-label">Categorías de interés</label>
                        <select class="form-select" id="edit-category" name="category" required>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Salud">Salud</option>
                            <option value="Educación">Educación</option>
                            <option value="Medio Ambiente">Medio Ambiente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-objectives" class="form-label">Objetivos principales</label>
                        <textarea class="form-control" id="edit-objectives" name="objectives" rows="3" required></textarea>
                    </div>
                    <input type="hidden" id="edit-index">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let currentEditIndex = null;

    const loadTranslations = (lang) => {
        fetch('translations.xml')
            .then(response => response.text())
            .then(xmlText => {
                const parser = new DOMParser();
                const xml = parser.parseFromString(xmlText, 'application/xml');
                document.querySelectorAll('[id]').forEach(element => {
                    const translation = xml.querySelector(`${element.id} ${lang}`);
                    if (translation) element.textContent = translation.textContent;
                });
            });
    };

    const loadIdeas = () => {
        fetch('registrar.json')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#ideas-table tbody');
                tableBody.innerHTML = '';
                data.forEach((idea, index) => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${idea.title}</td>
                            <td>${idea.description}</td>
                            <td>${idea.category}</td>
                            <td>${idea.objectives}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openEditModal(${index})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteIdea(${index})">Eliminar</button>
                            </td>
                        </tr>`;
                });
            });
    };

    const saveIdea = (idea) => {
        fetch('ajax_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'add', idea })
        }).then(loadIdeas);
    };

    const deleteIdea = (index) => {
        fetch('ajax_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'delete', index })
        }).then(loadIdeas);
    };

    const openEditModal = (index) => {
        fetch('registrar.json')
            .then(response => response.json())
            .then(data => {
                const idea = data[index];
                currentEditIndex = index;
                document.querySelector('#edit-title').value = idea.title;
                document.querySelector('#edit-description').value = idea.description;
                document.querySelector('#edit-category').value = idea.category;
                document.querySelector('#edit-objectives').value = idea.objectives;
                const editModal = new bootstrap.Modal(document.querySelector('#editModal'));
                editModal.show();
            });
    };

    document.querySelector('#edit-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const editedIdea = {
            title: document.querySelector('#edit-title').value,
            description: document.querySelector('#edit-description').value,
            category: document.querySelector('#edit-category').value,
            objectives: document.querySelector('#edit-objectives').value
        };
        fetch('ajax_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'edit', index: currentEditIndex, idea: editedIdea })
        }).then(() => {
            loadIdeas();
            const editModal = bootstrap.Modal.getInstance(document.querySelector('#editModal'));
            editModal.hide();
        });
    });

    document.querySelector('#idea-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const idea = {
            title: document.querySelector('#project-title').value,
            description: document.querySelector('#project-description').value,
            category: document.querySelector('#project-category').value,
            objectives: document.querySelector('#project-objectives').value
        };
        saveIdea(idea);
        e.target.reset();
    });

    document.querySelector('#language-selector').addEventListener('change', (e) => {
        loadTranslations(e.target.value);
    });

    // Inicialización
    loadTranslations('es');
    loadIdeas();
</script>
<?php
include 'includes/footer.php';
?>
