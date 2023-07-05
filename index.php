<?php

// Inclusion du fichier s'occupant de la connexion à la DB (TODO)
require __DIR__.'/inc/db.php'; // Pour __DIR__ => http://php.net/manual/fr/language.constants.predefined.php
require __DIR__.'/inc/fonctions.php';
// Rappel : la variable $pdo est disponible dans ce fichier
//          car elle a été créée par le fichier inclus ci-dessus

// Initialisation de variables (évite les "NOTICE - variable inexistante")
$videogameList = array();
$platformList = array();
$name = '';
$editor = '';
$release_date = '';
$platform = '';


// Si le formulaire a été soumis
if (!empty($_POST)) {
    // Récupération des valeurs du formulaire dans des variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $editor = isset($_POST['editor']) ? $_POST['editor'] : '';
    $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
    $platform = isset($_POST['platform']) ? intval($_POST['platform']) : 0;
    
   
    $name = valid_donnees($_POST["name"]);
    $editor = valid_donnees($_POST["editor"]);
    $release_date = valid_donnees($_POST["release_date"]);
    $platform = valid_donnees($_POST["platform"]);
    $platform++; //on ajoute 1 car la valeur de la plateforme est décalée de 1 dans la base de données
    

    if (!empty($name)   
         
        && strlen($name) <= 30
        && !empty($editor)
        && strlen($editor) <= 30
        && !empty($release_date)
        //&& valideDate($release_date)
        && !empty($platform)
        && filter_var($platform, FILTER_VALIDATE_INT)){

            // --- END OF YOUR CODE ---
            echo('test');
    // Insertion en DB du jeu video
    $insertQuery = ("INSERT INTO `videogame`(`name`, `editor`, `release_date`, `platform_id`)
    VALUES ('{$name}', '{$editor}', '{$release_date}', {$platform})");
    
    // TODO #3 exécuter la requête qui insère les données

    $pdo->exec($insertQuery);
    
  
    header("location:index.php");    
    
    }

    // --- END OF YOUR CODE ---
}

// Liste des consoles de jeux
// TODO #4 (optionnel) récupérer cette liste depuis la base de données

/* $platformList = array(
    1 => 'PC',
    2 => 'MegaDrive',
    3 => 'SNES',
    4 => 'PlayStation'
); */
$getPlatformList= "select * from `platform` ";
$pdoStatement = $pdo->query($getPlatformList);
$platformList = $pdoStatement->fetchAll(PDO::FETCH_COLUMN,1);



// TODO #1 écrire la requête SQL permettant de récupérer les jeux vidéos en base de données (mais ne pas l'exécuter maintenant)
/*Sélectionne toutes les valeurs dans la table users*/
$sql = $pdo->prepare("SELECT * FROM `videogame`");


// Si un tri a été demandé, on réécrit la requête
if (!empty($_GET['order'])) {
    // Récupération du tri choisi
    $order = trim($_GET['order']);
    if ($order == 'name') {
        // TODO #2 écrire la requête avec un tri par nom croissant
        // --- START OF YOUR CODE ---
        $sql = $pdo->prepare("SELECT * FROM `videogame` ORDER BY `name`");
        ;
        // --- END OF YOUR CODE ---
    }
    else if ($order == 'editor') {
        // TODO #2 écrire la requête avec un tri par editeur croissant
        // --- START OF YOUR CODE ---

        $sql = $pdo->prepare("SELECT * FROM `videogame` ORDER BY `editor`");

        // --- END OF YOUR CODE ---
    }
}
// TODO #1 exécuter la requête contenue dans $sql et récupérer les valeurs dans la variable $videogameList
// --- START OF YOUR CODE ---
$sql->execute();
$videogameList = $sql->fetchAll(PDO::FETCH_ASSOC);

// --- END OF YOUR CODE ---

// Inclusion du fichier s'occupant d'afficher le code HTML
// Je fais cela car mon fichier actuel est déjà assez gros, donc autant le faire ailleurs (pas le métier hein ! ;) )
require __DIR__.'/view/videogame.php';
