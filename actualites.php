<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'actualites';
$page_title = 'Actualités';
require_once __DIR__ . '/includes/header.php';

// Placeholder for news (using publications as example)
$stmt = $pdo->query("SELECT * FROM publications ORDER BY created_at DESC LIMIT 10");
$actualites = $stmt->fetchAll();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Actualités</h2>
        
        <?php if (empty($actualites)): ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-newspaper" style="font-size: 3rem; color: var(--color-text-light); margin-bottom: 1rem;"></i>
                <p>Aucune actualité pour le moment.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="grid grid-3">
            <?php foreach ($actualites as $actu): ?>
            <div class="card">
                <div class="card-body">
                    <span class="badge badge-info" style="margin-bottom: 0.5rem;"><?= e($actu['type']) ?></span>
                    <h4 style="margin-bottom: 0.75rem; font-size: 1rem;"><?= e($actu['titre']) ?></h4>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 1rem;">
                        <i class="fas fa-calendar"></i> <?= formatDate($actu['created_at']) ?>
                    </p>
                    <a href="#" class="btn btn-sm btn-outline" style="width: 100%;">
                        <i class="fas fa-eye"></i> Lire plus
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
