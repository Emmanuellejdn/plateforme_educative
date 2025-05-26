<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: connexion.php');
    exit;
}
include '../backend/connexionbase.php';

// Récupérer les cours de français
$cours = $bdd->prepare("SELECT * FROM cours WHERE langues = 'fr' ORDER BY date_creation DESC");
$cours->execute();
$coursList = $cours->fetchAll();

// Récupérer les tests liés aux cours de français
$examens = $bdd->prepare("SELECT t.*, c.titre as cours_titre FROM test t 
                         JOIN cours c ON t.cours_id = c.id 
                         WHERE c.langues = 'fr' 
                         ORDER BY t.date_creation DESC");
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
    }    function showNotif() {
        alert('Pas encore prêt !');
    }
    function passerExamen(examenId) {
        alert('Fonctionnalité d\'examen en cours de développement. Examen ID: ' + examenId);
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
            <div id="cours-section">                <div class="videos">
                    <?php if (!empty($coursList) && !empty($coursList[0]['video_url'])): ?>
                        <video src="<?= htmlspecialchars($coursList[0]['video_url']) ?>" width="100%" height="100%" autoplay loop muted preload="auto" controls></video>
                    <?php else: ?>
                        <video src="../images/france.mp4" width="100%" height="100%" autoplay loop muted preload="auto" controls></video>
                    <?php endif; ?>
                    <div class="avis">
                        <div class="i1">
                            <img src="../images/pouces-vers-le-haut.png" alt="" width="30px">
                            <P>J'aime</P>
                        </div>
                        <div class="i1">
                            <img src="../images/bulle.png" alt=""  width="30px">
                            <p>Commenter</p>
                        </div>
                    </div>
                </div>
                <div class="courtitle">
                    <h2>Liste des cours de français</h2>
                </div>                <div class="courlist">
                    <div class="lec">
                        <?php if (!empty($coursList)): ?>
                            <?php foreach($coursList as $cours): ?>
                                <div class="cours-item">
                                    <h3><?= htmlspecialchars($cours['titre']) ?></h3>
                                    <p><strong>Description:</strong> <?= htmlspecialchars($cours['description']) ?></p>
                                    <p><strong>Niveau:</strong> <?= ucfirst($cours['niveau']) ?></p>
                                    <p><strong>Durée:</strong> <?= $cours['duree_minutes'] ?> minutes</p>
                                    <?php if ($cours['video_url']): ?>
                                        <p><strong>Vidéo:</strong> <a href="<?= htmlspecialchars($cours['video_url']) ?>" target="_blank">Voir la vidéo</a></p>
                                    <?php endif; ?>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun cours de français disponible pour le moment.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="examens-section" style="display:none;">
                <div class="courtitle">
                    <h2>Liste des examens de français</h2>
                </div>                <div class="courlist">
                    <div class="lec">
                        <?php if (!empty($examensList)): ?>
                            <?php foreach($examensList as $examen): ?>
                                <div class="examen-item">
                                    <h3><?= htmlspecialchars($examen['titre']) ?></h3>
                                    <p><strong>Cours:</strong> <?= htmlspecialchars($examen['cours_titre']) ?></p>
                                    <p><strong>Description:</strong> <?= htmlspecialchars($examen['description']) ?></p>
                                    <p><strong>Durée:</strong> <?= $examen['duree_minutes'] ?> minutes</p>
                                    <p><strong>Note maximale:</strong> <?= $examen['note_maximale'] ?>/20</p>
                                    <button onclick="passerExamen(<?= $examen['id'] ?>)">Passer l'examen</button>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun examen disponible pour les cours de français.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>