<?php
include '../backend/backconnexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
   
  <img src="../images/istockphoto-175486420-612x612.webp" alt="">  
<section class="container"> 
    
    <div class="form_container">
  
      <form action="" method="POST">
        <fieldset>
          <center><legend><span>C</span>ampus <span>E</span>ducation</legend></center>
  
         <div class="box">
          <div class="username">
            <label for="username">Nom d'utilisateur ou email:</label>
            <input type="text" id="username" name="username" required placeholder="Entrez votre nom d'utilisateur ou email">
          </div>
          
  
          <div class="mdp">
            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" required placeholder="Votre mot de passe">
  
            <div class="checkbox">
              <input type="checkbox" id="checkbox-id" name="checkbox-name" value="checkbox-value">
              <label for="checkbox-id"> afficher le mot de passe</label>
            </div><br>
  
              <button type="submit">Se connecter </button>
  
          </div>
         </div>
        </fieldset>
      </form>
  
    </div>
</section>
      
<?php if (isset($errorMsg)) { echo '<p style="color:red;text-align:center;">' . $errorMsg . '</p>'; } ?>

</body>
</html>