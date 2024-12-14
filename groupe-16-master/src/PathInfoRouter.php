<?php
set_include_path("./src");
require_once('view/View.php');
require_once('control/Controller.php');
require_once('model/AnimalStorageStub.php');
require_once('model/AnimalStorageSession.php');
class PathInfoRouter {

    public function __construct($animalStorage) {
		$this->animalStorage = $animalStorage;
	}

    public function main() {
        // Récupérer le "path info"
        $pathInfo = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : '';        // Diviser le path en segments (exemple : "/voir/123" devient ["voir", "123"])
        $pathSegments = explode('/', $pathInfo);
        var_export($pathInfo);
        // Récupérer l'action et l'id de l'animal à partir du path
        $action = isset($pathSegments[0]) ? $pathSegments[0] : 'accueil';    $animalId = isset($pathSegments[1]) ? $pathSegments[1] : null; // ID de l'animal, s'il existe
        // Vérifier si une session est déjà active
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $feedbackSession = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
        $_SESSION['feedback'] = '';
        $view = new View($this,$feedbackSession);

        $controller = new Controller($view, $this->animalStorage);

        //$animalId = key_exists('id', $_GET) ? $_GET['id'] : null;
        //$action = key_exists('action', $_GET) ? $_GET['action'] : null;

        if ($action === null) {
            $action = ($animalId === null) ? "accueil" : "voir";
        }

        try {
            switch ($action) {
                case 'accueil':
                    $controller->homePage();
                    break;

                case 'liste':
                    $controller->showList();
                    break;

                case 'voir':
                    if ($animalId === null) {
                        $this->view->prepareUnknownActionPage();
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
            $view->prepareUnexpectedErrorPage();
        }

        // Appel à render après que le contrôleur ait préparé le contenu de la page.
        $view->render();
    }

    public function getAnimalUrl($id) {
        return "/voir/".$id;
    }

    public function homePage() {
        return ".";
    }

    public function setOfAnimal() {
        return "/liste";
    }
    // Méthode pour obtenir l'URL de la page de création d'un animal
    public function getAnimalCreationURL() {
        return "/nouveau";  // URL pour afficher le formulaire de création
    }

    // Méthode pour obtenir l'URL pour sauvegarder le nouvel animal
    public function getAnimalSaveURL() {
        return "/sauverNouveau";  // URL pour traiter la sauvegarde du nouvel animal
    }
    
    public function POSTredirect($url, $feedback = '') {
        // Démarrer la session si elle n'est pas déjà active

        // Stocker le feedback dans la session
        $_SESSION['feedback'] = $feedback;

        // Effectuer la redirection HTTP 303
        header('Location: ' . $url, true, 303);
        exit;
    }
}
?>