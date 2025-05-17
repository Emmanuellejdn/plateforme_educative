
<?php
require('../backend/backins.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>

 <section class="container">
  <div class="left">
    <img src="../images/WhatsApp Image 2025-05-13 à 15.35.46_8bafb41f.jpg" width="50%" height="500rem" alt="">
  </div>

  
  <div class="form_container">

    <form action="" method="POST">
        <center><legend><span>C</span>ampus <span>E</span>ducation</legend></center>

        <?php if(isset($errorMsg)){ echo '<p>'.$errorMsg.'</p>'; } ?>

       <div class="box">
        
        <div class="username">
          <label for="username">Nom d'utilisateur:</label>
          <input type="text" id="username" name="username" required placeholder="Choisissez un nom d'utilisateur">
        </div>
        
        <div class="adresse">
          <label for="aemail">Adresse email:</label>
          <input type="email" id="aemail" name="aemail" required placeholder="Votre adresse email">
        </div>

        <div class="mdp">
          <label for="mdp">Mot de passe:</label>
          <input type="password" id="mdp" name="mdp" required placeholder="Votre mot de passe">

          <div class="checkbox">
            <input type="checkbox" id="checkbox-id" name="checkbox-name" value="checkbox-value">
            <label for="checkbox-id"> afficher le mot de passe</label>
          </div><br>

            <button type="submit" name="validate">s'inscrire</button>

        </div>
          <div class="connexion">
            <p>Vous avez déjà un compte ? <a href="connexion.php">Connectez vous !!!</a></p>
          </div>

       </div>
      <!-- </fieldset> -->
    </form>

  </div>
  
</body>
</html>