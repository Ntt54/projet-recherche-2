<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'chercheurs';
$page_title = 'Chercheurs';
require_once __DIR__ . '/includes/header.php';

// Get filters
$equipe_filter = $_GET['equipe'] ?? '';
$grade_filter = $_GET['grade'] ?? '';

// Build query
$sql = "SELECT m.*, 
        (SELECT GROUP_CONCAT(e.nom SEPARATOR ', ') FROM affecter a 
         JOIN equipe e ON a.numero = e.numero WHERE a.idmembre = m.idmembre) as equipes
        FROM membre m WHERE 1=1";

$params = [];

if ($equipe_filter) {
    $sql .= " AND EXISTS (SELECT 1 FROM affecter WHERE idmembre = m.idmembre AND numero = ?)";
    $params[] = $equipe_filter;
}

$sql .= " ORDER BY m.nom, m.prenom";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$chercheurs = $stmt->fetchAll();

// Get all teams for filter
$stmt = $pdo->query("SELECT * FROM equipe ORDER BY nom");
$equipes = $stmt->fetchAll();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Chercheurs</h2>
        
        <!-- Filters -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-body">
                <form method="GET" action="" class="filters-bar">
                    <div class="filter-group">
                        <label for="equipe"><i class="fas fa-users"></i> Équipe</label>
                        <select name="equipe" id="equipe" class="form-control" style="min-width: 200px;">
                            <option value="">Toutes les équipes</option>
                            <?php foreach ($equipes as $eq): ?>
                            <option value="<?= $eq['numero'] ?>" <?= $equipe_filter == $eq['numero'] ? 'selected' : '' ?>>
                                <?= e($eq['nom']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group" style="align-self: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                        <a href="chercheurs.php" class="btn btn-outline">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <p style="margin-bottom: 1.5rem; color: var(--color-text-light);">
            <i class="fas fa-user-graduate"></i> <?= count($chercheurs) ?> chercheur(s) trouvé(s)
        </p>
        
        <?php if (empty($chercheurs)): ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--color-text-light); margin-bottom: 1rem;"></i>
                <p>Aucun chercheur ne correspond à vos critères de recherche.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="grid grid-4">
            <?php foreach ($chercheurs as $ch): ?>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2.5rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    
                    <h4 style="margin-bottom: 0.25rem;"><?= e($ch['prenom']) ?> <?= e($ch['nom']) ?></h4>
                    
                    <?php if ($ch['specialite']): ?>
                    <p style="color: var(--color-text-light); font-size: 0.9rem; margin-bottom: 0.5rem;">
                        <?= e($ch['specialite']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($ch['role']): ?>
                    <span class="badge badge-info" style="margin-bottom: 0.5rem;"><?= e($ch['role']) ?></span>
                    <?php endif; ?>
                    
                    <?php if ($ch['email']): ?>
                    <p style="font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-envelope"></i> <?= e($ch['email']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($ch['equipes']): ?>
                    <p style="font-size: 0.85rem; color: var(--color-text-light);">
                        <i class="fas fa-users"></i> <?= e($ch['equipes']) ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
