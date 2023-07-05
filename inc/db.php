<?php

// TODO #1 créer un objet PDO permettant de se connecter à la base de données "videogame"
// et le stocker dans la variable $pdo
// --- START OF YOUR CODE ---

$servername = 'localhost';
$username = 'videogame';
$password = 'videogame';
$bdd = "videogame";

//On essaie de se connecter
try {
  $pdo = new PDO("mysql:host=$servername;dbname=$bdd", $username, $password);
  //On définit le mode d'erreur de PDO sur Exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
/*On capture les exceptions si une exception est lancée et on affiche
 *les informations relatives à celle-ci*/ catch (PDOException $e) {
  echo "Erreur : " . $e->getMessage();
}

// --- END OF YOUR CODE ---
