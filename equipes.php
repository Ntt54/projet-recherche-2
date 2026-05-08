<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'equipes';
$page_title = 'Équipes de Recherche';
require_once __DIR__ . '/includes/header.php';

// Fetch all teams with member count
$stmt = $pdo->query("SELECT e.*, 
                     (SELECT COUNT(*) FROM affecter WHERE numero = e.numero) as nb_membres
                     FROM equipe e ORDER BY e.nom");
$equipes = $stmt->fetchAll();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Équipes de Recherche</h2>
        
        <?php if (empty($equipes)): ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--color-text-light); margin-bottom: 1rem;"></i>
                <p>Aucune équipe enregistrée pour le moment.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="grid grid-3">
            <?php foreach ($equipes as $eq): ?>
            <div class="card" data-category="<?= strtolower(e($eq['domaine'])) ?>">
                <div class="card-header" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                    <h4 style="margin: 0;"><i class="fas fa-users"></i> <?= e($eq['nom']) ?></h4>
                </div>
                <div class="card-body">
                    <p style="color: var(--color-text-light); margin-bottom: 1rem;">
                        <i class="fas fa-tag"></i> <?= e($eq['domaine']) ?>
                    </p>
                    
                    <?php if ($eq['chef']): ?>
                    <p style="margin-bottom: 1rem;">
                        <strong><i class="fas fa-user-tie"></i> Chef d'équipe :</strong><br>
                        <?= e($eq['chef']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <p style="margin-bottom: 1rem;">
                        <span class="badge badge-info">
                            <i class="fas fa-users"></i> <?= $eq['nb_membres'] ?? $eq['effectif'] ?? 0 ?> membres
                        </span>
                    </p>
                    
                    <a href="<?= $base_path ?>chercheurs.php?equipe=<?= $eq['numero'] ?>" class="btn btn-sm btn-outline" style="width: 100%; justify-content: center;">
                        <i class="fas fa-list"></i> Voir les membres
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Filter Section -->
<section class="page-section" style="background-color: rgba(0,0,0,0.02);">
    <div class="container">
        <h3 style="text-align: center; margin-bottom: 2rem;">Filtrer par domaine</h3>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <button class="btn btn-outline active" data-filter="all" data-target=".grid-3">
                <i class="fas fa-th"></i> Tous
            </button>
            <?php
            $domaines = array_unique(array_column($equipes, 'domaine'));
            foreach ($domaines as $domaine):
            ?>
            <button class="btn btn-outline" data-filter="<?= strtolower(e($domaine)) ?>" data-target=".grid-3">
                <i class="fas fa-filter"></i> <?= e($domaine) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
