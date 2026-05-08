<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'dashboard';
$page_title = 'Tableau de Bord';
require_once __DIR__ . '/../includes/admin_header.php';

// Fetch statistics
$stats = [];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM equipe");
$stats['equipes'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM membre");
$stats['chercheurs'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM publications");
$stats['publications'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM projet");
$stats['projets'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM collaboration");
$stats['collaborations'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
$stats['utilisateurs'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM requetes WHERE statut = 'non lu'");
$stats['messages_non_lus'] = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM document");
$stats['documents'] = $stmt->fetch()['count'];
?>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['equipes'] ?></h3>
            <p>Équipes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['chercheurs'] ?></h3>
            <p>Chercheurs</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['publications'] ?></h3>
            <p>Publications</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-project-diagram"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['projets'] ?></h3>
            <p>Projets</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-handshake"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['collaborations'] ?></h3>
            <p>Collaborations</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['documents'] ?></h3>
            <p>Documents</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['utilisateurs'] ?></h3>
            <p>Utilisateurs</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['messages_non_lus'] ?></h3>
            <p>Messages non lus</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2><i class="fas fa-bolt"></i> Actions Rapides</h2>
    </div>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="publication_add.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle publication
        </a>
        <a href="projet_add.php" class="btn btn-secondary">
            <i class="fas fa-plus"></i> Nouveau projet
        </a>
        <a href="chercheur_add.php" class="btn btn-outline">
            <i class="fas fa-plus"></i> Nouveau chercheur
        </a>
        <a href="equipe_add.php" class="btn btn-outline">
            <i class="fas fa-plus"></i> Nouvelle équipe
        </a>
        <a href="requete.php" class="btn btn-outline">
            <i class="fas fa-envelope"></i> Voir les messages
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-2">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2><i class="fas fa-clock"></i> Dernières Publications</h2>
            <a href="publications.php" class="btn btn-sm btn-outline">Voir tout</a>
        </div>
        <?php
        $stmt = $pdo->query("SELECT * FROM publications ORDER BY created_at DESC LIMIT 5");
        $publications = $stmt->fetchAll();
        ?>
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Année</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($publications as $pub): ?>
                <tr>
                    <td><?= e($pub['titre']) ?></td>
                    <td><span class="badge badge-info"><?= e($pub['type']) ?></span></td>
                    <td><?= e($pub['annee']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="admin-card">
        <div class="admin-card-header">
            <h2><i class="fas fa-folder"></i> Derniers Projets</h2>
            <a href="projets.php" class="btn btn-sm btn-outline">Voir tout</a>
        </div>
        <?php
        $stmt = $pdo->query("SELECT * FROM projet ORDER BY created_at DESC LIMIT 5");
        $projets = $stmt->fetchAll();
        ?>
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Intitulé</th>
                    <th>Domaine</th>
                    <th>Priorité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $projet): ?>
                <tr>
                    <td><?= e($projet['intitule']) ?></td>
                    <td><?= e($projet['domaine']) ?></td>
                    <td><span class="badge badge-success"><?= e($projet['priorite']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
