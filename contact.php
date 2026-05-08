<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = 'contact';
$page_title = 'Contact';
require_once __DIR__ . '/includes/header.php';

$message_sent = false;
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $objet = trim($_POST['objet'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if ($nom && $email && $objet && $description) {
        try {
            $stmt = $pdo->prepare("INSERT INTO requetes (nom, email, objet, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $objet, $description]);
            $message_sent = true;
        } catch (PDOException $e) {
            $error_message = "Erreur lors de l'envoi du message: " . $e->getMessage();
        }
    } else {
        $error_message = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<section class="page-section">
    <div class="container">
        <h2 class="section-title">Nous Contacter</h2>
        
        <?php if ($message_sent): ?>
        <div class="flash-message flash-success" style="margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i>
            Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.
        </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
        <div class="flash-message flash-error" style="margin-bottom: 2rem;">
            <i class="fas fa-exclamation-circle"></i>
            <?= e($error_message) ?>
        </div>
        <?php endif; ?>
        
        <div class="grid grid-2">
            <!-- Contact Form -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-paper-plane"></i> Envoyez-nous un message</h3>
                </div>
                <div class="card-body">
                    <form id="contact-form" method="POST" action="">
                        <div class="form-group">
                            <label for="nom">Nom complet *</label>
                            <input type="text" id="nom" name="nom" class="form-control" required placeholder="Votre nom">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Adresse email *</label>
                            <input type="email" id="email" name="email" class="form-control" required placeholder="votre@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="objet">Objet *</label>
                            <input type="text" id="objet" name="objet" class="form-control" required placeholder="Sujet de votre message">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Message *</label>
                            <textarea id="description" name="description" class="form-control" required placeholder="Votre message..." maxlength="1000"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-send"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3><i class="fas fa-map-marker-alt"></i> Nos Coordonnées</h3>
                    </div>
                    <div class="card-body">
                        <ul class="contact-info" style="list-style: none;">
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-map-marker-alt" style="color: var(--color-accent); width: 25px;"></i>
                                <strong>Adresse :</strong><br>
                                IUT Fotso Victor, Bandjoun<br>
                                Université de Dschang, Cameroun
                            </li>
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-phone" style="color: var(--color-accent); width: 25px;"></i>
                                <strong>Téléphone :</strong><br>
                                +237 600 00 00 00
                            </li>
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-envelope" style="color: var(--color-accent); width: 25px;"></i>
                                <strong>Email :</strong><br>
                                contact@iutfv.cm
                            </li>
                            <li style="margin-bottom: 1rem;">
                                <i class="fas fa-clock" style="color: var(--color-accent); width: 25px;"></i>
                                <strong>Horaires :</strong><br>
                                Lundi - Vendredi: 8h00 - 18h00
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Google Maps Placeholder -->
                <div class="card">
                    <div class="card-body" style="padding: 0; overflow: hidden; border-radius: var(--radius-lg);">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.466262995772!2d10.4167!3d5.5!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1061a4c0b0b0b0b0%3A0x0!2sBandjoun!5e0!3m2!1sfr!2scm!4v1234567890" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
