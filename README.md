# Plateforme Éducative Bilingue

## Description
Plateforme d'apprentissage en ligne supportant le français, l'anglais et les langues locales avec système de tests et d'administration.

## Structure de la base de données

La base de données `education` contient les tables suivantes :

- **utilisateur** : Gestion des utilisateurs (élèves et administrateurs)
- **cours** : Stockage des cours par langue
- **test** : Tests associés aux cours
- **utilisateur_cours** : Suivi des inscriptions et progrès
- **resultats_test** : Résultats des examens
- **commentaire** : Commentaires sur les cours
- **likes** : Système de "j'aime" pour les cours
- **notifications** : Notifications utilisateur

## Installation

1. **Démarrer WAMP/XAMPP**
   - Assurez-vous que Apache et MySQL sont en fonctionnement

2. **Créer la base de données**
   - Ouvrez phpMyAdmin (http://localhost/phpmyadmin)
   - Exécutez le script `setup_database.sql`

3. **Configurer la connexion**
   - Vérifiez les paramètres dans `backend/connexionbase.php`
   - Par défaut : serveur=localhost, database=education, user=root, password=""

4. **Tester l'installation**
   - Accédez à http://localhost:8080/plateforme_educative/test_db.php
   - Vérifiez que toutes les tables sont créées

## Comptes de test

### Administrateur
- Email : admin@education.com
- Mot de passe : password

### Élève
- Email : jean@test.com
- Mot de passe : password

## Pages principales

- **/** : Redirection vers la connexion
- **/interfaces/connexion.php** : Page de connexion
- **/interfaces/Inscription.php** : Page d'inscription
- **/interfaces/acceuil.php** : Page d'accueil après connexion
- **/interfaces/admin.php** : Interface d'administration
- **/interfaces/coursfr.php** : Cours de français
- **/interfaces/coursen.php** : Cours d'anglais
- **/interfaces/courslng.php** : Cours de langues locales

## Fonctionnalités

### Pour les élèves
- Inscription et connexion
- Accès aux cours par langue
- Visualisation de vidéos
- Passage de tests
- Système de commentaires et likes

### Pour les administrateurs
- Gestion des utilisateurs
- Gestion des cours (ajout, suppression, filtrage)
- Statistiques de la plateforme
- Filtrage des cours par langue

## Technologies utilisées

- **Backend** : PHP 7+, MySQL
- **Frontend** : HTML5, CSS3, JavaScript, jQuery
- **Serveur** : Apache (WAMP/XAMPP)

## Structure des fichiers

```
plateforme_educative/
├── backend/
│   ├── connexionbase.php      # Connexion DB
│   ├── backconnexion.php      # Authentification
│   ├── backins.php            # Inscription
│   └── admin_backend.php      # Fonctions admin
├── interfaces/
│   ├── connexion.php          # Page de connexion
│   ├── acceuil.php           # Page d'accueil
│   ├── admin.php             # Interface admin
│   ├── coursfr.php           # Cours français
│   ├── coursen.php           # Cours anglais
│   └── courslng.php          # Cours langues locales
├── css/                       # Feuilles de style
├── images/                    # Ressources multimédia
├── setup_database.sql         # Script de création DB
└── test_db.php               # Test de connexion DB
```

## Notes importantes

1. Les mots de passe sont hachés avec `password_hash()` en PHP
2. Le système utilise des sessions PHP pour l'authentification
3. Les requêtes SQL sont préparées pour éviter les injections
4. Les langues supportées : 'fr' (français), 'en' (anglais), 'lng' (locales)

## Dépannage

Si vous rencontrez des problèmes :

1. Vérifiez que WAMP/XAMPP est démarré
2. Testez la connexion DB avec test_db.php
3. Vérifiez les logs d'erreur PHP
4. Assurez-vous que la base de données 'education' existe
5. Vérifiez les permissions de fichiers
