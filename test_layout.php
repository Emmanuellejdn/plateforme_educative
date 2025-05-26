<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Layout - Cours Améliorés</title>
    <style>
        body { 
            margin: 0; 
            font-family: Arial, sans-serif; 
            background: #f5f5f5; 
        }
        .test-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .test-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .test-button {
            background: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .test-button:hover {
            background: #0056b3;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .feature-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🎯 Layout des Cours - Améliorations Appliquées</h1>
        
        <div class="success">
            ✅ <strong>Problème Résolu :</strong> La superposition entre la vidéo et les commentaires a été corrigée !
        </div>
        
        <div class="test-card">
            <h2>🔧 Améliorations Apportées</h2>
            
            <div class="features-grid">
                <div class="feature-card">
                    <h3>📱 Layout Responsive</h3>
                    <p>Utilisation de CSS Grid pour une mise en page moderne qui s'adapte à tous les écrans</p>
                </div>
                
                <div class="feature-card">
                    <h3>🎥 Section Vidéo</h3>
                    <p>Vidéo dans un conteneur séparé avec hauteur fixe et coins arrondis</p>
                </div>
                
                <div class="feature-card">
                    <h3>💬 Section Commentaires</h3>
                    <p>Commentaires et likes maintenant dans une section dédiée sous la vidéo</p>
                </div>
                
                <div class="feature-card">
                    <h3>📚 Liste des Cours</h3>
                    <p>Sidebar repositionnée avec scrolling et meilleur espacement</p>
                </div>
            </div>
        </div>
        
        <div class="test-card">
            <h2>🚀 Structure de la Nouvelle Mise en Page</h2>
            <ol>
                <li><strong>Colonne Principale :</strong> Vidéo + Section d'interaction (likes/commentaires)</li>
                <li><strong>Colonne Latérale :</strong> Liste des cours et examens</li>
                <li><strong>Responsive :</strong> Sur petits écrans, les colonnes s'empilent verticalement</li>
            </ol>
        </div>
        
        <div class="test-card">
            <h2>🧪 Tester les Pages Améliorées</h2>
            <p>Cliquez sur les liens ci-dessous pour voir les améliorations en action :</p>
            
            <a href="interfaces/coursfr.php" class="test-button">🇫🇷 Cours de Français</a>
            <a href="interfaces/coursen.php" class="test-button">🇬🇧 Cours d'Anglais</a>
            <a href="interfaces/courslng.php" class="test-button">🌍 Langues Locales</a>
            <a href="test_interface.php" class="test-button">🔬 Interface de Test</a>
        </div>
        
        <div class="test-card">
            <h2>📋 Fonctionnalités Testées</h2>
            <ul>
                <li>✅ Séparation claire entre vidéo et commentaires</li>
                <li>✅ Section d'interaction fonctionnelle (likes + commentaires)</li>
                <li>✅ Layout responsive qui s'adapte aux différentes tailles d'écran</li>
                <li>✅ Navigation fluide entre les sections</li>
                <li>✅ Style moderne avec ombres et coins arrondis</li>
            </ul>
        </div>
        
        <div class="test-card">
            <h2>📱 Compatibilité</h2>
            <p><strong>Desktop :</strong> Layout en 2 colonnes (vidéo/commentaires + liste des cours)</p>
            <p><strong>Tablette :</strong> Colonnes empilées pour une meilleure lisibilité</p>
            <p><strong>Mobile :</strong> Layout vertical optimisé avec vidéo réduite</p>
        </div>
        
        <?php
        session_start();
        if (!isset($_SESSION['auth'])) {
            echo '<div class="test-card">';
            echo '<h3>🔑 Pour Tester Complètement</h3>';
            echo '<p>Connectez-vous d\'abord pour tester les fonctionnalités de commentaires et likes :</p>';
            echo '<a href="interfaces/connexion.php" class="test-button">Se Connecter</a>';
            echo '</div>';
        } else {
            echo '<div class="success">';
            echo '✅ Vous êtes connecté ! Toutes les fonctionnalités sont disponibles.';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
