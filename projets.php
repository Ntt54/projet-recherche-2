<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'projets';
$page_title = 'Projets de Recherche';
require_once __DIR__ . '/includes/header.php';

// Get filters
$status_filter = $_GET['statut'] ?? '';
$annee_debut = $_GET['annee_debut'] ?? '';
$annee_fin = $_GET['annee_fin'] ?? '';

// Build query
$sql = "SELECT p.*, l.nom as labo_nom,
        (SELECT GROUP_CONCAT(m.nom SEPARATOR ', ') FROM intervenir i 
         JOIN membre m ON i.idmembre = m.idmembre WHERE i.idpro = p.idpro) as membres,
        (SELECT GROUP_CONCAT(c.nom_organisme SEPARATOR ', ') FROM participer pa 
         JOIN collaboration c ON pa.idcol = c.idcol WHERE pa.idpro = p.idpro) as bailleurs
        FROM projet p
        LEFT JOIN laboratoire l ON p.idlab = l.idlab
        WHERE 1=1";

$params = [];

if ($status_filter === 'en_cours') {
    $sql .= " AND p.datefin >= CURDATE()";
} elseif ($status_filter === 'termine') {
    $sql .= " AND p.datefin < CURDATE()";
}

if ($annee_debut) {
    $sql .= " AND YEAR(p.datedebut) >= ?";
    $params[] = $annee_debut;
}

if ($annee_fin) {
    $sql .= " AND YEAR(p.datefin) <= ?";
    $params[] = $annee_fin;
}

$sql .= " ORDER BY p.datedebut DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$projets = $stmt->fetchAll();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Projets de Recherche</h2>
        
        <!-- Filters -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-body">
                <form method="GET" action="" class="filters-bar">
                    <div class="filter-group">
                        <label for="statut"><i class="fas fa-tasks"></i> Statut</label>
                        <select name="statut" id="statut" class="form-control" style="min-width: 180px;">
                            <option value="">Tous les statuts</option>
                            <option value="en_cours" <?= $status_filter === 'en_cours' ? 'selected' : '' ?>>En cours</option>
                            <option value="termine" <?= $status_filter === 'termine' ? 'selected' : '' ?>>Terminé</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="annee_debut"><i class="fas fa-calendar"></i> De l'année</label>
                        <input type="number" name="annee_debut" id="annee_debut" class="form-control" 
                               placeholder="YYYY" min="2020" max="<?= date('Y') ?>" value="<?= e($annee_debut) ?>" style="width: 120px;">
                    </div>
                    
                    <div class="filter-group">
                        <label for="annee_fin">À l'année</label>
                        <input type="number" name="annee_fin" id="annee_fin" class="form-control" 
                               placeholder="YYYY" min="2020" max="<?= date('Y') ?>" value="<?= e($annee_fin) ?>" style="width: 120px;">
                    </div>
                    
                    <div class="filter-group" style="align-self: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                        <a href="projets.php" class="btn btn-outline">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if (empty($projets)): ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--color-text-light); margin-bottom: 1rem;"></i>
                <p>Aucun projet ne correspond à vos critères de recherche.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="grid grid-2">
            <?php foreach ($projets as $projet): 
                $is_en_cours = strtotime($projet['datefin']) >= time();
            ?>
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0; flex: 1;"><i class="fas fa-project-diagram"></i> <?= e($projet['intitule']) ?></h4>
                    <span class="badge <?= $is_en_cours ? 'badge-success' : 'badge-secondary' ?>">
                        <?= $is_en_cours ? 'En cours' : 'Terminé' ?>
                    </span>
                </div>
                <div class="card-body">
                    <p style="color: var(--color-text-light); margin-bottom: 1rem;">
                        <i class="fas fa-tag"></i> <?= e($projet['domaine']) ?>
                    </p>
                    
                    <?php if ($projet['description']): ?>
                    <p style="margin-bottom: 1rem;"><?= nl2br(e($projet['description'])) ?></p>
                    <?php endif; ?>
                    
                    <p style="margin-bottom: 0.5rem;">
                        <strong><i class="fas fa-calendar-alt"></i> Période :</strong><br>
                        <?= formatDate($projet['datedebut']) ?> - <?= formatDate($projet['datefin']) ?>
                    </p>
                    
                    <p style="margin-bottom: 0.5rem;">
                        <strong><i class="fas fa-star"></i> Priorité :</strong>
                        <span class="badge badge-success"><?= e($projet['priorite']) ?></span>
                    </p>
                    
                    <?php if ($projet['membres']): ?>
                    <p style="margin-bottom: 0.5rem;">
                        <strong><i class="fas fa-users"></i> Membres :</strong><br>
                        <small><?= e($projet['membres']) ?></small>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($projet['bailleurs']): ?>
                    <p style="margin-bottom: 1rem;">
                        <strong><i class="fas fa-handshake"></i> Financeurs :</strong><br>
                        <small><?= e($projet['bailleurs']) ?></small>
                    </p>
                    <?php endif; ?>
                    
                    <a href="#" class="btn btn-sm btn-outline" style="width: 100%;">
                        <i class="fas fa-eye"></i> Voir les détails
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
