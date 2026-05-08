<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'publications';
$page_title = 'Publications';
require_once __DIR__ . '/includes/header.php';

// Get filters
$equipe_filter = $_GET['equipe'] ?? '';
$annee_debut = $_GET['annee_debut'] ?? '';
$annee_fin = $_GET['annee_fin'] ?? '';

// Build query
$sql = "SELECT p.*, u.name as auteur_principal, e.nom as equipe_nom 
        FROM publications p 
        LEFT JOIN users u ON p.iduser = u.id 
        LEFT JOIN membre m ON u.email = m.email
        LEFT JOIN affecter a ON m.idmembre = a.idmembre
        LEFT JOIN equipe e ON a.numero = e.numero
        WHERE 1=1";

$params = [];

if ($equipe_filter) {
    $sql .= " AND a.numero = ?";
    $params[] = $equipe_filter;
}

if ($annee_debut) {
    $sql .= " AND p.annee >= ?";
    $params[] = $annee_debut;
}

if ($annee_fin) {
    $sql .= " AND p.annee <= ?";
    $params[] = $annee_fin;
}

$sql .= " ORDER BY p.annee DESC, p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$publications = $stmt->fetchAll();

// Get all teams for filter
$stmt = $pdo->query("SELECT * FROM equipe ORDER BY nom");
$equipes = $stmt->fetchAll();

// Get year range
$stmt = $pdo->query("SELECT MIN(annee) as min_annee, MAX(annee) as max_annee FROM publications");
$year_range = $stmt->fetch();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Publications Scientifiques</h2>
        
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
                    
                    <div class="filter-group">
                        <label for="annee_debut"><i class="fas fa-calendar"></i> De l'année</label>
                        <input type="number" name="annee_debut" id="annee_debut" class="form-control" 
                               placeholder="YYYY" min="<?= $year_range['min_annee'] ?? '2020' ?>" 
                               max="<?= $year_range['max_annee'] ?? date('Y') ?>" value="<?= e($annee_debut) ?>" style="width: 120px;">
                    </div>
                    
                    <div class="filter-group">
                        <label for="annee_fin">À l'année</label>
                        <input type="number" name="annee_fin" id="annee_fin" class="form-control" 
                               placeholder="YYYY" min="<?= $year_range['min_annee'] ?? '2020' ?>" 
                               max="<?= $year_range['max_annee'] ?? date('Y') ?>" value="<?= e($annee_fin) ?>" style="width: 120px;">
                    </div>
                    
                    <div class="filter-group" style="align-self: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                        <a href="publications.php" class="btn btn-outline">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Results count -->
        <p style="margin-bottom: 1.5rem; color: var(--color-text-light);">
            <i class="fas fa-book"></i> <?= count($publications) ?> publication(s) trouvée(s)
        </p>
        
        <?php if (empty($publications)): ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--color-text-light); margin-bottom: 1rem;"></i>
                <p>Aucune publication ne correspond à vos critères de recherche.</p>
                <a href="publications.php" class="btn btn-outline" style="margin-top: 1rem;">
                    <i class="fas fa-redo"></i> Voir toutes les publications
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="grid grid-3">
            <?php foreach ($publications as $pub): ?>
            <div class="card">
                <div class="card-body">
                    <span class="badge badge-info" style="margin-bottom: 0.5rem;"><?= e($pub['type']) ?></span>
                    <h4 style="margin-bottom: 0.75rem; font-size: 1rem; line-height: 1.4;">
                        <?= e($pub['titre']) ?>
                    </h4>
                    
                    <?php if ($pub['auteurs']): ?>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-user-edit"></i> <?= e($pub['auteurs']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($pub['source']): ?>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-newspaper"></i> <?= e($pub['source']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($pub['equipe_nom']): ?>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-users"></i> <?= e($pub['equipe_nom']) ?>
                    </p>
                    <?php endif; ?>
                    
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 1rem;">
                        <i class="fas fa-calendar"></i> Année: <?= e($pub['annee']) ?>
                    </p>
                    
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn btn-sm btn-outline" style="flex: 1;">
                            <i class="fas fa-eye"></i> Détails
                        </button>
                        <?php if ($pub['cover']): ?>
                        <a href="<?= $base_path ?>uploads/pdf/<?= e($pub['cover']) ?>" class="btn btn-sm btn-primary" target="_blank">
                            <i class="fas fa-download"></i> PDF
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
