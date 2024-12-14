<?php
require_once("model/Animal.php");
require_once("model/AnimalBuilder.php");
require_once("ApiRouter.php");

class ApiView {
    private $routerInstance;
    private $responseContent = [];

    public function __construct($router) {
        $this->routerInstance = $router;
    }

    // Cette méthode permet de définir le contenu de la réponse JSON
    public function setResponseContent($content) {
        $this->responseContent = $content;
    }

    // Cette méthode génère et envoie la réponse JSON, y compris la gestion des erreurs
    public function render() {
        // Si une erreur est présente, un code HTTP spécifique est défini
        if (isset($this->responseContent['errorMessage'])) {
        }
        header('Content-Type: application/json');
        echo json_encode($this->responseContent, JSON_PRETTY_PRINT);
    }

    // Méthode pour préparer une réponse en cas d'animal introuvable
    public function prepareUnknownAnimalPage() {
        $this->setResponseContent(['errorMessage' => 'Animal non disponible']);
        $this->render();
    }

    // Méthode pour générer une liste d'animaux au format JSON
    public function prepareListPage($animalsList) {
        $formattedAnimals = [];
        foreach ($animalsList as $id => $animal) {
            // Prépare chaque animal sous un format structuré
            $formattedAnimals[] = [
                'id' => $id,  
                'name' => $animal->getNom()
            ];
        }
        $this->setResponseContent($formattedAnimals);
        $this->render();
    }

    // Préparer et envoyer les détails d'un animal spécifique en réponse JSON
    public function prepareAnimalPage($name, $species, $age) {
        if ($name) {
            // Si le nom de l'animal existe, envoyer ses détails
            $this->setResponseContent([
                'name' => $name,
                'species' => $species,
                'age' => $age
            ]);
        } else {
            // Si l'animal n'est pas trouvé, envoyer un message d'erreur
            $this->setResponseContent(['errorMessage' => 'Animal not found']);
        }
        $this->render();
    }
}
?>
