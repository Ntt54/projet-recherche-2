<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'about';
$page_title = 'À Propos';
require_once __DIR__ . '/includes/header.php';

// Fetch laboratory info
$stmt = $pdo->query("SELECT * FROM laboratoire LIMIT 1");
$laboratoire = $stmt->fetch();

// Fetch bureau info
$stmt = $pdo->query("SELECT * FROM bureau LIMIT 1");
$bureau = $stmt->fetch();

// Fetch mandat
$stmt = $pdo->query("SELECT * FROM mandat ORDER BY created_at DESC LIMIT 1");
$mandat = $stmt->fetch();
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">À Propos du Laboratoire</h2>
        
        <div class="grid grid-2" style="margin-bottom: 3rem;">
            <div>
                <div class="card">
                    <div class="card-body">
                        <h3 style="color: var(--color-primary); margin-bottom: 1rem;">
                            <i class="fas fa-flask" style="color: var(--color-accent);"></i> 
                            <?= e($laboratoire['nom'] ?? 'Laboratoire de Recherche') ?>
                        </h3>
                        <p><?= nl2br(e($laboratoire['description'] ?? '')) ?></p>
                        
                        <?php if ($laboratoire['budget']): ?>
                        <p style="margin-top: 1rem;">
                            <strong>Budget :</strong> <?= e($laboratoire['budget']) ?>
                        </p>
                        <?php endif; ?>
                        
                        <?php if ($laboratoire['sourcebudget']): ?>
                        <p>
                            <strong>Source :</strong> <?= e($laboratoire['sourcebudget']) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-bullseye"></i> Notre Mission</h3>
                    </div>
                    <div class="card-body">
                        <ul style="list-style: none;">
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Produire une recherche scientifique d'excellence
                            </li>
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Former les chercheurs de demain
                            </li>
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Développer des innovations technologiques
                            </li>
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-check-circle" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                Contribuer au développement socio-économique
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bureau du laboratoire -->
        <?php if ($bureau): ?>
        <h3 style="color: var(--color-primary); margin: 2rem 0 1rem; text-align: center;">
            <i class="fas fa-users-cog"></i> Bureau du Laboratoire
        </h3>
        
        <?php if ($mandat): ?>
        <p style="text-align: center; margin-bottom: 2rem;">
            <span class="badge badge-success">Mandat : <?= e($mandat['periode']) ?></span>
        </p>
        <?php endif; ?>
        
        <div class="grid grid-4">
            <?php if ($bureau['directeur']): ?>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h4 style="margin-bottom: 0.25rem;">Directeur</h4>
                    <p style="color: var(--color-text-light);"><?= e($bureau['directeur']) ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($bureau['secretaire']): ?>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h4 style="margin-bottom: 0.25rem;">Secrétaire</h4>
                    <p style="color: var(--color-text-light);"><?= e($bureau['secretaire']) ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($bureau['tresorier']): ?>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h4 style="margin-bottom: 0.25rem;">Trésorier</h4>
                    <p style="color: var(--color-text-light);"><?= e($bureau['tresorier']) ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($bureau['charge_communication']): ?>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4facfe, #00f2fe); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h4 style="margin-bottom: 0.25rem;">Communication</h4>
                    <p style="color: var(--color-text-light);"><?= e($bureau['charge_communication']) ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Vision & Objectifs -->
<section class="page-section" style="background-color: rgba(0,0,0,0.02);">
    <div class="container">
        <h3 style="color: var(--color-primary); margin-bottom: 2rem; text-align: center;">
            <i class="fas fa-eye"></i> Notre Vision
        </h3>
        
        <div class="grid grid-3">
            <div class="card">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 1rem;">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h4 style="margin-bottom: 1rem;">Recherche Innovante</h4>
                    <p style="color: var(--color-text-light);">
                        Développer des solutions technologiques adaptées aux défis africains grâce à une recherche de pointe.
                    </p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 1rem;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 style="margin-bottom: 1rem;">Formation d'Excellence</h4>
                    <p style="color: var(--color-text-light);">
                        Former une nouvelle génération de chercheurs capables de relever les défis technologiques mondiaux.
                    </p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 1rem;">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h4 style="margin-bottom: 1rem;">Impact Sociétal</h4>
                    <p style="color: var(--color-text-light);">
                        Contribuer activement au développement économique et social du Cameroun et de l'Afrique centrale.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
