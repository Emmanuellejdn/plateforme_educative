<?php
include '../backend/connexionbase.php';


if(isset($_POST['validate'])){

    if(!empty($_POST['username'])AND !empty($_POST['aemail']) AND !empty($_POST['mdp'])){
        $user_username = htmlspecialchars($_POST['username']);
        $user_aemail = htmlspecialchars($_POST['aemail']);
        $user_mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

        // verification si déjà inscrit
        $checkIfUserAlreadyExist = $bdd->prepare('SELECT nom FROM utilisateur WHERE nom = ?');
        $checkIfUserAlreadyExist ->execute(array($user_username));

        if($checkIfUserAlreadyExist->rowCount() == 0){
            $insertUserOnWebsite = $bdd->prepare('INSERT INTO utilisateur(nom,email,motdepasse)VALUES(?, ?, ?)');
            $insertUserOnWebsite ->execute(array($user_username, $user_aemail, $user_mdp));

        // Récupération de l'utilisateur par son ID tout juste inséré
        $lastUserId = $bdd->lastInsertId();
        $getInfosOfThisUser = $bdd->prepare('SELECT id, nom, email FROM utilisateur WHERE id = ?');
        $getInfosOfThisUser->execute(array($lastUserId));

        $userinfos = $getInfosOfThisUser->fetch();
        var_dump($userinfos);
        if ($userinfos) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $userinfos['id'];
            $_SESSION['username'] = $userinfos['nom'];
            $_SESSION['aemail'] = $userinfos['email'];
            header('Location: ../interfaces/acceuil.php ');
            exit;
        } else {
            $errorMsg = "Erreur lors de la récupération des informations utilisateur.";
        }

        }else{
            $errorMsg = "L'utilisateur existe déjà";
        }
    }else{
        $errorMsg = "Veuillez remplir tous les champs";
    }

}