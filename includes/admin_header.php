<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auto-login for presentation purposes
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_name'] = 'Administrateur';
    $_SESSION['admin_email'] = 'admin@iutfv.cm';
    $_SESSION['admin_role'] = 1;
}

$base_path = '/labo-iut-fotso/';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title ?? 'Panel Admin') ?> - URAIA</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_path ?>css/style.css">
    <link rel="stylesheet" href="<?= $base_path ?>css/responsive.css">
    <link rel="stylesheet" href="<?= $base_path ?>css/admin.css">
</head>
<body class="light-mode admin-body">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="<?= $base_path ?>">
                    <i class="fas fa-flask"></i>
                    <span>URAIA Admin</span>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="<?= $base_path ?>admin/dashboard.php" class="<?= ($current_page ?? '') == 'dashboard' ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?= $base_path ?>admin/equipes.php" class="<?= ($current_page ?? '') == 'equipes' ? 'active' : '' ?>"><i class="fas fa-users"></i> Équipes</a></li>
                    <li><a href="<?= $base_path ?>admin/chercheurs.php" class="<?= ($current_page ?? '') == 'chercheurs' ? 'active' : '' ?>"><i class="fas fa-user-graduate"></i> Chercheurs</a></li>
                    <li><a href="<?= $base_path ?>admin/publications.php" class="<?= ($current_page ?? '') == 'publications' ? 'active' : '' ?>"><i class="fas fa-book"></i> Publications</a></li>
                    <li><a href="<?= $base_path ?>admin/projets.php" class="<?= ($current_page ?? '') == 'projets' ? 'active' : '' ?>"><i class="fas fa-project-diagram"></i> Projets</a></li>
                    <li><a href="<?= $base_path ?>admin/collaborations.php" class="<?= ($current_page ?? '') == 'collaborations' ? 'active' : '' ?>"><i class="fas fa-handshake"></i> Collaborations</a></li>
                    <li><a href="<?= $base_path ?>admin/evenements.php" class="<?= ($current_page ?? '') == 'evenements' ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Événements</a></li>
                    <li><a href="<?= $base_path ?>admin/actualites.php" class="<?= ($current_page ?? '') == 'actualites' ? 'active' : '' ?>"><i class="fas fa-newspaper"></i> Actualités</a></li>
                    <li><a href="<?= $base_path ?>admin/requetes.php" class="<?= ($current_page ?? '') == 'requetes' ? 'active' : '' ?>"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="<?= $base_path ?>admin/utilisateurs.php" class="<?= ($current_page ?? '') == 'utilisateurs' ? 'active' : '' ?>"><i class="fas fa-user-shield"></i> Utilisateurs</a></li>
                    <li><a href="<?= $base_path ?>admin/documents.php" class="<?= ($current_page ?? '') == 'documents' ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> Documents</a></li>
                    <li><a href="<?= $base_path ?>admin/ressources.php" class="<?= ($current_page ?? '') == 'ressources' ? 'active' : '' ?>"><i class="fas fa-tools"></i> Ressources</a></li>
                    <li><a href="<?= $base_path ?>" target="_blank"><i class="fas fa-external-link-alt"></i> Voir le site</a></li>
                    <li><a href="<?= $base_path ?>admin/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="admin-content">
            <!-- Top Bar -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <button class="sidebar-toggle" id="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1><?= e($page_title ?? 'Dashboard') ?></h1>
                </div>
                
                <div class="admin-header-right">
                    <div class="user-info">
                        <span class="user-name"><?= e($_SESSION['admin_name']) ?></span>
                        <span class="user-role">Administrateur</span>
                    </div>
                    <button id="theme-toggle" class="btn-icon">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </header>
            
            <!-- Flash Messages -->
            <?php if ($flash = getFlashMessage()): ?>
            <div class="flash-message flash-<?= e($flash['type']) ?>">
                <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= e($flash['message']) ?>
                <button class="close-flash"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?>
            
            <!-- Page Content -->
            <div class="admin-page-content">
