<?php
// Script pour ajouter des données de test pour les commentaires et likes
include 'backend/connexionbase.php';

try {
    // Vérifier si la base de données existe et les tables sont créées
    $stmt = $bdd->query("SHOW TABLES LIKE 'commentaire'");
    if ($stmt->rowCount() == 0) {
        echo "Table commentaire non trouvée. Exécutez d'abord setup_database.sql<br>";
        exit;
    }

    $stmt = $bdd->query("SHOW TABLES LIKE 'likes'");
    if ($stmt->rowCount() == 0) {
        echo "Table likes non trouvée. Exécutez d'abord setup_database.sql<br>";
        exit;
    }

    // Ajouter quelques commentaires de test
    $comments = [
        [1, 1, "Excellent cours de français ! J'ai beaucoup appris sur la grammaire de base."],
        [2, 1, "Les explications sont très claires, merci pour ce contenu de qualité."],
        [1, 3, "Great English course! The pronunciation exercises are very helpful."],
        [2, 3, "I love the interactive approach of this English learning method."],
        [1, 5, "Très intéressant d'apprendre le Wolof, ça me reconnecte à mes racines."],
        [2, 5, "Le cours sur les langues locales est enrichissant culturellement."]
    ];

    echo "<h2>Ajout de commentaires de test...</h2>";
    foreach ($comments as $comment) {
        $stmt = $bdd->prepare("INSERT IGNORE INTO commentaire (utilisateur_id, cours_id, contenu) VALUES (?, ?, ?)");
        if ($stmt->execute($comment)) {
            echo "✓ Commentaire ajouté pour le cours {$comment[1]}<br>";
        }
    }

    // Ajouter quelques likes de test
    $likes = [
        [1, 1], // User 1 likes cours 1
        [2, 1], // User 2 likes cours 1
        [1, 3], // User 1 likes cours 3
        [2, 3], // User 2 likes cours 3
        [1, 5], // User 1 likes cours 5
    ];

    echo "<h2>Ajout de likes de test...</h2>";
    foreach ($likes as $like) {
        $stmt = $bdd->prepare("INSERT IGNORE INTO likes (utilisateur_id, cours_id) VALUES (?, ?)");
        if ($stmt->execute($like)) {
            echo "✓ Like ajouté: utilisateur {$like[0]} -> cours {$like[1]}<br>";
        }
    }

    echo "<br><h2>Statistiques actuelles :</h2>";
    
    // Afficher les statistiques
    $stmt = $bdd->query("SELECT COUNT(*) as total FROM commentaire");
    $totalComments = $stmt->fetch()['total'];
    echo "Total commentaires: $totalComments<br>";

    $stmt = $bdd->query("SELECT COUNT(*) as total FROM likes");
    $totalLikes = $stmt->fetch()['total'];
    echo "Total likes: $totalLikes<br>";

    $stmt = $bdd->query("SELECT c.titre, COUNT(co.id) as nb_comments, COUNT(l.id) as nb_likes 
                         FROM cours c 
                         LEFT JOIN commentaire co ON c.id = co.cours_id 
                         LEFT JOIN likes l ON c.id = l.cours_id 
                         GROUP BY c.id, c.titre");
    
    echo "<br><h3>Détails par cours :</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Cours</th><th>Commentaires</th><th>Likes</th></tr>";
    
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
        echo "<td>" . $row['nb_comments'] . "</td>";
        echo "<td>" . $row['nb_likes'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<br><p><strong>✅ Données de test ajoutées avec succès !</strong></p>";
    echo "<p><a href='interfaces/connexion.php'>Se connecter pour tester</a></p>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
}
?>
