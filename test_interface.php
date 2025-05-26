<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Commentaires et Likes</title>
    <link rel="stylesheet" href="css/course_interaction.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-test-tube"></i> Test du Système de Commentaires et Likes</h1>
        
        <?php
        session_start();
        
        // Simuler une session utilisateur pour les tests
        if (!isset($_SESSION['auth'])) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = 1;
            $_SESSION['username'] = 'Testeur';
            echo "<div class='status success'>Session de test créée (Utilisateur ID: 1)</div>";
        }
        ?>
        
        <div class="course-interaction">
            <h2>Cours de Test - ID: 1</h2>
            <input type="hidden" id="course-id" value="1">
            
            <div class="like-section">
                <button id="like-btn" class="like-btn">
                    <i class="far fa-heart"></i> J'aime
                </button>
                <div class="likes-info">
                    <span id="likes-count">0</span> j'aime
                </div>
            </div>
            
            <div class="comments-section">
                <h3><i class="fas fa-comments"></i> Commentaires</h3>
                
                <form id="comment-form" class="comment-form">
                    <textarea name="contenu" placeholder="Testez en ajoutant un commentaire..." required></textarea>
                    <div class="comment-form-actions">
                        <small>Test du système de commentaires</small>
                        <button type="submit" class="comment-submit-btn">
                            <i class="fas fa-paper-plane"></i> Publier
                        </button>
                    </div>
                </form>
                
                <div id="comments-container" class="comments-container">
                    <!-- Les commentaires seront chargés ici -->
                </div>
            </div>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            <h3>Instructions de test :</h3>
            <ol>
                <li>Cliquez sur le bouton "J'aime" pour tester le système de likes</li>
                <li>Ajoutez un commentaire dans la zone de texte</li>
                <li>Vérifiez que les données se mettent à jour en temps réel</li>
                <li>Testez la suppression de commentaires (bouton supprimer)</li>
            </ol>
            
            <h3>Vérifications techniques :</h3>
            <ul>
                <li>✅ Session utilisateur : <?= isset($_SESSION['id']) ? 'Active (ID: '.$_SESSION['id'].')' : 'Inactive' ?></li>
                <li>✅ Fichier backend : <?= file_exists('backend/comments_likes.php') ? 'Présent' : 'Manquant' ?></li>
                <li>✅ Fichier JavaScript : <?= file_exists('js/course_interaction.js') ? 'Présent' : 'Manquant' ?></li>
                <li>✅ Fichier CSS : <?= file_exists('css/course_interaction.css') ? 'Présent' : 'Manquant' ?></li>
            </ul>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="interfaces/coursfr.php" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                <i class="fas fa-arrow-right"></i> Tester sur la page Français
            </a>
            <a href="interfaces/coursen.php" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Tester sur la page Anglais
            </a>
        </div>
    </div>
    
    <script src="js/course_interaction.js"></script>
</body>
</html>
