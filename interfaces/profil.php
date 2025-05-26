<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: connexion.php');
    exit;
}
include '../backend/connexionbase.php';

// Récupérer les informations de l'utilisateur
$userId = $_SESSION['id'];
$query = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
$query->execute(array($userId));
$user = $query->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Campus Education</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            max-width: 800px;
        }
        .header {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            border-bottom: 2px solid orangered;
            text-align: center;
        }
        .header h1 {
            color: orangered;
            margin-bottom: 10px;
        }
        .profil-content {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .profil-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .profil-info h2 {
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .profil-info p {
            margin: 10px 0;
            font-size: 16px;
        }
        .profil-info strong {
            display: inline-block;
            width: 150px;
            color: #555;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .actions a {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            color: white;
            background-color: orangered;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .actions a:hover {
            background-color: #ff3300;
        }
        .actions a.secondary {
            background-color: #666;
        }
        .actions a.secondary:hover {
            background-color: #555;
        }
        .cours-list {
            margin-top: 20px;
        }
        .cours-list h3 {
            margin-bottom: 10px;
            color: #333;
        }
        .cours-list ul {
            list-style: none;
        }
        .cours-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mon Profil</h1>
            <p>Gérez vos informations personnelles et vos préférences</p>
        </div>
        
        <div class="profil-content">
            <div class="profil-info">
                <h2>Informations personnelles</h2>
                <p><strong>Nom d'utilisateur:</strong> <?= htmlspecialchars($user['nom']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
               
            </div>
            
            <?php
            // Récupérer les cours suivis par l'utilisateur (exemple à adapter selon ta structure de BDD)
            $coursSuivis = $bdd->prepare("SELECT c.* FROM cours c 
                                         JOIN cours c ON c.id = c.cours_id 
                                         WHERE c.utilisateur_id = ? 
                                         LIMIT 5");
            $coursSuivis->execute(array($userId));
            $mesCours = $coursSuivis->fetchAll();
            ?>
            
            <div class="cours-list">
                <h3>Mes derniers cours</h3>
                <?php if (count($mesCours) > 0): ?>
                    <ul>
                        <?php foreach($mesCours as $cours): ?>
                            <li><?= htmlspecialchars($cours['titre']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Vous n'avez pas encore suivi de cours.</p>
                <?php endif; ?>
            </div>
            
            <div class="actions">
                <a href="acceuil.php">Retour à l'accueil</a>
                <a href="coursfr.php">Cours de français</a>
                <a href="coursen.php">Cours d'anglais</a>
                <a href="courslng.php">Langues locales</a>
                <a href="#" class="secondary" onclick="alert('Cette fonctionnalité sera bientôt disponible!')">Modifier mon profil</a>
            </div>
        </div>
    </div>
</body>
</html>
