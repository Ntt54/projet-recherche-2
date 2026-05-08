<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'home';
$page_title = 'Accueil';
require_once __DIR__ . '/includes/header.php';

// Fetch statistics
$stmt = $pdo->query("SELECT COUNT(*) as count FROM equipe");
$nb_equipes = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM membre");
$nb_chercheurs = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM publications");
$nb_publications = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM projet");
$nb_projets = $stmt->fetch()['count'];

// Fetch latest publications
$stmt = $pdo->query("SELECT p.*, u.name as auteur_name FROM publications p 
                     LEFT JOIN users u ON p.iduser = u.id 
                     ORDER BY p.created_at DESC LIMIT 3");
$latest_publications = $stmt->fetchAll();

// Fetch latest projects
$stmt = $pdo->query("SELECT * FROM projet ORDER BY created_at DESC LIMIT 3");
$latest_projets = $stmt->fetchAll();

// Fetch laboratory info
$stmt = $pdo->query("SELECT * FROM laboratoire LIMIT 1");
$laboratoire = $stmt->fetch();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Laboratoire de Recherche IUT Fotso Victor</h1>
        <p>Bienvenue sur le portail officiel du laboratoire de recherche de l'IUT Fotso Victor de Bandjoun. Découvrez nos équipes, nos projets innovants et nos publications scientifiques.</p>
        <div style="margin-top: 2rem;">
            <a href="<?= $base_path ?>publications.php" class="btn btn-primary" style="margin-right: 1rem;">
                <i class="fas fa-book"></i> Nos Publications
            </a>
            <a href="<?= $base_path ?>contact.php" class="btn btn-outline" style="background: white; color: var(--color-primary);">
                <i class="fas fa-envelope"></i> Nous Contacter
            </a>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="page-section">
    <div class="container">
        <h2 class="section-title">Chiffres Clés</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $nb_equipes ?></h3>
                    <p>Équipes de recherche</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $nb_chercheurs ?></h3>
                    <p>Chercheurs actifs</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $nb_publications ?></h3>
                    <p>Publications scientifiques</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $nb_projets ?></h3>
                    <p>Projets en cours</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="page-section" style="background-color: rgba(0,0,0,0.02);">
    <div class="container">
        <h2 class="section-title">À Propos du Laboratoire</h2>
        <div class="grid grid-2" style="align-items: center;">
            <div>
                <p style="margin-bottom: 1rem;">
                    Le Laboratoire de Recherche de l'IUT Fotso Victor de Bandjoun est un centre d'excellence dédié à l'innovation technologique et à la recherche scientifique appliquée.
                </p>
                <p style="margin-bottom: 1rem;">
                    Nos équipes travaillent sur des thématiques variées allant de l'intelligence artificielle à la cybersécurité, en passant par le génie logiciel et les réseaux informatiques.
                </p>
                <p>
                    Forts de collaborations nationales et internationales, nous contribuons activement au développement technologique du Cameroun et de l'Afrique centrale.
                </p>
                <a href="<?= $base_path ?>about.php" class="btn btn-primary" style="margin-top: 1.5rem;">
                    <i class="fas fa-info-circle"></i> En savoir plus
                </a>
            </div>
            <div>
                <div class="card">
                    <div class="card-body">
                        <h3 style="color: var(--color-primary); margin-bottom: 1rem;">
                            <i class="fas fa-bullseye" style="color: var(--color-accent);"></i> Notre Mission
                        </h3>
                        <ul style="list-style: none;">
                            <li style="margin-bottom: 0.75rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Produire une recherche scientifique de qualité
                            </li>
                            <li style="margin-bottom: 0.75rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Former la prochaine génération de chercheurs
                            </li>
                            <li style="margin-bottom: 0.75rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Développer des solutions technologiques innovantes
                            </li>
                            <li style="margin-bottom: 0.75rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Collaborer avec les acteurs socio-économiques
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Publications -->
<section class="page-section">
    <div class="container">
        <h2 class="section-title">Dernières Publications</h2>
        <div class="grid grid-3">
            <?php foreach ($latest_publications as $pub): ?>
            <div class="card">
                <div class="card-body">
                    <span class="badge badge-info" style="margin-bottom: 0.5rem;"><?= e($pub['type']) ?></span>
                    <h4 style="margin-bottom: 0.5rem; font-size: 1rem;"><?= e($pub['titre']) ?></h4>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-user"></i> <?= e($pub['auteurs']) ?>
                    </p>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-calendar"></i> <?= e($pub['annee']) ?>
                    </p>
                    <a href="<?= $base_path ?>publications.php" class="btn btn-sm btn-outline" style="margin-top: 0.5rem;">
                        Voir plus <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?= $base_path ?>publications.php" class="btn btn-primary">
                <i class="fas fa-book"></i> Toutes les publications
            </a>
        </div>
    </div>
</section>

<!-- Latest Projects -->
<section class="page-section" style="background-color: rgba(0,0,0,0.02);">
    <div class="container">
        <h2 class="section-title">Projets Récents</h2>
        <div class="grid grid-3">
            <?php foreach ($latest_projets as $projet): ?>
            <div class="card">
                <div class="card-body">
                    <span class="badge badge-success" style="margin-bottom: 0.5rem;"><?= e($projet['priorite']) ?></span>
                    <h4 style="margin-bottom: 0.5rem; font-size: 1rem;"><?= e($projet['intitule']) ?></h4>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-tag"></i> <?= e($projet['domaine']) ?>
                    </p>
                    <p style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-calendar-alt"></i> 
                        <?= formatDate($projet['datedebut']) ?> - <?= formatDate($projet['datefin']) ?>
                    </p>
                    <a href="<?= $base_path ?>projets.php" class="btn btn-sm btn-outline" style="margin-top: 0.5rem;">
                        Voir plus <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?= $base_path ?>projets.php" class="btn btn-primary">
                <i class="fas fa-project-diagram"></i> Tous les projets
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="page-section">
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); color: white; text-align: center;">
            <div class="card-body" style="padding: 3rem 2rem;">
                <h2 style="font-family: var(--font-secondary); margin-bottom: 1rem;">
                    Vous souhaitez collaborer avec nous ?
                </h2>
                <p style="max-width: 600px; margin: 0 auto 2rem; opacity: 0.9;">
                    Nous sommes toujours ouverts aux partenariats scientifiques et aux collaborations de recherche. N'hésitez pas à nous contacter pour discuter de vos projets.
                </p>
                <a href="<?= $base_path ?>contact.php" class="btn btn-primary" style="background-color: var(--color-accent);">
                    <i class="fas fa-paper-plane"></i> Prendre contact
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
