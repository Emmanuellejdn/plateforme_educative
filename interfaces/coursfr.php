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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Cours de français</title>
    <link rel="stylesheet" href="../css/coursfr.css">
    <link rel="stylesheet" href="../css/course_interaction.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <?php if(isset($_SESSION['username'])) { echo "Bienvenue, " . $_SESSION['username'] . "<br>"; } else { echo "Veuillez vous connecter."; } ?>
                    <a href="#" onclick="showCours();return false;">Mes cours</a>
                    <a href="#" onclick="showExamens();return false;">Examens</a>
                    <a href="#" onclick="showProfil();return false;">Paramètres</a>
                    <a href="#" onclick="showNotif();return false;">Notifications</a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <div id="cours-section" class="cours-flex">
                <div class="left-block">
                    <div class="videos">
                        <?php if (!empty($coursList) && !empty($coursList[0]['video_url'])): ?>
                            <video src="<?= htmlspecialchars($coursList[0]['video_url']) ?>" controls autoplay loop muted preload="auto"></video>
                            <input type="hidden" id="course-id" value="<?= $coursList[0]['id'] ?>">
                        <?php else: ?>
                            <video src="../images/france.mp4" controls autoplay loop muted preload="auto"></video>
                            <input type="hidden" id="course-id" value="<?= !empty($coursList) ? $coursList[0]['id'] : '1' ?>">
                        <?php endif; ?>
                    </div>
                    <div class="course-interaction">
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
                                <textarea name="contenu" placeholder="Partagez votre avis sur ce cours..." required></textarea>
                                <div class="comment-form-actions">
                                    <small>Soyez respectueux dans vos commentaires</small>
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
                </div>
                <div class="right-block">
                    <div class="courtitle">
                        <h2>Liste des cours de français</h2>
                    </div>
                    <div class="courlist">
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
            </div>
            <div id="examens-section" style="display:none;">
                <div class="courtitle">
                    <h2>Liste des examens de français</h2>
                </div>
                <div class="courlist">
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
    <script src="../js/course_interaction.js"></script>
</body>
</html>