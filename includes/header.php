<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$base_path = '/labo-iut-fotso/';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title ?? 'Laboratoire de Recherche IUT Fotso Victor') ?> - URAIA</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_path ?>css/style.css">
    <link rel="stylesheet" href="<?= $base_path ?>css/responsive.css">
</head>
<body class="light-mode">
    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">
            <div class="logo">
                <a href="<?= $base_path ?>">
                    <i class="fas fa-flask"></i>
                    <span>URAIA</span>
                </a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= $base_path ?>" class="<?= ($current_page ?? '') == 'home' ? 'active' : '' ?>"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="<?= $base_path ?>about.php" class="<?= ($current_page ?? '') == 'about' ? 'active' : '' ?>"><i class="fas fa-info-circle"></i> À propos</a></li>
                    <li><a href="<?= $base_path ?>equipes.php" class="<?= ($current_page ?? '') == 'equipes' ? 'active' : '' ?>"><i class="fas fa-users"></i> Équipes</a></li>
                    <li><a href="<?= $base_path ?>chercheurs.php" class="<?= ($current_page ?? '') == 'chercheurs' ? 'active' : '' ?>"><i class="fas fa-user-graduate"></i> Chercheurs</a></li>
                    <li><a href="<?= $base_path ?>publications.php" class="<?= ($current_page ?? '') == 'publications' ? 'active' : '' ?>"><i class="fas fa-book"></i> Publications</a></li>
                    <li><a href="<?= $base_path ?>projets.php" class="<?= ($current_page ?? '') == 'projets' ? 'active' : '' ?>"><i class="fas fa-project-diagram"></i> Projets</a></li>
                    <li><a href="<?= $base_path ?>evenements.php" class="<?= ($current_page ?? '') == 'evenements' ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Événements</a></li>
                    <li><a href="<?= $base_path ?>actualites.php" class="<?= ($current_page ?? '') == 'actualites' ? 'active' : '' ?>"><i class="fas fa-newspaper"></i> Actualités</a></li>
                    <li><a href="<?= $base_path ?>partenaires.php" class="<?= ($current_page ?? '') == 'partenaires' ? 'active' : '' ?>"><i class="fas fa-handshake"></i> Partenaires</a></li>
                    <li><a href="<?= $base_path ?>contact.php" class="<?= ($current_page ?? '') == 'contact' ? 'active' : '' ?>"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <button id="theme-toggle" class="btn-icon" title="Changer le thème">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="<?= $base_path ?>admin/login.php" class="btn btn-primary">
                    <i class="fas fa-lock"></i> Admin
                </a>
                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
    
    <main class="main-content">
