    </main>
    
    <!-- Footer -->
    <footer class="main-footer">
        <div class="container footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-flask"></i> URAIA</h3>
                <p>Laboratoire de Recherche de l'IUT Fotso Victor de Bandjoun</p>
                <p>Université de Dschang - Cameroun</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Liens Rapides</h4>
                <ul>
                    <li><a href="<?= $base_path ?>about.php">À propos</a></li>
                    <li><a href="<?= $base_path ?>equipes.php">Équipes de recherche</a></li>
                    <li><a href="<?= $base_path ?>publications.php">Publications</a></li>
                    <li><a href="<?= $base_path ?>projets.php">Projets</a></li>
                    <li><a href="<?= $base_path ?>contact.php">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact</h4>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> IUT Fotso Victor, Bandjoun</li>
                    <li><i class="fas fa-phone"></i> +237 600 00 00 00</li>
                    <li><i class="fas fa-envelope"></i> contact@iutfv.cm</li>
                    <li><i class="fas fa-clock"></i> Lun - Ven: 8h - 18h</li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Restez informé de nos dernières actualités</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Votre email" required>
                    <button type="submit" class="btn btn-primary">S'abonner</button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?= date('Y') ?> Laboratoire de Recherche IUT Fotso Victor. Tous droits réservés.</p>
                <p>Développé par URAIA</p>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="btn-back-to-top" title="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- JavaScript -->
    <script src="<?= $base_path ?>js/main.js"></script>
    <script src="<?= $base_path ?>js/filters.js"></script>
    <script src="<?= $base_path ?>js/lang.js"></script>
    <script src="<?= $base_path ?>js/contact.js"></script>
</body>
</html>
