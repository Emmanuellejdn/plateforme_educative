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
    <link rel="stylesheet" href="../css/acceuil.css">
    <title>Acceuil</title>
</head>
<body>
  <header>
    <!-- debut navbar -->
      <div class="navbar">

        <div class="navbar-logos">
            <p><span>C</span>ampus<span>E</span>ducation</p>
        </div>        <div class="navbar-liens">
            <a href="#" class="l1">Accueil</a>
            <a href="#apropos" class="l2">À propos</a>
            <div class="user-info">
                <?php
                if(isset($_SESSION['username'])) {
                    echo "<span class='welcome-msg'>Bienvenue, " . htmlspecialchars($_SESSION['username']) . "</span>";
                    echo "<a href='profil.php' class='profile-link'>Mon Profil</a>";
                    echo "<a href='../backend/logout.php' class='logout-btn'>Déconnexion</a>";
                } else {
                    echo "<a href='connexion.php'>Se connecter</a>";
                    echo "<a href='Inscription.php'>S'inscrire</a>";
                }
                ?>
            </div>
        </div>
        
      </div>
      <!--fin navbar  -->
     <!-- debut carousel -->
      <div class="carousel-inner">

          <div class="carousel-item active">
            <img src="../images/read-3048651_1280.jpg" width= 100% height="540vh"  alt="maintenance">
            <div class="gradient-overlay"></div>            <div class="carousel-caption"> 
              <h1>Commencez votre apprentissage dès aujourd'hui</h1> <br>
              <p>Découvrez une nouvelle façon d'apprendre les langues avec Campus Education.<br>
                 Notre plateforme innovante vous offre des cours interactifs adaptés à votre rythme.<br>
                 Que vous soyez débutant ou confirmé, nos méthodes pédagogiques modernes vous accompagnent vers la réussite.</p> 
            </div>

          </div>

          <div class="carousel-item">
            <img src="../images/ai-generated-9295105_1280.jpg" width= 100% height="540vh" alt="img2">
            <div class="gradient-overlay"></div>            <div class="carousel-caption"> 
              <h1>Apprenez à votre rythme</h1> <br>
              <p>Avec Campus Education, vous contrôlez votre apprentissage.<br>
                 Accédez à vos cours 24h/24, 7j/7 depuis n'importe quel appareil.<br>
                 Progressez selon votre emploi du temps et vos objectifs personnels.</p> 
            </div>

          </div>

          <div class="carousel-item">
            <img src="../images/istockphoto-175486420-612x612.webp" width= 100% height="540vh"  alt="img3">
            <div class="gradient-overlay"></div>            <div class="carousel-caption"> 
              <h1>Un apprentissage trilingue et multiculturel</h1> <br>
              <p>Maîtrisez le français et l'anglais tout en découvrant la richesse des langues locales.<br>
                 Notre approche multiculturelle vous permet de développer vos compétences linguistiques<br>
                 dans un environnement respectueux de votre patrimoine culturel.</p> 
            </div>

          </div>

          <div class="carousel-item">
            <img src="../images/ai-generated-8601128_1280.png" width= 100% height="540vh"  alt="img4">
            <div class="gradient-overlay"></div>            <div class="carousel-caption"> 
              <h1>Peu importe votre niveau de départ</h1> <br>
              <p>Que vous soyez débutant complet ou que vous souhaitiez perfectionner vos compétences,<br>
                nos cours s'adaptent à votre niveau. Nos tests de positionnement vous orientent<br>
                vers les modules les plus appropriés pour optimiser votre progression.</p> 
          </div>

        </div>

        <div class="carousel-item">
          <img src="../images/adult-education-3812693_1280.jpg" width= 100% height="540vh" alt="img5">
          <div class="gradient-overlay"></div>          <div class="carousel-caption"> 
            <h1>Rejoignez notre communauté d'apprenants !</h1> <br>
            <p>Faites partie d'une communauté dynamique d'étudiants motivés.<br>
              Partagez vos expériences, participez à des discussions enrichissantes<br>
              et célébrez vos réussites avec des apprenants du monde entier.</p>
          </div>
          </div> 

        </div>
      </div>
     </div> <br><br>

  <!-- fin carousel -->
  </header>
  <!-- main -->

<main>

<div class="resume_apropos fade-in" id="apropos">
  <div class="resume_apropos_left">
    <h2>À propos de Campus Education</h2>
    <p>Une plateforme d'apprentissage innovante qui vous permet d'apprendre le français, l'anglais et les langues locales à votre rythme. <br>Rejoignez notre communauté d'apprenants passionnés.</p>
  </div>

  <div class="resume_apropos_right">
    <p>Découvrez nos cours interactifs, passez des tests pour évaluer vos progrès <br> et profitez d'une expérience d'apprentissage personnalisée.</p>
    <a href="#presentations"><button>Découvrir nos cours</button></a>
  </div>
</div>

<div class="solutions slide-up">
  <div class="S1">
    <img src="../images/icons8_goal_1.ico" alt="Objectifs" width="50">
    <h3>Objectifs clairs</h3>
    <p>Définissez vos objectifs d'apprentissage et suivez vos progrès.</p>
  </div>
  <div class="S2">
    <img src="../images/icons8_idea_1.ico" alt="Innovation" width="50">
    <h3>Méthodes innovantes</h3>
    <p>Apprenez avec des méthodes modernes et interactives.</p>
  </div>
  <div class="S3">
    <img src="../images/icons8_service_2.ico" alt="Support" width="50">
    <h3>Support personnalisé</h3>
    <p>Bénéficiez d'un accompagnement adapté à vos besoins.</p>
  </div>
</div>

<section class="presentations fade-in" id="presentations"><div class="francais">
    <img src="../images/a-book-7010438_1280.webp" alt="Cours de français" height="100%" width="65%">
    <div class="txt"> 
      <h3>Français</h3>
      <p>Apprentissage spécialisé en français quand vous voulez, où vous voulez. Maîtrisez la grammaire, enrichissez votre vocabulaire et perfectionnez votre expression.</p>
      <a href="coursfr.php" class="course-btn">Commencer maintenant</a>
    </div>
   </div>
   <div class="anglais">
    <img src="../images/school-7421663_1280.webp" alt="Cours d'anglais" height="100%" width="65%">
    <div class="txt"> 
      <h3>English</h3>
      <p>Specialized English learning whenever you want, wherever you want. Master grammar, expand your vocabulary and improve your communication skills.</p>
      <a href="coursen.php" class="course-btn">Start now</a>
    </div>
   </div>
   <div class="locales">
    <img src="../images/ai-generated-9295105_1280.jpg" alt="Langues locales" height="100%" width="65%">
    <div class="txt"> 
      <h3>Langues Locales</h3>
      <p>Renouer avec ses racines et découvrir la richesse des langues locales. Apprenez le Wolof, le Peul et d'autres langues de votre région.</p>
      <a href="courslng.php" class="course-btn">Découvrir maintenant</a>
    </div>
   </div>
</section>
</main>

<footer>
  <div class="footer-content">
    <div class="footer-section">
      <h3>Campus Education</h3>
      <p>Votre plateforme d'apprentissage multilingue pour maîtriser le français, l'anglais et les langues locales.</p>
    </div>
    <div class="footer-section">
      <h3>Nos Cours</h3>
      <ul>
        <li><a href="coursfr.php">Français</a></li>
        <li><a href="coursen.php">Anglais</a></li>
        <li><a href="courslng.php">Langues Locales</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h3>Support</h3>
      <ul>
        <li><a href="profil.php">Mon Profil</a></li>
        <li><a href="#apropos">À Propos</a></li>
        <li><a href="mailto:support@campuseducation.com">Contact</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 Campus Education. Tous droits réservés.</p>
  </div>
</footer>





  <script src="../js/acceuil.js"></script>
</body>
</html>