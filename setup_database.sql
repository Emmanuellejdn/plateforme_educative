-- Création de la base de données
CREATE DATABASE IF NOT EXISTS education CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE education;

-- 1. Table utilisateur
CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    motdepasse VARCHAR(255) NOT NULL,
    role ENUM('eleve', 'admin') DEFAULT 'eleve',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table cours
CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    langues VARCHAR(20) NOT NULL,
    video_url VARCHAR(500),
    duree_minutes INT DEFAULT 0,
    niveau ENUM('debutant', 'intermediaire', 'avance') DEFAULT 'debutant',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table de liaison utilisateur_cours (pour suivre les cours)
CREATE TABLE utilisateur_cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    cours_id INT NOT NULL,
    progres DECIMAL(5,2) DEFAULT 0.00,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    derniere_consultation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE,
    UNIQUE KEY unique_inscription (utilisateur_id, cours_id)
);

-- 4. Table test
CREATE TABLE test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cours_id INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    questions JSON,
    duree_minutes INT DEFAULT 30,
    note_maximale INT DEFAULT 20,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE
);

-- 5. Table resultats_test (pour stocker les résultats des élèves)
CREATE TABLE resultats_test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    test_id INT NOT NULL,
    note_obtenue DECIMAL(5,2),
    reponses JSON,
    date_passage DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES test(id) ON DELETE CASCADE
);

-- 6. Table commentaire
CREATE TABLE commentaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    cours_id INT NOT NULL,
    contenu TEXT NOT NULL,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE
);

-- 7. Table likes
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    cours_id INT NOT NULL,
    date_like DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (utilisateur_id, cours_id)
);

-- 8. Table notifications (optionnel)
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    message TEXT,
    lu BOOLEAN DEFAULT FALSE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
);

-- Insertion de données d'exemple
INSERT INTO utilisateur (nom, email, motdepasse, role) VALUES
('Admin', 'admin@education.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Jean Dupont', 'jean@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eleve');

INSERT INTO cours (titre, description, langues, video_url, niveau) VALUES
('Introduction au Français', 'Cours de base pour apprendre le français', 'fr', '../images/france.mp4', 'debutant'),
('Français Intermédiaire', 'Grammaire et conjugaison française', 'fr', '../images/france.mp4', 'intermediaire'),
('English Basics', 'Learn English fundamentals', 'en', '../images/english.mp4', 'debutant'),
('Advanced English', 'Advanced English grammar and vocabulary', 'en', '../images/english.mp4', 'avance'),
('Langues Locales - Wolof', 'Introduction au Wolof', 'lng', '../images/local.mp4', 'debutant'),
('Langues Locales - Peul', 'Bases du Peul', 'lng', '../images/local.mp4', 'debutant');

INSERT INTO test (cours_id, titre, description, questions) VALUES
(1, 'Test Français Débutant', 'Évaluation des bases du français', '{"questions": [{"question": "Comment dit-on bonjour?", "options": ["Hello", "Bonjour", "Hola"], "correct": 1}]}'),
(3, 'English Beginner Test', 'Basic English evaluation', '{"questions": [{"question": "How do you say hello?", "options": ["Bonjour", "Hello", "Hola"], "correct": 1}]}');

-- Index pour optimiser les performances
CREATE INDEX idx_cours_langues ON cours(langues);
CREATE INDEX idx_utilisateur_cours_user ON utilisateur_cours(utilisateur_id);
CREATE INDEX idx_commentaire_cours ON commentaire(cours_id);
CREATE INDEX idx_likes_cours ON likes(cours_id);
