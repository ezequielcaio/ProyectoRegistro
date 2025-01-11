<?php
include 'includes/header.php';

// Inicialización del idioma
session_start();
$_SESSION['lang'] = $_SESSION['lang'] ?? 'es';
if (isset($_POST['lang'])) {
    $_SESSION['lang'] = $_POST['lang'];
}

// Cargar datos del JSON
$jsonData = file_get_contents('index.json');
$data = json_decode($jsonData, true)[$_SESSION['lang']];
?>

<!-- Selector de idioma -->
<div class="position-fixed top-0 end-0 m-4" style="z-index: 1000;">
    <form method="POST" id="langForm">
        <select class="form-select" name="lang" onchange="this.form.submit()">
            <option value="es" <?= $_SESSION['lang'] == 'es' ? 'selected' : '' ?>>Español</option>
            <option value="en" <?= $_SESSION['lang'] == 'en' ? 'selected' : '' ?>>English</option>
        </select>
    </form>
</div>

<!-- Carrusel Principal -->
<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($data['carousel'] as $index => $slide): ?>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $index ?>" 
                    <?= $index === 0 ? 'class="active"' : '' ?>></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($data['carousel'] as $index => $slide): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <?php if (strpos($slide['media'], '.mp4') !== false): ?>
                    <video class="d-block w-100" autoplay loop muted>
                        <source src="<?= $slide['media'] ?>" type="video/mp4">
                    </video>
                <?php else: ?>
                    <img src="<?= $slide['media'] ?>" class="d-block w-100" alt="<?= $slide['title'] ?>">
                <?php endif; ?>
                <div class="carousel-caption d-none d-md-block">
                    <h2><?= $slide['title'] ?></h2>
                    <p><?= $slide['description'] ?></p>
                    <a href="<?= $slide['button_link'] ?>" class="btn btn-primary"><?= $slide['button_text'] ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Servicios -->
<section class="container my-5">
    <h2 class="text-center mb-4"><?= $data['services']['title'] ?></h2>
    <div class="row g-4">
        <?php foreach ($data['services']['items'] as $service): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="bi <?= $service['icon'] ?>"></i>
                        </div>
                        <h3 class="card-title h5"><?= $service['title'] ?></h3>
                        <p class="card-text"><?= $service['description'] ?></p>
                        <a href="<?= $service['link'] ?>" class="btn btn-outline-primary mt-3">
                            <?= $data['services']['button_text'] ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Sección Destacada -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="<?= $data['featured']['image'] ?>" alt="Featured" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2><?= $data['featured']['title'] ?></h2>
                <p class="lead"><?= $data['featured']['description'] ?></p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="<?= $data['featured']['primary_button']['link'] ?>" class="btn btn-primary btn-lg px-4 me-md-2">
                        <?= $data['featured']['primary_button']['text'] ?>
                    </a>
                    <a href="<?= $data['featured']['secondary_button']['link'] ?>" class="btn btn-outline-secondary btn-lg px-4">
                        <?= $data['featured']['secondary_button']['text'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Noticias y Actualizaciones -->
<section class="container my-5">
    <h2 class="text-center mb-4"><?= $data['news']['title'] ?></h2>
    <div class="row">
        <?php foreach ($data['news']['items'] as $item): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['title'] ?></h5>
                        <p class="card-text"><?= $item['description'] ?></p>
                        <a href="<?= $item['link'] ?>" class="btn btn-link"><?= $data['news']['read_more'] ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Llamada a la acción -->
<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h2 class="mb-4"><?= $data['cta']['title'] ?></h2>
        <p class="lead mb-4"><?= $data['cta']['description'] ?></p>
        <a href="<?= $data['cta']['button_link'] ?>" class="btn btn-light btn-lg">
            <?= $data['cta']['button_text'] ?>
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>