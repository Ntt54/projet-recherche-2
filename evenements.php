<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'evenements';
$page_title = 'Événements';
require_once __DIR__ . '/includes/header.php';

// Placeholder for events (table not in schema but required by spec)
$evenements = [];
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nos Événements</h2>
        
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <i class="fas fa-calendar-alt" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 1rem;">Calendrier des événements</h3>
                <p style="color: var(--color-text-light); max-width: 600px; margin: 0 auto 2rem;">
                    Découvrez nos prochains séminaires, conférences, ateliers et autres événements scientifiques.
                </p>
                
                <div style="background-color: rgba(0,0,0,0.02); padding: 2rem; border-radius: var(--radius-md);">
                    <p><strong>Aucun événement programmé pour le moment.</strong></p>
                    <p style="font-size: 0.9rem; color: var(--color-text-light);">
                        Restez connecté pour découvrir nos prochaines activités.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
