<?php
set_include_path("./src");
require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/Animal.php");
require_once("view/ApiView.php");
require_once("model/AnimalStorage.php");

class ApiRouter {

    private $controller;

    public function main(AnimalStorage $storage) {
        if (!key_exists('collection', $_GET)) {
            $this->processHtmlRequest($storage);
        } else {
            $this->processApiRequest($storage);
        }
    }

    private function processHtmlRequest(AnimalStorage $storage) {
        $feedbackMessage = null;
        if (key_exists('feedback', $_SESSION)) {
            $feedbackMessage = $_SESSION['feedback'];
            unset($_SESSION['feedback']);
        }
   
        $routerInstance = new Router($storage);
        $view = new View($routerInstance, $feedbackMessage);
        $this->controller = new Controller($this, $view, $storage);

        $animalId = key_exists('id', $_GET) ? $_GET['id'] : null;
        $action = key_exists('action', $_GET) ? $_GET['action'] : null;

        if ($action === null) {
            $action = ($animalId === null) ? "accueil" : "voir";
        }

        try {
            switch ($action) {
                case 'accueil':
                    $this->controller->homePage();
                    break;

                case 'liste':
                    $this->controller->showList();
                    break;

                case 'voir':
                    if ($animalId === null) {
                        $view->prepareUnknownActionPage();
                    } else {
                        $this->controller->showInformation($animalId);
                    }
                    break;

                case 'nouveau':
                    $this->controller->createNewAnimal();
                    break;

                case 'sauverNouveau':
                    $this->controller->saveNewAnimal($_POST);
                    break;

                default:
                    $view->prepareUnknownAnimalPage();
                    break;
            }
        } catch (Exception $e) {
            $view->prepareUnexpectedErrorPage();
        }
   
        $view->render();
    }

    private function processApiRequest($storage) {
        $apiView = new ApiView($this, '');
        $this->controller = new Controller($this, $apiView, $storage);

        $collectionType = key_exists('collection', $_GET) ? $_GET['collection'] : '';
        $animalId = key_exists('id', $_GET) ? $_GET['id'] : '';

        if ($collectionType === 'animaux') {
            if ($animalId !== '') {
                $this->controller->showInformation($animalId);
            } else {
                $this->controller->showList();
            }
        } else {
            $apiView->setResponseContent(['error' => 'Invalid collection']);
            $apiView->render();
        }
    }
}
?>
