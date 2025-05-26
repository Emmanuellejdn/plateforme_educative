<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: connexion.php');
    exit;
}
include '../backend/connexionbase.php';

// Récupérer les cours de français
$cours = $bdd->prepare("SELECT * FROM cours WHERE langues = 'fr' ");
$cours->execute();
$coursList = $cours->fetchAll();

// Récupérer les examens (tests) liés au français
$examens = $bdd->prepare("SELECT * FROM test WHERE titre LIKE '%fr%' ");
$examens->execute();
$examensList = $examens->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours de français</title>
    <link rel="stylesheet" href="../css/coursfr.css">
    <script>
    function showExamens() {
        document.getElementById('cours-section').style.display = 'none';
        document.getElementById('examens-section').style.display = 'block';
    }
    function showCours() {
        document.getElementById('cours-section').style.display = 'block';
        document.getElementById('examens-section').style.display = 'none';
    }
    function showProfil() {
        window.location.href = 'profil.php';
    }
    function showNotif() {
        alert('Pas encore prêt !');
    }
    </script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li>
                        <?php
                  if(isset($_SESSION['username'])) {
                    echo "Bienvenue, " . $_SESSION['username'] . "<br>";
                } else {
                    echo "Veuillez vous connecter.";
                }
                ?>
                    <a href="#" onclick="showCours();return false;">Mes cours</a>
                    <a href="#" onclick="showExamens();return false;">Examens</a>
                    <a href="#" onclick="showProfil();return false;">Paramètres</a>
                    <a href="#" onclick="showNotif();return false;">Notifications</a>
                </li>
            </ul>
        </div>
        <div class="content">
            <div id="cours-section">
                <div class="videos">
                    <video src="../images/france.mp4" width="100%" height="100%"  autoplay loop muted preload="auto" controls></video>
                </div>
                <div class="courtitle">
                    <h2>Liste des cours de français</h2>
                </div>
                <div class="courlist">
                    <div class="lec">
                        <?php foreach($coursList as $cours): ?>
                            <p><?= htmlspecialchars($cours['titre']) ?> : <?= htmlspecialchars($cours['description']) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div id="examens-section" style="display:none;">
                <div class="courtitle">
                    <h2>Liste des examens de français</h2>
                </div>
                <div class="courlist">
                    <div class="lec">
                        <?php foreach($examensList as $examen): ?>
                            <p><?= htmlspecialchars($examen['titre']) ?> : <?= htmlspecialchars($examen['questions']) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>