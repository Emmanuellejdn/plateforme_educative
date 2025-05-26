<?php
// session_start();
$serveur = 'localhost';
$database = 'education';
$username = 'root';
$pass = '';

$bdd =  new PDO ("mysql:host=$serveur; dbname=$database; charset=utf8",$username,$pass);
?>
