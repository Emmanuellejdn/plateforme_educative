<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: connexion.php');
    exit;
}
include '../backend/connexionbase.php';

// Récupérer les cours d'anglais
$cours = $bdd->prepare("SELECT * FROM cours WHERE langues = 'en' ORDER BY date_creation DESC");
$cours->execute();
$coursList = $cours->fetchAll();

// Récupérer les tests liés aux cours d'anglais
$examens = $bdd->prepare("SELECT t.*, c.titre as cours_titre FROM test t 
                         JOIN cours c ON t.cours_id = c.id 
                         WHERE c.langues = 'en' 
                         ORDER BY t.date_creation DESC");
$examens->execute();
$examensList = $examens->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>cours d'anglais</title>
    <link rel="stylesheet" href="../css/coursen.css">
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
                    <a href="#" onclick="showCours();return false;">My course</a>
                    <a href="#" onclick="showExamens();return false;">Exams</a>
                    <a href="#" onclick="showProfil();return false;">Settings</a>
                    <a href="#" onclick="showNotif();return false;">Notifications</a>
                </li>
            </ul>
        </div>        <div class="content">
            <div id="cours-section">
                <!-- Section vidéo principale -->
                <div class="videos">
                    <?php if (!empty($coursList) && !empty($coursList[0]['video_url'])): ?>
                        <video src="<?= htmlspecialchars($coursList[0]['video_url']) ?>" width="100%" height="100%" autoplay loop muted preload="auto" controls></video>
                        <input type="hidden" id="course-id" value="<?= $coursList[0]['id'] ?>">
                    <?php else: ?>
                        <video src="../images/anglais.mp4" width="100%" height="100%" autoplay loop muted preload="auto" controls></video>
                        <input type="hidden" id="course-id" value="<?= !empty($coursList) ? $coursList[0]['id'] : '3' ?>">
                    <?php endif; ?>
                </div>
                
                <!-- Section d'interaction avec le cours - maintenant séparée -->
                <div class="course-interaction-container">
                    <div class="course-interaction">
                        <div class="like-section">
                            <button id="like-btn" class="like-btn">
                                <i class="far fa-heart"></i> Like
                            </button>
                            <div class="likes-info">
                                <span id="likes-count">0</span> likes
                            </div>
                        </div>
                        
                        <div class="comments-section">
                            <h3><i class="fas fa-comments"></i> Comments</h3>
                            
                            <form id="comment-form" class="comment-form">
                                <textarea name="contenu" placeholder="Share your thoughts about this course..." required></textarea>
                                <div class="comment-form-actions">
                                    <small>Be respectful in your comments</small>
                                    <button type="submit" class="comment-submit-btn">
                                        <i class="fas fa-paper-plane"></i> Post
                                    </button>
                                </div>
                            </form>
                            
                            <div id="comments-container" class="comments-container">
                                <!-- Comments will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="courtitle">
                    <h2>List of English courses</h2>
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
                    <h2>List of English exams</h2>
                </div>
                <div class="courlist">
                    <div class="lec">
                        <?php foreach($examensList as $examen): ?>
                            <p><?= htmlspecialchars($examen['titre']) ?> : <?= htmlspecialchars($examen['questions']) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>        </div>
    </div>
    <script src="../js/course_interaction.js"></script>
</body>
</html>