<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'partenaires';
$page_title = 'Partenaires';
require_once __DIR__ . '/includes/header.php';

// Fetch all collaborations
$stmt = $pdo->query("SELECT * FROM collaboration ORDER BY nom_organisme");
$partenaires = $stmt->fetchAll();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Partenaires</h2>
        
        <?php if (empty($partenaires)): ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--color-text-light); margin-bottom: 1rem;"></i>
                <p>Aucun partenaire enregistré pour le moment.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="grid grid-4">
            <?php foreach ($partenaires as $partenaire): ?>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                        <i class="fas fa-handshake"></i>
                    </div>
                    
                    <h4 style="margin-bottom: 0.5rem;"><?= e($partenaire['nom_organisme']) ?></h4>
                    
                    <?php if ($partenaire['pays']): ?>
                    <p style="color: var(--color-text-light); font-size: 0.9rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-map-marker-alt"></i> <?= e($partenaire['pays']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($partenaire['interlocuteur']): ?>
                    <p style="font-size: 0.85rem; margin-bottom: 0.25rem;">
                        <i class="fas fa-user"></i> <?= e($partenaire['interlocuteur']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($partenaire['telephone']): ?>
                    <p style="font-size: 0.85rem; color: var(--color-text-light);">
                        <i class="fas fa-phone"></i> +<?= e($partenaire['telephone']) ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action -->
<section class="page-section" style="background-color: rgba(0,0,0,0.02);">
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); color: white; text-align: center;">
            <div class="card-body" style="padding: 3rem 2rem;">
                <h2 style="font-family: var(--font-secondary); margin-bottom: 1rem;">
                    <i class="fas fa-handshake"></i> Devenez Partenaire
                </h2>
                <p style="max-width: 600px; margin: 0 auto 2rem; opacity: 0.9;">
                    Vous souhaitez collaborer avec notre laboratoire ? Rejoignez notre réseau de partenaires académiques et industriels.
                </p>
                <a href="<?= $base_path ?>contact.php" class="btn btn-primary" style="background-color: var(--color-accent);">
                    <i class="fas fa-paper-plane"></i> Nous contacter
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
