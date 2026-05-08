-- Base de données labnet pour le Laboratoire de Recherche IUT Fotso Victor Bandjoun
-- Compatible MySQL 8.x / MariaDB

CREATE DATABASE IF NOT EXISTS labnet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE labnet;

-- Table laboratoire
CREATE TABLE IF NOT EXISTS laboratoire (
    idlab INT(2) PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    description TEXT,
    budget VARCHAR(50),
    sourcebudget VARCHAR(100),
    logo VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table equipe
CREATE TABLE IF NOT EXISTS equipe (
    numero INT(4) PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    domaine VARCHAR(100),
    chef VARCHAR(100),
    effectif INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table membre (chercheur)
CREATE TABLE IF NOT EXISTS membre (
    idmembre INT(10) PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    genre VARCHAR(10),
    specialite VARCHAR(100),
    photo VARCHAR(100),
    role VARCHAR(50),
    idbureau INT(2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table bureau
CREATE TABLE IF NOT EXISTS bureau (
    idbureau INT(2) PRIMARY KEY AUTO_INCREMENT,
    directeur VARCHAR(100),
    secretaire VARCHAR(100),
    tresorier VARCHAR(100),
    charge_communication VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table mandat (période du bureau)
CREATE TABLE IF NOT EXISTS mandat (
    id INT(2) PRIMARY KEY AUTO_INCREMENT,
    idbureau INT(2),
    periode VARCHAR(100),
    duree INT,
    budget BIGINT,
    bilan TEXT,
    statut VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (idbureau) REFERENCES bureau(idbureau) ON DELETE CASCADE
);

-- Table projet
CREATE TABLE IF NOT EXISTS projet (
    idpro INT(10) PRIMARY KEY AUTO_INCREMENT,
    idlab INT(2),
    intitule VARCHAR(200),
    domaine VARCHAR(100),
    description TEXT,
    priorite VARCHAR(20),
    datedebut DATE,
    datefin DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (idlab) REFERENCES laboratoire(idlab) ON DELETE CASCADE
);

-- Table collaboration (bailleur / financeur)
CREATE TABLE IF NOT EXISTS collaboration (
    idcol INT(2) PRIMARY KEY AUTO_INCREMENT,
    nom_organisme VARCHAR(100),
    pays VARCHAR(50),
    interlocuteur VARCHAR(100),
    telephone BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table participer (projet ↔ bailleur)
CREATE TABLE IF NOT EXISTS participer (
    idpro INT(10),
    idcol INT(2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (idpro, idcol),
    FOREIGN KEY (idpro) REFERENCES projet(idpro) ON DELETE CASCADE,
    FOREIGN KEY (idcol) REFERENCES collaboration(idcol) ON DELETE CASCADE
);

-- Table intervenir (projet ↔ chercheur)
CREATE TABLE IF NOT EXISTS intervenir (
    idpro INT(10),
    idmembre INT(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (idpro, idmembre),
    FOREIGN KEY (idpro) REFERENCES projet(idpro) ON DELETE CASCADE,
    FOREIGN KEY (idmembre) REFERENCES membre(idmembre) ON DELETE CASCADE
);

-- Table affecter (chercheur ↔ équipe)
CREATE TABLE IF NOT EXISTS affecter (
    idmembre INT(10),
    numero INT(4),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (idmembre, numero),
    FOREIGN KEY (idmembre) REFERENCES membre(idmembre) ON DELETE CASCADE,
    FOREIGN KEY (numero) REFERENCES equipe(numero) ON DELETE CASCADE
);

-- Table publications
CREATE TABLE IF NOT EXISTS publications (
    idpub INT(4) PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(50),
    titre VARCHAR(300),
    auteurs VARCHAR(300),
    source VARCHAR(300),
    cover VARCHAR(100),
    contenu TEXT,
    annee VARCHAR(10),
    iduser BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (iduser) REFERENCES users(id) ON DELETE CASCADE
);

-- Table users (authentification)
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    specialite VARCHAR(100) NULL,
    photo VARCHAR(100) NULL,
    role TINYINT DEFAULT 0,
    password VARCHAR(255),
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table requetes (messages contact)
CREATE TABLE IF NOT EXISTS requetes (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    email VARCHAR(100),
    objet VARCHAR(200),
    description TEXT,
    statut VARCHAR(20) DEFAULT 'non lu',
    admin VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table document (rapports, livrables liés aux projets)
CREATE TABLE IF NOT EXISTS document (
    iddoc INT(10) PRIMARY KEY AUTO_INCREMENT,
    idpro INT(10),
    titre VARCHAR(200),
    type VARCHAR(50),
    fichier VARCHAR(100),
    auteur VARCHAR(100),
    contributeurs VARCHAR(255),
    mots_cles VARCHAR(255),
    datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (idpro) REFERENCES projet(idpro) ON DELETE CASCADE
);

-- Table ressource (matériel/outils du labo)
CREATE TABLE IF NOT EXISTS ressource (
    idres INT(10) PRIMARY KEY AUTO_INCREMENT,
    designation VARCHAR(100),
    type VARCHAR(50),
    description TEXT,
    image VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table education (formations données)
CREATE TABLE IF NOT EXISTS education (
    id INT(2) PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50),
    matiere VARCHAR(100),
    niveau VARCHAR(50),
    responsable VARCHAR(100),
    description TEXT,
    duree INT,
    datedebut DATE,
    datefin DATE,
    cout BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Insertion des données exemples

-- Laboratoire
INSERT INTO laboratoire (nom, description, budget, sourcebudget, logo) VALUES
('Laboratoire de Recherche IUT Fotso Victor', 'Laboratoire de recherche dédié aux technologies innovantes et à l''intelligence artificielle appliquée.', '5000000 FCFA', 'Ministère de l''Enseignement Supérieur', 'logo_lab.png');

-- Équipes
INSERT INTO equipe (nom, domaine, chef, effectif) VALUES
('Équipe IA & Data Science', 'Intelligence Artificielle, Machine Learning', 'Dr. KAMGA Pierre', 8),
('Équipe Réseaux & Sécurité', 'Réseaux informatiques, Cybersécurité', 'Pr. NGUIMFO Eric', 6),
('Équipe Génie Logiciel', 'Développement web, Mobile, Cloud', 'Dr. TCHUENTE Maurice', 10);

-- Bureau
INSERT INTO bureau (directeur, secretaire, tresorier, charge_communication) VALUES
('Prof. FOTSING Victor', 'Mme. KENGNE Alice', 'M. DJOUMO François', 'Dr. MBAHOU Sylvie');

-- Mandat
INSERT INTO mandat (idbureau, periode, duree, budget, bilan, statut) VALUES
(1, '2024-2027', 3, 15000000, 'Bilan positif avec augmentation des publications', 'actif');

-- Membres (chercheurs)
INSERT INTO membre (nom, prenom, email, genre, specialite, photo, role, idbureau) VALUES
('KAMGA', 'Pierre', 'pierre.kamga@iutfv.cm', 'H', 'Intelligence Artificielle', 'kamga.jpg', 'Enseignant-Chercheur', 1),
('NGUIMFO', 'Eric', 'eric.nguimfo@iutfv.cm', 'H', 'Réseaux & Sécurité', 'nguimfo.jpg', 'Enseignant-Chercheur', NULL),
('TCHUENTE', 'Maurice', 'maurice.tchuente@iutfv.cm', 'H', 'Génie Logiciel', 'tchuente.jpg', 'Enseignant-Chercheur', NULL),
('MBAHOU', 'Sylvie', 'sylvie.mbahou@iutfv.cm', 'F', 'Communication Scientifique', 'mbahou.jpg', 'Chargée de Communication', 1),
('DJOMOU', 'François', 'francois.djoumo@iutfv.cm', 'H', 'Comptabilité & Gestion', 'djoumo.jpg', 'Trésorier', 1),
('KENGNE', 'Alice', 'alice.kengne@iutfv.cm', 'F', 'Administration', 'kengne.jpg', 'Secrétaire', 1),
('FOTSING', 'Victor', 'victor.fotsing@iutfv.cm', 'H', 'Direction Générale', 'fotsing.jpg', 'Directeur', 1),
('MOUAFO', 'Jean', 'jean.mouafo@iutfv.cm', 'H', 'Machine Learning', 'mouafo.jpg', 'Doctorant', NULL),
('TELA', 'Marie', 'marie.tela@iutfv.cm', 'F', 'Data Science', 'tela.jpg', 'Doctorante', NULL),
('NKOUNKOU', 'Paul', 'paul.nkounkou@iutfv.cm', 'H', 'Cybersécurité', 'nkounkou.jpg', 'Master Recherche', NULL);

-- Affectation chercheurs aux équipes
INSERT INTO affecter (idmembre, numero) VALUES
(1, 1), (2, 2), (3, 3), (8, 1), (9, 1), (10, 2);

-- Projets
INSERT INTO projet (idlab, intitule, domaine, description, priorite, datedebut, datefin) VALUES
(1, 'IA pour l''Agriculture Camerounaise', 'Intelligence Artificielle', 'Développement d''un système IA pour optimiser les rendements agricoles', 'Haute', '2024-01-15', '2026-12-31'),
(1, 'Sécurisation des Infrastructures Universitaires', 'Cybersécurité', 'Audit et sécurisation des réseaux de l''IUT Fotso Victor', 'Moyenne', '2024-03-01', '2025-06-30'),
(1, 'Plateforme E-Learning Adaptative', 'Génie Logiciel', 'Création d''une plateforme d''apprentissage adaptatif pour étudiants', 'Haute', '2024-06-01', '2025-12-31');

-- Collaboration (bailleurs)
INSERT INTO collaboration (nom_organisme, pays, interlocuteur, telephone) VALUES
('MINESUP Cameroun', 'Cameroun', 'Ministre Jacques Fame Ndongo', 237600000001),
('Agence Française de Développement', 'France', 'Marie Dupont', 33140000001),
('Google Research Africa', 'Afrique du Sud', 'John Smith', 27110000001),
('Université de Yaoundé I', 'Cameroun', 'Prof. Salomé Ndowa', 237600000002);

-- Participation projets-bailleurs
INSERT INTO participer (idpro, idcol) VALUES
(1, 1), (1, 3), (2, 1), (2, 4), (3, 2);

-- Intervention chercheurs sur projets
INSERT INTO intervenir (idpro, idmembre) VALUES
(1, 1), (1, 8), (1, 9), (2, 2), (2, 10), (3, 3);

-- Users (authentification)
INSERT INTO users (name, email, specialite, photo, role, password) VALUES
('Administrateur', 'admin@iutfv.cm', 'Administration', 'admin.jpg', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Pierre Kamga', 'pierre.kamga@iutfv.cm', 'Intelligence Artificielle', 'kamga.jpg', 0, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Eric Nguimfo', 'eric.nguimfo@iutfv.cm', 'Réseaux & Sécurité', 'nguimfo.jpg', 0, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Publications
INSERT INTO publications (type, titre, auteurs, source, cover, contenu, annee, iduser) VALUES
('Article', 'Machine Learning pour la Prédiction des Rendements Agricoles au Cameroun', 'KAMGA P., MOUAFO J., TELA M.', 'Journal of African AI Research', 'pub1.jpg', 'Cette étude présente un modèle de machine learning pour prédire les rendements du maïs et du manioc...', '2024', 2),
('Conférence', 'Sécurisation des Réseaux Universitaires en Afrique Centrale', 'NGUIMFO E., NKOUNKOU P.', 'Proceedings ICNS 2024', 'pub2.jpg', 'Analyse des vulnérabilités réseau dans les universités camerounaises et solutions proposées...', '2024', 3),
('Thèse', 'Optimisation des Algorithmes de Recommandation pour l''E-Learning', 'TCHUENTE M.', 'Université de Dschang', 'pub3.jpg', 'Thèse de doctorat sur les systèmes de recommandation adaptatifs...', '2023', 1),
('Article', 'Deep Learning appliqué à la Reconnaissance Faciale', 'MOUAFO J., KAMGA P.', 'International Journal of Computer Vision', 'pub4.jpg', 'Nouvelle approche de reconnaissance faciale adaptée aux populations africaines...', '2024', 2),
('Rapport', 'État de la Cybersécurité dans les Institutions Académiques', 'NGUIMFO E.', 'Rapport Technique MINESUP', 'pub5.jpg', 'Rapport complet sur l''état de la sécurité informatique...', '2024', 3);

-- Documents
INSERT INTO document (idpro, titre, type, fichier, auteur, contributeurs, mots_cles) VALUES
(1, 'Rapport Intermédiaire Projet IA Agricole', 'Rapport', 'rapport_ia_agri.pdf', 'KAMGA P.', 'MOUAFO J., TELA M.', 'IA, agriculture, machine learning'),
(2, 'Audit Sécurité Réseau IUT', 'Audit', 'audit_securite.pdf', 'NGUIMFO E.', 'NKOUNKOU P.', 'cybersécurité, audit, réseau'),
(3, 'Spécifications Plateforme E-Learning', 'Spécifications', 'specs_elearning.pdf', 'TCHUENTE M.', '', 'e-learning, plateforme, spécifications');

-- Ressources
INSERT INTO ressource (designation, type, description, image) VALUES
('Serveur Dell PowerEdge R740', 'Serveur', 'Serveur haute performance pour calcul IA', 'serveur_dell.jpg'),
('Switch Cisco Catalyst 9300', 'Réseau', 'Switch managed 48 ports Gigabit', 'switch_cisco.jpg'),
('Workstation HP Z8 G4', 'Poste de travail', 'Station de travail pour développement et test', 'workstation_hp.jpg'),
('Imprimante 3D Ultimaker S5', 'Équipement', 'Imprimante 3D pour prototypage rapide', 'imprimante3d.jpg');

-- Éducation
INSERT INTO education (code, matiere, niveau, responsable, description, duree, datedebut, datefin, cout) VALUES
('INF401', 'Intelligence Artificielle Avancée', 'Master 2', 'Dr. KAMGA Pierre', 'Cours approfondi sur les algorithmes d''IA et leurs applications', 45, '2024-09-01', '2024-12-15', 50000),
('INF302', 'Sécurité des Réseaux', 'Licence 3', 'Pr. NGUIMFO Eric', 'Introduction aux concepts de cybersécurité', 30, '2024-09-01', '2024-11-30', 35000),
('INF205', 'Développement Web Full-Stack', 'Licence 2', 'Dr. TCHUENTE Maurice', 'Formation complète HTML, CSS, JS, PHP, MySQL', 60, '2024-09-01', '2025-01-31', 40000);

-- Requetes (messages contact exemple)
INSERT INTO requetes (nom, email, objet, description, statut, admin) VALUES
('Jean MBALLA', 'jean.mballa@email.cm', 'Demande de collaboration', 'Nous souhaitons collaborer avec votre laboratoire sur un projet IA...', 'lu', 'Administrateur'),
('Marie NGOULLE', 'marie.ngoulle@universite.fr', 'Information stage', 'Je suis intéressée par un stage de recherche dans votre équipe...', 'non lu', NULL);
