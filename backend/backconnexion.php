<?php
// session_start();
include '../backend/connexionbase.php';

if (isset($_POST['validate'])) {
    if (!empty($_POST['username']) && !empty($_POST['mdp'])) {
        $user_input = htmlspecialchars($_POST['username']);
        $user_password = $_POST['mdp'];

        // Vérification si l'utilisateur existe (par nom ou email)
        $checkUser = $bdd->prepare('SELECT * FROM utilisateur WHERE nom = ? OR email = ?');
        $checkUser->execute(array($user_input, $user_input));

        if ($checkUser->rowCount() > 0) {
            $user = $checkUser->fetch();

            // Vérification du mot de passe
            if (password_verify($user_password, $user['motdepasse'])) {
                // Authentification réussie, création de la session
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['nom'];
                $_SESSION['aemail'] = $user['email'];

                // Redirection vers la page d'accueil
                header('Location: ../interfaces/acceuil.php');
                exit;
            } else {
                $errorMsg = "Mot de passe incorrect.";
            }
        } else {
            $errorMsg = "Utilisateur non trouvé.";
        }
    } else {
        $errorMsg = "Veuillez remplir tous les champs.";
    }
}
?>
