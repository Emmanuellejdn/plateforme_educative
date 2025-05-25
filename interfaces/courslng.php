<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours de français</title>
    <link rel="stylesheet" href="../css/courslng.css">
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
                    <a href="">Mes cours</a>
                    <a href="">Examens</a>
                    <a href="">Certificats</a>
                    <a href="">Paramètres</a>
                    <a href="">Notifications</a>
                </li>
            </ul>
        </div>
        <div class="content">
            <div class="videos">
                <video src="../images/Apprendre le JavaScript  Chapitre 1, Introduction.mp4" width="100%" height="100%"  autoplay loop muted preload="auto" controls></video>
            </div>
            <div class="courtitle">
                <h2>Leçon 1 : L'alphabet et la prononciation</h2>
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
            <div class="courlist">
                <div class="lec">
                    <p>Leçon 1 : L'alphabet et la prononciation</p>
                    <p>Leçon 2 : Les salutations et présentations</p>
                    <p>Leçon 3 : Les nombres et les dates</p>
                    <p>Leçon 4 : Les couleurs et les adjectifs <br> courants</p>
                    <p>Leçon 5 : Les verbes essentiels et leur conjugaison</p>
                    <p>Leçon 6 : Les articles et les pronoms</p>
                    <p>Leçon 7 : Les prépositions et leurs <br> usages</p>
                    <p>Leçon 8 : La construction des phrases <br> simples</p>
                    <p>Leçon 9 : Les expressions courantes et idiomatiques</p>
                    <p>Leçon 10 : Les bases de la communication orale</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>