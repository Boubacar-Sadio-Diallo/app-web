<?php

class Router {

    public function __construct($animalStorage) {
        $this->animalStorage = $animalStorage;
    }

    public function main() {
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Démarrer la session ici, avant toute sortie
        }

        // Vérifier si 'feedback' existe dans la session et le récupérer
        $feedbackSession = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : ''; 
        $_SESSION['feedback'] = '';  // Réinitialiser 'feedback' après son utilisation

        // Créer la vue et le contrôleur
        $view = new View($this, $feedbackSession);  // Passer feedback à la vue
        $controller = new Controller($this,$view, $this->animalStorage);

        // Vérification des paramètres GET
        $animalId = key_exists('id',$_GET) ? $_GET['id'] : null;
        $action = key_exists('action',$_GET)? $_GET['action'] : null;

        // Déterminer l'action par défaut
        if ($action === null) {
            $action = ($animalId === null) ? "accueil" : "voir";
        }

        try {
            // Route vers les actions correspondantes
            switch ($action) {
                case 'accueil':
                    $controller->homePage();
                    break;

                case 'liste':
                    $controller->showList();
                    break;

                case 'voir':
                    if ($animalId === null) {
                        $view->prepareUnknownActionPage();
                    } else {
                        $controller->showInformation($animalId);
                    }
                    break;

                case 'nouveau':
                    $controller->createNewAnimal();
                    break;

                case 'sauverNouveau':
                    $controller->saveNewAnimal($_POST);
                    break;

                default:
                    $view->prepareUnknownAnimalPage();
                    break;
            }
        } catch (Exception $se) {
            // En cas d'exception, afficher une page d'erreur inattendue
            $view->prepareUnexpectedErrorPage();
        }

        // Appel à render après que le contrôleur ait préparé le contenu de la page.
        $view->render();
    }

    // Méthodes pour générer les URLs pour les différentes actions
    public function getAnimalUrl($id) {
        return "?id=" . $id;
    }

    public function homePage() {
        return "./site.php";  // URL pour la page d'accueil
    }

    public function setOfAnimal() {
        return "?action=liste";  // URL pour la liste des animaux
    }

    public function getAnimalCreationURL() {
        return "?action=nouveau";  // URL pour afficher le formulaire de création d'un animal
    }

    public function getAnimalSaveURL() {
        return "?action=sauverNouveau";  // URL pour traiter la sauvegarde du nouvel animal
    }

    // Méthode de redirection avec feedback
    public function POSTredirect($url, $feedback = '') {
        // Stocker le feedback dans la session
        $_SESSION['feedback'] = $feedback;

        // Effectuer la redirection HTTP 303
        header('Location: ' . $url, true, 303);
        die; // Utiliser exit pour arrêter l'exécution après la redirection
    }
}
?>
