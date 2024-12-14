<?php
// Démarrage de la session au tout début du script
session_start();

// Configuration de l'inclusion des fichiers
set_include_path("./src");
/* Inclusion des classes utilisées dans ce fichier */
require_once("PathInfoRouter.php");
require_once("model/AnimalStorageMySQL.php");
require_once("/users/diallo2210/private/mysql_config.php");

try {
    // Initialisation de la connexion à la base de données avec une instance PDO
    $pdo = new PDO(
        'mysql:host=' . MYSQL_HOST . ';
        dbname=' . MYSQL_DB . ';
        charset=utf8', 
        MYSQL_USER, 
        MYSQL_PASSWORD
    );
    // Paramètres pour la gestion des erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de l'instance de stockage des animaux avec la connexion PDO
    $storage = new AnimalStorageMySQL($pdo);

} catch (PDOException $e) {
    // En cas d'échec de la connexion, afficher un message d'erreur
    die("Erreur : Impossible de se connecter à la base de données. " . $e->getMessage());
}

/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */

// Création d'une instance de Router et lancement de la méthode main
$router = new Router($storage);
$router->main();
?>
