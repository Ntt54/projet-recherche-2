<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = '404';
$page_title = 'Page non trouvée';
http_response_code(404);
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-section" style="min-height: 60vh; display: flex; align-items: center; justify-content: center;">
    <div class="container" style="text-align: center;">
        <div style="font-size: 8rem; color: var(--color-primary); margin-bottom: 1rem;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1 style="font-family: var(--font-secondary); font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;">
            404 - Page non trouvée
        </h1>
        <p style="color: var(--color-text-light); font-size: 1.2rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        <a href="<?= $base_path ?>" class="btn btn-primary">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
